<?php
namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\MemberPromo;
use App\Models\PromoCodes;
use App\Models\MemberAddress;
use App\Models\ProductPackageBasic;
use App\Models\ProductPackageStandard;
use App\Models\ProductPackagePremium;

class OrderController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth:Member');
    }


      public function get_totalPrice($ShoppingCart)
      {
          $total_price = 0;
          foreach ($ShoppingCart as $key => $Cart)
          {
              $price = Order::get_product_price($Cart->package,$Cart->product_id);
              $total_price += $price ;
              /* ==== Handl when out of stock ==== */
          }
          return $total_price;
      }

      public function get_points_deduction_price($totalPrice,$use_points)
      {
         if(!$use_points){
           return 0;
         }
         $member = auth('Member')->user();
         $reward_points_price = $member->reward_points ; //$member->reward_points * 0.5;
          if($totalPrice < $reward_points_price)
             return $totalPrice;
          else
            return $reward_points_price;
      }

      //get promo code discount
      public function get_discount()
      {
          $chekPromo = MemberPromo::where( 'member_id',auth('Member')->id() )->where('is_used',0)->first();
          if($chekPromo)
          {
              $promo = PromoCodes::find($chekPromo->promo_id);
              if( $promo->allowed_number_of_usage < $promo->actual_number_of_usage )
              {
                 $chekPromo->delete();
                 return 'last promo has been used';
              }
              $promo_discount_percentage = $promo->discount_percentage??0;
          }
          else {
              $promo_discount_percentage = 0;
          }
          return $promo_discount_percentage;
      }


      public function checkout(Request $request)
      {
        // return $request->all();
              $data = $request->validate([
                // 'payment' => 'required',
                // 'choosen_Address' => '',
                'use_wallet' => '',
              ]);
              // return $request->all();

            $ShoppingCart = ShoppingCart::where( 'member_id',auth('Member')->id() )->limit(200)->get();

            //---if Shopping Cart is Empty---
            if($ShoppingCart->isEmpty()){
              \Session::flash('flash_message','Shopping Cart is Empty ');
              return back();
            }

            $setting = \App\Models\Setting::where('title','minimum_basket_amount')
                            ->orWhere('title','vat_price')
                            ->pluck('value','title');

            $totalPrice = $this->get_totalPrice( $ShoppingCart, $request->all() );

            $discount = $this->get_discount();

            if($discount && $discount == 'last promo has been used' ){
                \Session::flash('flash_message',__('page.last promo has been used'));
                return back();
            }

            // $points_deduction_price = $this->get_points_deduction_price($totalPrice,$request->use_points);
            $points_deduction_price = 0;

            //--points_deduction_price
            $final_price = $totalPrice - $points_deduction_price;
            //--promo code
            $final_price = $final_price - ( ($totalPrice * $discount) / 100 );
            //--Shipping
            // $final_price = $final_price + $setting['shipping_price'];
            //--vat
            $final_price = $final_price + ( ($totalPrice * $setting['vat_price']) / 100 );

            // if( $totalPrice < (int)$setting['minimum_basket_amount'] ){
            //     \Session::flash('flash_message','minimum price is '.$setting['minimum_basket_amount'].' EGP');
            //     return back();
            // }

            $use_wallet = filter_var($request->use_wallet, FILTER_VALIDATE_BOOLEAN);
            //--wallet
            $wallet_deduction = 0;
            if($use_wallet)
            {
                $member_wallet = auth('Member')->user()->wallet;
                if($member_wallet > 0)
                {
                    if($member_wallet >= $final_price){
                        $wallet_deduction = $final_price;
                        $final_price = 0;
                    }
                    else{
                        $wallet_deduction = $member_wallet;
                        $final_price = $final_price - $member_wallet;
                    }
                }
            }
            // return $final_price;

            $recipt_array = [
                'member_id' => auth('Member')->id(),
                'total_price' => $totalPrice,
                'points_deduction_price' => $points_deduction_price ,
                'discount_percentage' => $discount,
                'vat_price' => $setting['vat_price'] ,
                'wallet_deduction' => $wallet_deduction ,
                'final_price' => $final_price,
                'payment_method' => $request->payment_method,
                'security_code' => \Illuminate\Support\Str::random(40),
            ];

            //--for create Order --
              if($request->payment_method == 'creadit_card' && ($final_price > 0) )
              {
                  $recipt_array['is_init_for_card_payment'] = 1;
                  $Order = Order::create($recipt_array);

                  $PaymentAccapt = new \App\Http\Controllers\Site\PaymentAccapt\PaymentAccaptCheckOutController();
                  try {
                    return $PaymentAccapt->init_payment_form($Order);
                  } catch (\Exception $e) {
                    \Log::info('Sorry,initialize checkout payment faild, Please Try again Now', ['Order_id' => $Order->id] );
                    \Session::flash('flash_message','Sorry,initialize payment faild, Please Try again Now');
                    return redirect('ShoppingCart/checkout');
                  }
              }
              else //payment == other
              {
                  $Order = Order::create($recipt_array);
                  return $this->continue_checkout($Order,$ShoppingCart,$discount);
              }
      }

      /*
      * USE after payment done to continue payment
      */
      public static function continue_payment_after_creditcard($order_id)
      {
            $obj = new OrderController;
            $Order = Order::whereId($order_id)->where('is_init_for_card_payment','1')->latest()->first();
            $ShoppingCart = ShoppingCart::where( 'member_id', $Order->member_id )->get();
            $discount = $obj->get_discount($Order->member_id);

            return $obj->continue_checkout($Order,$ShoppingCart,$discount);
      }

      /*
      * cut ShoppingCart to OrderDetails
      * insert discount
      */
      public function continue_checkout($Order,$ShoppingCart,$discount)
      {
//        \DB::transaction(function () use($Order,$ShoppingCart,$discount){

               $Order->update([ 'is_init_for_card_payment' => null ]);

               Order::where('member_id',$Order->member_id)->where('is_init_for_card_payment','1')->delete();

               $OrderDetails = [];
            //--for create Order Products--
            foreach ($ShoppingCart as $key => $Cart)
            {
                $this_product = Product::find($Cart->product_id);
                if( $this_product->is_available == 1 )
                {
                    $produ = [
                        'order_id' => $Order->id,
                        'item_type' => 'product' ,
                        'product_name_en' => $this_product->name_en ,
                        'product_name_ar' => $this_product->name_ar,
                        'product_id' => $this_product->id ,
                        'member_brief' => $Cart->brief_text,
                        'package_type' => $Cart->package,
                        'marketing_brief_id' => $Cart->marketing_brief_id ,
                        'price' => Order::get_product_price($Cart->package,$Cart->product_id)
                    ];
//                     array_push($OrderDetails,$produ);
                    $this_product->increment('selles_times_no');
                    $OrderDetail = OrderDetails::create($produ);
                }//End if
            }//End foreach

//             $OrderDetails_list = OrderDetails::insert($OrderDetails);
            ShoppingCart::where( 'member_id',$Order->member_id )->delete();
            if($discount)
            {
               $myPromo = MemberPromo::where( 'member_id',$Order->member_id )->where('is_used',0)->first();
               $myPromo->update([
                 'is_used' => 1,
                 'used_date' => \Carbon\Carbon::now()
               ]);
               $PromoCode = PromoCodes::find($myPromo->promo_id);
               $PromoCode->increment('actual_number_of_usage');
            }

            \Session::flash('flash_message',__('page.Thank you for purchasing from us'));

            $member = \App\Models\Member::find($Order->member_id);
            //
            //  $member->update([
            //       'reward_points' => $member->reward_points -  $Order->points_deduction_price,
            //      'wallet' => $member->wallet -  $Order->wallet_deduction
            //  ]);

              if($Order->payment_method == 'creadit_card')
              {
                    $Order->update([
                      'payment_method' => 'creadit_card' ,
                      'is_piad' => 1 ,
                    ]);

                    try {
                      \Mail::to([$member->email ])
                            ->send(new \App\Mail\ConfirmOrder($Order,$member));
                    } catch (\Exception $e) {
                        \Log::info('confiramtion email not send', ['Order_id' => $Order->id] );
                    }
              }
              else {
                    try {
                      \Mail::to([$member->email ])
                            ->send(new \App\Mail\ConfirmOrder($Order,$member));
                    }catch (\Exception $e) {
                        \Log::info('confiramtion email not send', ['Order_id' => $Order->id] );
                    }
              }

              return redirect('/History/details/'.$Order->id);
//           });//End DB::transaction

           //when error - put needs test
//           \Session::flash('flash_message', __('page.problem') );
//           return redirect('/ShoppingCart/checkout');

      }


      public function payment_page($Order_id)
      {
          $Order = Order::findOrFail($Order_id);
          return view('Site/payment',compact('Order'));
      }

      public function confirm_is_paid($Order_id,$security_code)
      {
           $Order = Order::whereId($Order_id)->where('security_code',$security_code)->first();
           if($Order)
           {
                $Order->update([
                    'is_piad' => 1
                ]);
                \Session::flash('flash_message',__('page.payment is happend'));
                  return redirect('/');
           }
      }


//++++++++++++++++++++++++++++++++++++++++SART TEsting+++++++++++++++++++++++
public function test_checkout_problem(Request $request)
{


}
//++++++++++++++++++++++++++++++++++++++++End TEsting+++++++++++++++++++++++



}//End class

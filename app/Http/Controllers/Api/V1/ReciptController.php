<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Product;
use App\ShoppingCart;
use App\Recipt;
use App\ReciptProducts;
use App\MemberPromo;
use App\PromoCodes;
use App\MemberAddress;

class ReciptController extends Controller
{
    public function __construct()
    {
        $this->middleware('MemberRequiredJWTAndLang') ;
    }


    public function get_totalPrice($ShoppingCart)
    {
        $total_price = 0;
        foreach ($ShoppingCart as $key => $Cart)
        {
            $price = 0;

            $this_product = Product::find($Cart->product_id);
            $required_quantity = ($Cart->quantity < $this_product->quantity) ? $Cart->quantity : $this_product->quantity;

            if($this_product->quantity <= 0 || !$this_product ){
               continue;
            }

            $price = $this_product->price;
            $total_price += $price * $required_quantity;
            // echo ( '$price = '.$price.' ,  $Cart->quantity = '.$Cart->$required_quantity.' , , $totalPrice = '.$totalPrice.' pro id '.$this_product->name_en  .' <br>' );

        }
        return $total_price;
    }

    public function get_discount($member_id,$selected_city_id=null)
    {
        $chekPromo = MemberPromo::where( 'member_id',$member_id )->where('is_used',0)->first();
        if($chekPromo)
        {
            $promo = PromoCodes::find($chekPromo->promo_id);
            if($selected_city_id && $promo->city_id )
            {
               if($selected_city_id != $promo->city_id)
               {
                  $chekPromo->delete();
                 return 'your city doesnot match';
               }
            }
            $promo_discount_percentage = $promo->discount_percentage??0;
        }
        else {
            $promo_discount_percentage = 0;
        }
        return $promo_discount_percentage;
    }

    public function get_points_deduction_price($member,$totalPrice, $use_points)
    {
        if (!$use_points) {
            return 0;
        }
        $reward_points_price = $member->reward_points; //$member->reward_points * 0.5;
        if ($totalPrice < $reward_points_price)
            return $totalPrice;
        else
            return $reward_points_price;
    }


    public function checkout(Request $request)
    {
            $validator = \Validator::make($request->all(), [
                'payment' => 'required',
                'choosen_Address' => 'required',
                'choosen_Address' => 'required',
                'member_comment' => '',
                'use_points' => '',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 'notValid', 'status_message' => __('api.notValid'), 'missing_data' => $validator->messages()]);
            }
            $AuthMember_id = $request->MemberID;
            // return $request->all();

          $ShoppingCart = ShoppingCart::where( 'member_id',$AuthMember_id )->limit(200)->get();

          //---if Shopping Cart is Empty---
          if($ShoppingCart->isEmpty()){
            return response()->json([
                'status' => 'failed',
                'status_message' => 'Shopping Cart is Empty',
            ]);
          }

          // $setting = \App\Setting::where('title','shipping_price')->orWhere('title','tax_price')
          //            ->orWhere('title','minimum_basket_amount')->orWhere('title','minimum_freeTast_amount')
          //            ->pluck('value','title');
          $setting = \App\Setting::where('title','minimum_basket_amount')->pluck('value','title');

           $addres = MemberAddress::where('member_id',$AuthMember_id )->find($request->choosen_Address);
           $city = \App\City::find($addres->city_id);
           $District = \App\District::find($addres->district_id);

          $totalPrice = $this->get_totalPrice( $ShoppingCart, $request->all() );

          $discount = $this->get_discount( $AuthMember_id , $addres->city_id );
          if($discount && $discount == 'your city doesnot match' ){
            return response()->json([
              'status' => 'failed',
              'status_message' => __('page.city not matched')
            ]);
          }

          $points_deduction_price = $this->get_points_deduction_price($request->Member,$totalPrice, $request->use_points);

          //--points_deduction_price
          $final_price = $totalPrice - $points_deduction_price;

          //--promo code
          $final_price = $final_price - ( ($totalPrice * $discount) / 100 );
          //--Shipping
          // $final_price = $final_price + $setting['shipping_price'];
          //--tax
          // $final_price = $final_price + ( ($totalPrice * $setting['tax_price']) / 100 );


          if( $totalPrice < (int)$setting['minimum_basket_amount'] ){
              return response()->json([
                  'status' => 'failed',
                  'status_message' => 'minimum price is '.$setting['minimum_basket_amount'].' EGP',
              ]);
          }

          $recipt_array = [
              'member_id' => $AuthMember_id,
              'address' => $addres->address,
              'street' => $addres->street,
              'building_no' => $addres->building_no,
              'apartment_no' => $addres->apartment_no,
              'total_price' => $totalPrice,
            // 'shipping_price' => $setting['shipping_price'] ,
            // 'tax_price' => $setting['tax_price'] ,
              'points_deduction_price' => $points_deduction_price,
              'shipping_price' => 0 ,
              'tax_price' => 0 ,
              'discount_percentage' => $discount,
              'final_price' => $final_price,
              'payment_method' => $request->payment,
              'security_code' => \Illuminate\Support\Str::random(40),
              'city' =>  $city->name_en??"-" ,
              'district' => $District->name_en??"-",
              'member_comment' => $request->member_comment ?? null
          ];

          //--for create Recipt --
            if($request->payment == 'creadit_card')
            {
                $recipt_array['is_init_for_card_payment'] = 1;
                $Recipt = Recipt::create($recipt_array);

                $PaymentAccapt = new \App\Http\Controllers\Site\PaymentAccaptController();
                try {
                  return $PaymentAccapt->init_payment_form($Recipt);
                } catch (\Exception $e) {
                  return response()->json([
                    'status' => 'failed',
                    'status_message' => __('page.Sorry, Please Try again Now')
                  ]);
                }
            }
            else //payment == COD
            {
                $Recipt = Recipt::create($recipt_array);
                return $this->continue_checkout($Recipt,$ShoppingCart,$discount);
            }
    }

    /*
    * USE after payment done to continue payment
    */
    public static function continue_payment_after_creditcard($order_id)
    {
          $obj = new ReciptController;
          $Recipt = Recipt::whereId($order_id)->where('is_init_for_card_payment','1')->latest()->first();
          $ShoppingCart = ShoppingCart::where( 'member_id', $Recipt->member_id )->get();
          $discount = $obj->get_discount($Recipt->member_id);

          return $obj->continue_checkout($Recipt,$ShoppingCart,$discount);
    }

    /*
    * cut ShoppingCart to ReciptProducts
    * insert discount
    */
    public function continue_checkout($Recipt,$ShoppingCart,$discount)
    {
           $Recipt->update([
              'is_init_for_card_payment' => null
           ]);

             Recipt::where('member_id',$Recipt->member_id)->where('is_init_for_card_payment','1')->delete();

           $ReciptProducts = [];
          //--for create Recipt Products--
          foreach ($ShoppingCart as $key => $Cart)
          {
              $this_product = Product::find($Cart->product_id);
              if( $this_product->quantity > 0 || !$this_product)
              {
                  //check if selected quantity is not bigger than the stock quantity
                  $required_quantity = ($Cart->quantity < $this_product->quantity) ? $Cart->quantity : $this_product->quantity;
                  $produ = null;
                  $produ = [
                      'recipt_id' => $Recipt->id,
                      'quantity' => $required_quantity ,
                      'product_name_en' => $this_product->name_en ,
                      'product_name_ar' => $this_product->name_ar,
                      'product_id' => $this_product->id ,
                      'cheese_type' => $Cart->cheese_type,
                      'cheese_weight' => $Cart->cheese_weight,
                      'bundle_products_ids' => $this_product->bundle_products_ids,
                      'single_price' => $this_product->price,
                      'total_price' => $this_product->price * $Cart->quantity
                  ];
                   array_push($ReciptProducts, $produ);

                   //---decrease the quantity from the product---
                   $this_product->update([
                       'quantity' => $this_product->quantity - $required_quantity
                       ]);
                    }//End if
            }//End foreach
            ReciptProducts::insert($ReciptProducts);
          ShoppingCart::where( 'member_id',$Recipt->member_id )->delete();
          if($discount)
          {
             $myPromo = MemberPromo::where( 'member_id',$Recipt->member_id )->where('is_used',0)->first();
             $myPromo->update([
               'is_used' => 1,
               'used_date' => \Carbon\Carbon::now()
             ]);
          }

          $member = \App\Member::find($Recipt->member_id);

          $member->update([
            // 'reward_points' => ( $member->reward_points + ceil($Recipt->total_price / 20) ) -  $Recipt->points_deduction_price
              'reward_points' => $member->reward_points -  $Recipt->points_deduction_price
          ]);

          if($Recipt->payment_method == 'creadit_card')
          {
                $Recipt->update([
                  'payment_method' => 'creadit_card' ,
                  'is_piad' => 1 ,
                ]);

                try {
                  \Mail::to($member->email)
                        ->send(new \App\Mail\ConfirmOrder($Recipt,$member));
                } catch (\Exception $e) {

                }
          }
          else {
            try {
              \Mail::to($member->email)
                    ->send(new \App\Mail\ConfirmOrder($Recipt,$member));
            }catch (\Exception $e) {

            }
          }
          return response()->json([
              'status' => 'success',
              'status_message' => __('page.Thank you for purchasing from us'),
          ]);
    }




}

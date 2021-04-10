<?php
namespace App\Http\Controllers\Site\PaymentAccapt;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;



class PaymentAccaptCheckOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:Member')->only('init_payment_form');
    }


   public function accapt_pay_done_get()
   {
        if( isset($_GET['success']) )
        {
            if( $_GET['success'] == 'true' )
            {
              \Session::flash('flash_message', __('page.Cart payment done'));
              return redirect('/History');
            }
            else
            {
              \Session::flash('flash_message', __('page.wrong cart data or problem'));
              return redirect('/ShoppingCart/checkout');
            }
        }
   }

   public function accapt_pay_done_post(Request $request)
   {
         try {
            $data = json_decode($request->createFromGlobals()->getContent(), true);
            $is_success = $data['obj']['success'];
            $get_order_id = $data['obj']['order']['merchant_order_id'];

               if($is_success == 'true')
               {
                  return \App\Http\Controllers\Site\OrderController::continue_payment_after_creditcard($get_order_id);
               }
         } catch (\Exception $e) {

           \Session::flash('flash_message', __('page.incomplete payment process'));
            return redirect('/ShoppingCart');
        }
   }

   public function init_payment_form($Recipt)
   {
            // try {
            //
            // } catch (\Exception $e) {
            //
            // }

            $client = new \GuzzleHttp\Client();


              //====== get Auth token =======
              $authToken_res =   $client->request('POST', 'https://accept.paymobsolutions.com/api/auth/tokens', [
                     'json' => [ //change
                         'api_key' => 'ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SndjbTltYVd4bFgzQnJJam8zTmpnd01Dd2lZMnhoYzNNaU9pSk5aWEpqYUdGdWRDSXNJbTVoYldVaU9pSnBibWwwYVdGc0luMC5CRDN0ck1UZHpad2ZHb0ZjWTJwZDdBRExtblc5cDM2M2luN2RXM0tpRk4xNnFfOUQtWERfRXU4OXJ6S2NWbEZKQ3FlVnhKT3RvSjdKYktKQnY3UTNFZw==',
                     ]
               ]);
               $tokens_array =  json_decode($authToken_res->getBody()->getContents())  ;
               $auth_token = $tokens_array->token;


              //====== get orders =========
              $orders_res =   $client->request('POST', 'https://accept.paymobsolutions.com/api/ecommerce/orders', [
                     'json' => [
                         'auth_token' => $auth_token ,
                         'delivery_needed' => 'true',
                         'merchant_id' => '76800',     //change
                         "merchant_order_id" => $Recipt->id,  //send my data (unique)
                         'amount_cents' => $Recipt->final_price * 100 ,
                         'currency' => 'EGP',
                         'items' => []
                     ]
               ]);
               $order_array = json_decode( $orders_res->getBody()->getContents() );
               $order_id = $order_array->id;

               //====== get payment keys =========
                $name_array = explode(" ", trim( auth('Member')->user()->name ) , 2) ;

               $paymentKey_res =   $client->request('POST', 'https://accept.paymobsolutions.com/api/acceptance/payment_keys', [
                      'json' => [
                          'auth_token' => $auth_token ,
                          'amount_cents' => $Recipt->final_price * 100 ,
                          'order_id' => "$order_id",
                          "billing_data" => [
                                 "apartment" => 'NA',
                                 "email" => auth('Member')->user()->email ,
                                 "floor" => 'NA',
                                 "first_name" => $name_array[0]??'NA',
                                 "street" => 'NA' ,
                                 "building" => 'NA',
                                 "phone_number" => auth('Member')->user()->phone,
                                 "shipping_method" => "PKG",
                                 "postal_code" => "02032",
                                 "city" => "cairo",
                                 "country" => "EG",
                                 "last_name" => $name_array[1]??$name_array[0]??'no name',
                                 "state" => "Utah"
                               ],
                             "currency" =>  "EGP",
                             "integration_id" =>  199128,    //Live =  211311 , test = 199128 , card for test -> https://acceptdocs.paymobsolutions.com/docs/card-payments
                             "lock_order_when_paid" =>  "false"
                      ]
                ]);
                $paymentKey_array = json_decode( $paymentKey_res->getBody()->getContents() );
                $paymentKey_token = $paymentKey_array->token ;
                //------------------change the ifram id below (get it from the dashboard)------------------
                // return \Redirect::to("https://accept.paymobsolutions.com/api/acceptance/iframes/112898?payment_token=$paymentKey_token");
                // return \Redirect::to("https://accept.paymobsolutions.com/api/acceptance/iframes/186763?payment_token=$paymentKey_token");
                return \Redirect::to("https://accept.paymob.com/api/acceptance/iframes/186763?payment_token=$paymentKey_token");

   }

}

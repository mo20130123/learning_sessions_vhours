<?php

namespace App\Http\Controllers\SiteNew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;
use App\ShoppingCart;
use App\MemberPromo;
use App\PromoCodes;
use App\FreeTestList;
use DB;

class Test_payment_Controller extends Controller
{
    public function __construct()
    {

    }


   public function accapt_pay_done_get()
   {
      \App\Setting::create([
          'title' => 'accapt',
          'value' => 'get'
      ]);
      return 'true';
   }

    public function accapt_pay_done_post(Request $request)
   {
      $data = json_decode($request->getContent(), true);


       \App\Setting::create([
           'title' => 'accapt',
           'value' => 'order_id -- '.$data['obj']['order']['merchant_order_id']
       ]);
       return 'true';
   }

   public function index()
   {
            // try {
            //
            // } catch (\Exception $e) {
            //
            // }

            $client = new \GuzzleHttp\Client();


              //====== get Auth token =======
              $authToken_res =   $client->request('POST', 'https://accept.paymobsolutions.com/api/auth/tokens', [
                     'json' => [
                         'api_key' => 'ZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6VXhNaUo5LmV5SnVZVzFsSWpvaWFXNXBkR2xoYkNJc0ltTnNZWE56SWpvaVRXVnlZMmhoYm5RaUxDSndjbTltYVd4bFgzQnJJam8wTkRJMWZRLkFuemV6Z1FDWnM3X2hiSExDZktGNk9seDBXcTRmX3F1emRqaExjdU5WM0JZUVc0Nkk4bnllODczMi0xLUtoR0F3bkZNdWR1ejA1cDZiYk5zMVB1eUF3',
                     ]
               ]);
               $tokens_array =  json_decode($authToken_res->getBody()->getContents())  ;
               $auth_token = $tokens_array->token;


              //====== get orders =========
              $orders_res =   $client->request('POST', 'https://accept.paymobsolutions.com/api/ecommerce/orders', [
                     'json' => [
                         'auth_token' => $auth_token ,
                         'delivery_needed' => 'false',
                         'merchant_id' => '4425',     //change
                         "merchant_order_id" => rand(1111,9999),  //send my data (unique)
                         'amount_cents' => '100' ,
                         'currency' => 'EGP',
                         'items' => []
                     ]
               ]);
               $order_array = json_decode( $orders_res->getBody()->getContents() );
               $order_id = $order_array->id;

               //====== get payment keys =========
               $paymentKey_res =   $client->request('POST', 'https://accept.paymobsolutions.com/api/acceptance/payment_keys', [
                      'json' => [
                          'auth_token' => $auth_token ,
                          'amount_cents' => '100',
                          'order_id' => "$order_id",
                          "billing_data" => [
                                 "apartment" => "8023",
                                 "email" => "mohamed.zayed@vhorus.com",
                                 "floor" => "42",
                                 "first_name" => "zayed",
                                 "street" => "2",
                                 "building" => "hod",
                                 "phone_number" => "0201094943793",
                                 "shipping_method" => "PKG",
                                 "postal_code" => "02032",
                                 "city" => "cairo",
                                 "country" => "EG",
                                 "last_name" => "moahmed",
                                 "state" => "Utah"
                               ],
                             "currency" =>  "EGP",
                             "integration_id" =>  7151,     //change
                             "lock_order_when_paid" =>  "false"
                      ]
                ]);
                $paymentKey_array = json_decode( $paymentKey_res->getBody()->getContents() );
                $paymentKey_token = $paymentKey_array->token ;
                //------------------change the ifram id below (get it from the dashboard)------------------
                return \Redirect::to("https://accept.paymobsolutions.com/api/acceptance/iframes/11464?payment_token=$paymentKey_token");

   }

}

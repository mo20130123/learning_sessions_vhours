<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Member;
use App\Product;
use App\Recipt;
use App\Brand;
use App\ReciptRating;
use DB;

class DashBoardController extends Controller
{
   public function __construct()
   {
     $this->middleware('verifyAdminApiAuth');
   }

     public function index($year)
     {
          $Members_count = Member::count();
          $Products_count = Product::count();
          $Recipts_count = Recipt::whereNull('is_init_for_card_payment')->count();
          // $Brands_count = Brand::count();

          $Recipt_processing_count = Recipt::where('delivery_status','Acknowledged')->whereNull('is_init_for_card_payment')->count();
          $Recipt_shipping_count = Recipt::where('delivery_status','Preparing')->whereNull('is_init_for_card_payment')->count();
          $Recipt_Dispatched_count = Recipt::where('delivery_status','Dispatched')->whereNull('is_init_for_card_payment')->count();
          $Recipt_delivered_count = Recipt::where('delivery_status','Delivered')->whereNull('is_init_for_card_payment')->count();
          $Recipt_canceled_count = Recipt::where('delivery_status','canceled')->whereNull('is_init_for_card_payment')->count();
          $Recipts_sum = Recipt::where('delivery_status','!=','canceled')
                               ->where('delivery_status','!=','Acknowledged')
                               ->where('delivery_status','!=','Preparing')
                               ->whereNull('is_init_for_card_payment')
                               ->sum('final_price');
          $Recipts_sum = round($Recipts_sum);

          $morris_recipts = \DB::select("SELECT count(id) as count , month(`created_at`) as month FROM `recipts` WHERE YEAR(`created_at`) = $year AND `is_init_for_card_payment` IS NULL group BY month(`created_at`) ORDER by `created_at` ASC") ;
          $morris_members = \DB::select("SELECT count(id) as count , month(`created_at`) as month FROM `members` WHERE YEAR(`created_at`) = $year group BY month(`created_at`) ORDER by `created_at` ASC") ;

           $morris_recipts = $this->fill_months($morris_recipts,1);
           $morris_members = $this->fill_months($morris_members);

           $Rating = ReciptRating::select(
                                        DB::raw('COALESCE(cast(AVG(q1) as decimal(4,1)),0) as q1_avg') ,
                                        DB::raw('COALESCE(cast(AVG(q2) as decimal(4,1)),0) as q2_avg') ,
                                        DB::raw('COALESCE(cast(AVG(q3) as decimal(4,1)),0) as q3_avg') ,
                                        DB::raw('COALESCE(cast(AVG(q4) as decimal(4,1)),0) as q4_avg') ,
                                        DB::raw('COALESCE(cast(AVG(q5) as decimal(4,1)),0) as q5_avg')
                                      )
                                 ->first();

          return response()->json([
             'status' => 'success',
             'Members_count' => $Members_count ,
             'Products_count' => $Products_count ,
             'Recipts_count' => $Recipts_count ,
             // 'Brands_count' => $Brands_count ,
             'Brands_count' => 1 ,
             'Recipts_sum' => $Recipts_sum ,

             'Recipt_processing_count' => $Recipt_processing_count ,
             'Recipt_shipping_count' => $Recipt_shipping_count ,
             'Recipt_Dispatched_count' => $Recipt_Dispatched_count ,
             'Recipt_delivered_count' => $Recipt_delivered_count ,
             'Recipt_canceled_count' => $Recipt_canceled_count ,
             'morris_recipts' => $morris_recipts ,
             'morris_members' => $morris_members ,
             'Rating' => $Rating ,
           ]);
     }


     public function fill_months($the_array)
     {
                  $the_collect = collect($the_array);

                  for ($i=1; $i <= 12 ; $i++)
                  {
                           $is_found = false;
                        foreach ($the_array as $key => $array)
                        {
                           if(isset($array->month)){
                              if( $array->month == $i ){
                                 $is_found = true;
                              }
                           }
                        }
                        if(!$is_found){
                               array_push($the_array,[
                                  'count' => 0,
                                  'month' => $i
                               ]);
                        }
                  }

               //--sort-----
              $month = array_column($the_array, 'month');
              array_multisort($month, SORT_ASC, $the_array);

            return $the_array;
     }




}

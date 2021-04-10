<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "site" middleware group. Now create something great!
|
*/
	//
   function changeLang($lang)
   {
      \App::setLocale($lang);
   }

   Route::get('/{lang}',function($lang){
      changeLang($lang);
      return view('Design.home',compact('lang'));
   });


   Route::get('/providers/{lang}',function($lang){
     changeLang($lang);
     return view('Design.providers',compact('lang'));
   });

   Route::get('/best-seller/{lang}',function($lang){
     changeLang($lang);
     return view('Design.best-seller',compact('lang'));
   });

   Route::get('/offers/{lang}',function($lang){
     changeLang($lang);
     return view('Design.offers',compact('lang'));
   });
   Route::get('/providers-inner/{lang}',function($lang){
     changeLang($lang);
     return view('Design.providers-inner',compact('lang'));
   });
   Route::get('/providers-form/{lang}',function($lang){
     changeLang($lang);
     return view('Design.providers-form',compact('lang'));
   });
   Route::get('/all_providers/{lang}',function($lang){
     changeLang($lang);
     return view('Design.all_providers',compact('lang'));
   });
   Route::get('/best-selling/{lang}',function($lang){
     changeLang($lang);
     return view('Design.best-selling',compact('lang'));
   });
   Route::get('/wallet/{lang}',function($lang){
     changeLang($lang);
     return view('Design.wallet',compact('lang'));
   });
   Route::get('/about/{lang}',function($lang){
     changeLang($lang);
     return view('Design.about',compact('lang'));
   });
   Route::get('/ads/{lang}',function($lang){
     changeLang($lang);
     return view('Design.ads',compact('lang'));
   });
   Route::get('/ads-inner/{lang}',function($lang){
     changeLang($lang);
     return view('Design.ads-inner',compact('lang'));
   });

   Route::get('/brief/{lang}',function($lang){
     changeLang($lang);
     return view('Design.brief',compact('lang'));
   });

    //contact page
    Route::get('/contact/{lang}',function($lang){
      changeLang($lang);
      return view('Design.contact',compact('lang'));
    });

 
    //careers pages
    Route::get('/careers-details/{lang}',function($lang){
      changeLang($lang);
      return view('Design.careers.careers-details',compact('lang'));
   });
  

   Route::get('/careers/{lang}',function($lang){
      changeLang($lang);
      return view('Design.careers.careers',compact('lang'));
   });

   //products pages
   Route::get('/products/{lang}',function($lang){
      changeLang($lang);
      return view('Design.products',compact('lang'));
   });
   //products-inner pages
   Route::get('/products-inner/{lang}',function($lang){
      changeLang($lang);
      return view('Design.products-inner',compact('lang'));
   });


   //wish list page
   Route::get('/wish-list/{lang}',function($lang){
      changeLang($lang);
      return view('Design.wish-list',compact('lang'));
   });
 

   //LoginSystem pages
   Route::get('/profile/{lang}',function($lang){
      changeLang($lang);
      return view('Design.profile',compact('lang'));
   });
   //Login
   Route::get('/login/{lang}',function($lang){
      changeLang($lang);
      return view('Design.login',compact('lang'));
   });
   //faqs
   Route::get('/faqs/{lang}',function($lang){
      changeLang($lang);
      return view('Design.faqs',compact('lang'));
   });
   //change-password
   Route::get('/change-password/{lang}',function($lang){
      changeLang($lang);
      return view('Design.change-password',compact('lang'));
   });
   //delivery-policy
   Route::get('/delivery-policy/{lang}',function($lang){
      changeLang($lang);
      return view('Design.delivery-policy',compact('lang'));
   });
   //terms-conditions
   Route::get('/terms-conditions/{lang}',function($lang){
      changeLang($lang);
      return view('Design.terms-conditions',compact('lang'));
   });
   //privacy-policy
   Route::get('/privacy-policy/{lang}',function($lang){
      changeLang($lang);
      return view('Design.privacy-policy',compact('lang'));
   });
   //checkout
   Route::get('/checkout/{lang}',function($lang){
      changeLang($lang);
      return view('Design.checkout',compact('lang'));
   });
   //order-history
   Route::get('/order-history/{lang}',function($lang){
      changeLang($lang);
      return view('Design.order-history',compact('lang'));
   });
   //order-details
   Route::get('/order-details/{lang}',function($lang){
      changeLang($lang);
      return view('Design.order-details',compact('lang'));
   });
   //the-chef-recommendation
   Route::get('/the-chef-recommendation/{lang}',function($lang){
      changeLang($lang);
      return view('Design.the-chef-recommendation',compact('lang'));
   });
   //new-products
   Route::get('/new-products/{lang}',function($lang){
      changeLang($lang);
      return view('Design.new-products',compact('lang'));
   });
   //categorie
   Route::get('/categorie/{lang}',function($lang){
      changeLang($lang);
      return view('Design.categorie',compact('lang'));
   });
   //sub-categorie
   Route::get('/sub-categorie/{lang}',function($lang){
      changeLang($lang);
      return view('Design.sub-categorie',compact('lang'));
   });
   //products-discount
   Route::get('/products-discount/{lang}',function($lang){
      changeLang($lang);
      return view('Design.products-discount',compact('lang'));
   });
   //bundels
   Route::get('/bundels/{lang}',function($lang){
      changeLang($lang);
      return view('Design.bundels',compact('lang'));
   });
   //bundels-inner
   Route::get('/bundels-inner/{lang}',function($lang){
      changeLang($lang);
      return view('Design.bundels-inner',compact('lang'));
   });
   //order-status
   Route::get('/order-status/{lang}',function($lang){
      changeLang($lang);
      return view('Design.order-status',compact('lang'));
   });
   //rating
   Route::get('/rating/{lang}',function($lang){
      changeLang($lang);
      return view('Design.rating',compact('lang'));
   });

   Route::get('/checkout/{lang}',function($lang){
      changeLang($lang);
      return view('Design.checkout',compact('lang'));
   });
   Route::get('/cart-review/{lang}',function($lang){
      changeLang($lang);
      return view('Design.cart-review',compact('lang'));
   });
   Route::get('/recipies/{lang}',function($lang){
      changeLang($lang);
      return view('Design.recipies',compact('lang'));
   });
   Route::get('/recipies-inner/{lang}',function($lang){
      changeLang($lang);
      return view('Design.recipies-inner',compact('lang'));
   });
   
   Route::get('/cart-review/{lang}',function($lang){
      changeLang($lang);
      return view('Design.cart-review',compact('lang'));
   });
   Route::get('register/{lang}',function($lang){
      changeLang($lang);
      return view('Design.register',compact('lang'));
   });
   Route::get('/checkout/{lang}',function($lang){
      changeLang($lang);
      return view('Design.checkout',compact('lang'));
   });
   Route::get('/forgot-password/{lang}',function($lang){
      changeLang($lang);
      return view('Design.forgot-password',compact('lang'));
   });


   Route::get('/careers/{lang}',function($lang){
      changeLang($lang);
      return view('Design.careers',compact('lang'));
   });

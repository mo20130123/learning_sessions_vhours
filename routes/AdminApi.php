<?php

use Illuminate\Support\Facades\Route;


// use Illuminate\Http\Request;

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

function vue_users_routes($route_name,$controller_name)
{
    Route::group(['prefix'=> $route_name ],function()use($controller_name,$route_name){
          Route::post('/list', "$controller_name@get_list");
          Route::get('/switch_contacted/{id}', "$controller_name@switch_contacted");
          Route::get('/delete/{id}', "$controller_name@destroy");
          Route::post('/create', "$controller_name@store");
          Route::post('/update', "$controller_name@update");
          Route::get('/Export', "$controller_name@Export");
    });
}

function vue_control_routes($route_name,$controller_name )
{
    Route::group(['prefix'=> $route_name ],function()use($controller_name,$route_name){
          Route::get('/sort', "$controller_name@sort_view");
          Route::get('/list_without_paginate', "$controller_name@list_without_paginate");
          Route::post('/updateRowsPosition', "$controller_name@updateRowsPosition");
          //---apis---
          Route::get('/selection_data', "$controller_name@selection_data");
          Route::post('/list', "$controller_name@get_list");
          Route::get('/showORhide/{id}', "$controller_name@showORhide");
          Route::get('/switch_in_home/{id}', "$controller_name@switch_in_home");
          Route::get('/delete/{id}', "$controller_name@destroy");
          Route::post('/create', "$controller_name@store");
          Route::post('/update', "$controller_name@update");
    });
}

Route::post('/login', 'Auth\LoginController@admin_login');
Route::get('/check_admin_jwt', 'Auth\LoginController@check_admin_jwt');
Route::get('/DashBoard/{year}', 'DashBoardController@index');

//------Admins--
vue_control_routes('Admin','AdminController');
vue_control_routes('Roles','RoleController');

//-------- vue_users_routes -------
vue_users_routes('ContactUs','ContactUsController');
vue_users_routes('Subscriber','SubscriberController');
vue_users_routes('BecomeProveder','BecomeProvederController');


//-------- vue_control_routes -------
vue_control_routes('SeoKeywords','SeoKeywordsController');
vue_control_routes('City','CityController');
vue_control_routes('HomeSlider','HomeSliderControllerr');
vue_control_routes('Category','CategoryController');
vue_control_routes('BaseProduct','BaseProductController');
vue_control_routes('Country','CountryController');

//--------
vue_control_routes('District','DistrictController');
vue_control_routes('PopularQuestion','PopularQuestionController');
vue_control_routes('PromoCodes','PromoCodesController');
vue_control_routes('TermsAndConditions','TermsController');
vue_control_routes('PrivacyPolicy','PrivacyPolicyController');
vue_control_routes('TermsAndConditions','TermsAndConditionsController');
vue_control_routes('TrustedBy','TrustedByController');
vue_control_routes('Provider','ProviderController');


Route::group(['prefix'=> 'Member' ],function(){
   Route::post('list', 'MemberController@get_list');
   Route::get('destroy/{id}', 'MemberController@destroy');
   Route::get('/selection_data', "MemberController@selection_data");
   Route::get('/Export', "MemberController@Export");
   Route::post('/create', "MemberController@store");
   Route::post('/update', "MemberController@update");
});

Route::group(['prefix'=> 'Applicant' ],function(){
   Route::post('list', 'ApplicantController@get_list');
   Route::get('switch_contacted/{id}', 'ApplicantController@switch_contacted');
});

Route::group(['prefix'=> 'AdsObjectives' ],function(){
   Route::post('list', 'AdsObjectivesController@get_list');
   Route::post('/updateRowsPosition', "AdsObjectivesController@updateRowsPosition");
   Route::post('/AdProduct/update', "AdsObjectivesController@AdProductUpdate");
   Route::get('/show/{id}', "AdsObjectivesController@show");
   Route::get('/AdProduct_showORhide/{id}', "AdsObjectivesController@AdProduct_showORhide");
});

vue_control_routes('Product','ProductControllerr');
Route::group(['prefix'=> 'Product' ],function(){
   Route::get('/Categories_SubCategories', 'ProductControllerr@Categories_SubCategories');
   Route::get('/show/{id}', 'ProductControllerr@show');
   Route::post('/update', 'ProductControllerr@update');
   Route::post('/updateStockWithExcel', 'ProductControllerr@updateStockWithExcel');
   Route::get('/switch_is_chef_rec/{id}', 'ProductControllerr@switch_is_chef_rec');
   Route::get('/switch_is_new/{id}', 'ProductControllerr@switch_is_new');
   Route::get('/list_products_by_category_id/{Category_id}', "ProductControllerr@list_products_by_category_id");
   Route::get('/list_without_paginate/{classification}', 'ProductControllerr@list_without_paginate');
   Route::post('/updateRowsPositionWithclassification/{classification}', 'ProductControllerr@updateRowsPositionWithclassification');
});

vue_control_routes('Bundel','BundelController');
Route::group(['prefix'=> 'Bundel' ],function(){
   Route::get('/show/{id}', 'BundelController@show');
   Route::get('/get_Product_By_Id/{id}', 'BundelController@get_Product_By_Id');
   Route::post('/update', 'BundelController@update');
});

//-----------------* Job *-----------------
vue_control_routes('Job','JobController');
Route::group(['prefix'=> 'Job' ],function(){
   Route::patch('/job_applicants/{id}', "JobController@job_applicants");
   Route::get('/switch_contacted/{id}', "JobController@switch_contacted");
   Route::get('/applicant_destroy/{id}', "JobController@applicant_destroy");
});

Route::group(['prefix'=>'PagesBanner' ],function(){
      Route::post('/list', 'PagesBannerController@get_list');
      Route::post('/update', 'PagesBannerController@update');
});

Route::group(['prefix'=>'Setting' ],function(){
      Route::get('/list', 'SettingController@list');
      Route::post('/update', 'SettingController@update');
});


Route::group(['prefix'=>'Order' ],function(){
      Route::get('/{id}', 'OrderController@show');
      Route::get('print/{id}', 'OrderController@print_show');
      //---apis---
      Route::post('/list', 'OrderController@get_list');
      Route::post('/get_list_with_products', 'OrderController@get_list_with_products');
      Route::get('/details/{order_id}', 'OrderController@details');
      // Route::get('/switchPiad/{id}', 'OrderController@switchPiad');
      Route::post('/changeDeliveryStatus', 'OrderController@changeDeliveryStatus');
      Route::get('/delete/{id}', 'OrderController@destroy');
      Route::get('/print/{id}', 'OrderController@print_show');
      Route::get('/switchPiad/{id}', 'OrderController@switchPiad');
      Route::post('/add_serial_to_recipt', 'OrderController@add_serial_to_recipt');
      Route::post('/updateAdminComment_of_orderDetails', 'OrderController@updateAdminComment_of_orderDetails');
      Route::post('/Add_modification', 'OrderController@Add_modification');
});


Route::group(['prefix'=> 'City'  ],function(){
      Route::get('/', "CityController@index");

      Route::get('/sort', "CityController@sort_view");
      Route::post('/list_without_paginate', "CityController@list_without_paginate");
      Route::post('/updateRowsPosition', "CityController@updateRowsPosition");
      //---apis---
      Route::post('/list', "CityController@get_list");
      Route::get('/showORhide/{id}', "CityController@showORhide");
      Route::get('/switch_in_home/{id}', "CityController@switch_in_home");
      Route::get('/delete/{id}', "CityController@destroy");
      Route::post('/create', "CityController@store");
      Route::post('/update', "CityController@update");
});

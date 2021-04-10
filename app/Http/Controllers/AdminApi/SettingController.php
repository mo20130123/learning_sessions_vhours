<?php


namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Setting;

class SettingController extends Controller
{

    public function __construct()
    {
       $this->middleware('verifyAdminApiAuth');
    }


    public function list()
    {
         $setting = Setting::pluck('value','title') ;
         $setting['aboutus_side_image'] = asset('images/Setting/'.$setting['aboutus_side_image']);
         return $setting;
    }

    public function update(Request $request)
    {
         $validator = \Validator::make($request->all(), [
           'our_location_en' => 'required',
           'our_location_ar' => 'required',
           'facebook_link' => 'required',
           'instagram_link' => 'required',
           // 'linkedin_link' => 'required',
           'our_phone_1' => 'required',
           // 'our_phone_2' => 'required',
           'our_email' => 'required',
           'minimum_basket_amount' => 'required',
           'aboutus_en' => 'required',
           'aboutus_ar' => 'required',

           // 'minimum_freeTast_amount' => 'required',
           // 'tax_price' => 'required',
           // 'shipping_price' => 'required',

         ]);
         if ($validator->fails()) { return response()->json([ 'state' => 'notValid' , 'data' => $validator->messages() ]);  }

         Setting::where('title','our_location_en')->update(['value'=>$request->our_location_en]);
         Setting::where('title','our_location_ar')->update(['value'=>$request->our_location_ar]);
         Setting::where('title','our_phone')->update(['value'=>$request->our_phone]);
         Setting::where('title','facebook_link')->update(['value'=>$request->facebook_link]);
         Setting::where('title','instagram_link')->update(['value'=>$request->instagram_link]);
         // Setting::where('title','linkedin_link')->update(['value'=>$request->linkedin_link]);
         Setting::where('title','our_phone_1')->update(['value'=>$request->our_phone_1]);
         Setting::where('title','our_phone_2')->update(['value'=>$request->our_phone_2]);
         Setting::where('title','our_email')->update(['value'=>$request->our_email]);
         Setting::where('title','minimum_basket_amount')->update(['value'=>$request->minimum_basket_amount]);
         Setting::where('title','aboutus_en')->update(['value'=> parent::remove_quotes($request->aboutus_en)]);
         Setting::where('title','aboutus_ar')->update(['value'=> parent::remove_quotes($request->aboutus_ar)]);
         // Setting::where('title','minimum_freeTast_amount')->update(['value'=>$request->minimum_freeTast_amount]);
         // Setting::where('title','tax_price')->update(['value'=>$request->tax_price]);
         // Setting::where('title','shipping_price')->update(['value'=>$request->shipping_price]);


         if ($request->file('aboutus_side_image'))
         {
             $fileName = rand(11111,99999).'.'.$request->aboutus_side_image->getClientOriginalExtension(); // renameing image
             $destinationPath = public_path('images/Setting');
             $request->aboutus_side_image->move($destinationPath, $fileName); // uploading file to given path
             Setting::where('title','aboutus_side_image')->update(['value'=>$fileName]);
         }

         $Settings = Setting::pluck('value','title') ;
         return response()->json([
           'status' => 'success',
           'data' => $Settings
         ]);
    }


}

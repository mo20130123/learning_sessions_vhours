<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Provider;
use App\Models\PagesBanner;
use App\Models\Product;
use App\Models\BecomeProveder;
use DB;


class ProviderController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $navActive = 'Provider';
          $banner = PagesBanner::select('id',"image$lang as image",'link')
                               ->where('page','Providers') ->first() ;

          return view('Site.Providers.providers-list' ,compact('banner','navActive') );
      }

      public function get_list()
      {
          $lang = \App::getLocale();
          return Provider::select('id',"name_$lang as name", 'logo',
                                DB::raw("CONCAT('".asset('Providers')."/',id,'-',REPLACE(name_$lang,' ','-')) as link") )
             ->where('status',1)
             ->orderBy('position')
             ->paginate(20);
      }

      public function show($id)
      {
          $lang = \App::getLocale();
          $Provider = Provider::select('*',"overview_$lang as overview")->where('status',1)->where('id',$id)->first();

          $Products = Product::productsMinimal()
                             ->where('is_bundle',0)
                             ->where('provider_id', $id)
                             ->orderBy('position')
                             ->limit(5)
                             ->get();


          return view('Site.Providers.providers_details' , compact('Provider','Products' ) );
      }

      public function BecomeProviderPage()
      {
          return view( 'Site.Providers.providers-form' );
      }

      public function BecomeProviderAction(Request $request)
      {
          // return $request->all();
          $data = $request->validate([
            'CompanyName' => 'required',
            'CompanySize' => 'required',
            'CompanyType' => 'required',
            'Website' => 'required',
            'Industry' => 'required',
            'Location' => 'required',
            'no_products' => 'required',
            'TargetMarket' => 'required',
            'FirstName' => 'required',
            'LastName' => 'required',
            'ContactEmail' => 'required',
            'JobTitle' => 'required',
            'mobile' => 'required',
        ]);

          $ContactUs = BecomeProveder::create($data);

        \Session::flash('flash_message', __('api.Thank you for your interest in DeleDael') );

          // try {
          //     \Mail::to('info@superdelionline.com')
          //     ->send(new \App\Mail\ContactUs($ContactUs));
          // } catch (\Exception $e) {
          // }

        return redirect('');
      }

}

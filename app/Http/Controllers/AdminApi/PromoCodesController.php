<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\vueAdminController;

use App\Models\PromoCodes;
// use App\City;

class PromoCodesController extends vueAdminController
{

    public function __construct()
    {
       parent::__construct();
       $this->set_model_name('PromoCodes');

       $this->search_attrs =  [
            'id' , 'code'
       ];

       $this->store_attrs =  [
           'discount_percentage' => 'required',
           'code' => 'required|unique:promo_codes',
           'from_date' => 'required',
           'to_date' => 'required',
           'allowed_number_of_usage' => 'required',
           'allowed_number_per_user' => 'required',
       ];
    }//End __construct




    //---api----
    // public function get_list(Request $request)
    // {
    //      $search = $request->search;
    //      $data = PromoCodes::select('promo_codes.*','cities.name_en as city_name')
    //       ->where(function($q)use($search){
    //           if ($search)
    //             $q->where('code','like','%'.$search.'%')->orWhere('discount_percentage','like','%'.$search.'%')->orWhere('promo_codes.id',$search);
    //       })
    //       ->leftJoin('cities','cities.id','promo_codes.city_id')
    //       ->groupBy('promo_codes.id')
    //       ->latest('promo_codes.id')->paginate();
    //       return collect(['status' => 'success'])->merge($data);
    // }
    //
    //
    // //--api--
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'required',
            'discount_percentage' => 'required',
            'code' => 'required|unique:promo_codes,code,'.$request->id,
            'from_date' => 'required',
            'to_date' => 'required',
            'allowed_number_of_usage' => 'required',
            'allowed_number_per_user' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $item = PromoCodes::findOrFail($request->id);
        // $request->merge(['code'=> rand(11111,99999) ]);
        $item->update($request->except('_token'));
        return response()->json([
          'status' => 'success',
          'data' => $item
        ]);
    }


}

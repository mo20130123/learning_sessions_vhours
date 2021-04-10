<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\ReciptRating;
use App\Recipt;

class RateController extends Controller
{
      public function index()
      {
          if(!auth('Member')->user()->should_rate_order_id)
          {
            return redirect('');
          }

          auth('Member')->user()->update([
             'should_rate_order_id' => null
          ]);
          return view('Site.Rating');
      }

      public function add_rating_to_latest_member_order(Request $request)
      {
          $validator = \Validator::make($request->all(), [
            'q1' => 'required',
            'q2' => 'required',
            'q3' => 'required',
            'q4' => 'required',
            'q5' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $Recipt = Recipt::where('member_id',auth('Member')->id())
                          ->where('delivery_status','Delivered')->latest()->first();

          ReciptRating::create([
             'recipt_id' => $Recipt->id ,
             'q1' => $request->q1,
             'q2' => $request->q2,
             'q3' => $request->q3,
             'q4' => $request->q4,
             'q5' => $request->q5,
             'comment' => $request->comment,
          ]);

          \Session::flash('flash_message', __('page.Thank you for your time') );

          return response()->json([
            'status' => 'success',
            // 'status_message' => __('api.register_phone')
          ]);

      }



}

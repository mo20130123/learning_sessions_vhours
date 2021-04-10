<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\ReciptRating;
use App\Recipt;
use App\Member;

class RateController  extends Controller
{
    public function __construct()
    {
        // $this->middleware('MemberRequiredJWTAndLang') ;
    }

    public function add_rating_to_latest_member_order(Request $request)
    {
                  $lang =  $request->headers->get('lang')??'ar';
                  \App::setLocale( $lang );

                  $get_jwt =  $request->headers->get('jwt') ;
                 if( $get_jwt && $Member = Member::where( 'jwt',$get_jwt )->first() )
                 {
                     $Member->update([
                        'should_rate_order_id' => null
                     ]);
                 }
                 else
                 {
                    return response()->json([
                        'status' => 'unValidJWT'
                    ]);
                 }

        $validator = \Validator::make($request->all(), [
          'q1' => 'required',
          'q2' => 'required',
          'q3' => 'required',
          'q4' => 'required',
          'q5' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $Recipt = Recipt::find($Member->should_rate_order_id);

        if(!$Recipt)
        {
            return response()->json([
              'status' => 'failed',
              'status_message' => 'no order can be rated'
            ]);
        }

        ReciptRating::create([
           'recipt_id' => $Recipt->id ,
           'q1' => $request->q1,
           'q2' => $request->q2,
           'q3' => $request->q3,
           'q4' => $request->q4,
           'q5' => $request->q5,
           'comment' => $request->comment,
        ]);

        return response()->json([
          'status' => 'success',
          'status_message' => __('page.Thank you for your time')
        ]);
    }

}

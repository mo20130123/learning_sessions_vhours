<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PopularQuestion; 

class PopularQuestionController extends Controller
{

     public function index(Request $request)
     {
       $lang =  $request->headers->get('lang')??'ar';
       \App::setLocale( $lang );

        $PopularQuestions = PopularQuestion::select('id',"question_$lang as question","answer_$lang as answer")
                                           ->where('status',1)
                                           ->orderBy('position')
                                           ->limit('100')->get();

         return response()->json([
             'status' => 'success',
             'data' => $PopularQuestions
         ]);
     }


}

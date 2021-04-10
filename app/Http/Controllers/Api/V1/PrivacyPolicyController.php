<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PrivacyPolicy;

class PrivacyPolicyController extends Controller
{
      public function index(Request $request)
      {
          $lang =  $request->headers->get('lang')??'ar';
          \App::setLocale( $lang );

            $PrivacyPolicys = PrivacyPolicy::select('id',"title_$lang as title","text_$lang as text")
                                             ->orderBy('position')->where('status',1)->get();

            return response()->json([
                'status' => 'success',
                'data' => $PrivacyPolicys
            ]);
      }

 }

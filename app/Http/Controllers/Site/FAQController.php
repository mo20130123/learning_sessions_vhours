<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\PopularQuestion;

class FAQController extends Controller
{
      public function index()
      {
          $lang = \App::getLocale();
          $FAQs = PopularQuestion::select('id',"question_$lang as question","answer_$lang as answer")
                                           ->orderBy('position')->where('status',1)->get();
          return view('Site.FAQs',compact('FAQs') );
      }

 }

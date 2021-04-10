<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PopularQuestion;
use App\PagesBanner;

class PopularQuestionController extends Controller
{

     public function index()
     {
        $lang = \App::getLocale();
        $PopularQuestions = PopularQuestion::select('id',"question_$lang as question","answer_$lang as answer")
                                           ->where('status',1)
                                           ->orderBy('position')
                                           ->limit('100')->get();
                                            
        $banner = PagesBanner::where('page','FAQ')->first()["image$lang"];

        return view('Site.PopularQuestion',compact('PopularQuestions','banner'));
     }


}

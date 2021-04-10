<?php

namespace App\Http\Controllers\SiteNew;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\PdfDownloads;
use App\PagesBanner;

class PdfDownloadsController extends Controller
{

     public function index()
     {
        $lang = \App::getLocale();
        $PdfDownloads = PdfDownloads::select('id',"name_$lang as name","pdf")
                                           ->where('status',1)->get();
        $banner = PagesBanner::where('page','downloads')->first()["image$lang"];

        return view('SiteNew.PdfDownloads',compact('PdfDownloads','banner'));
     }


}

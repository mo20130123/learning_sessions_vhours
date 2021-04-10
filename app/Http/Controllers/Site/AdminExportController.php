<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MemberExport;
use App\Exports\ContactUsExport;
use App\Exports\SubscriberExport;
use App\Exports\ProductsExport;
use App\Imports\SapCodeImport;
use App\Admin;
use App\ContactUs;

class AdminExportController extends Controller
{

    public function check_JWT($jwt)
    {
         if( $jwt && $Admin = Admin::where( 'jwt',$jwt )->first() )
         {
           return true;
         }
         else{
           return false;
         }
    }

    public function MemberExport($jwt)
    {
       if(!$this->check_JWT($jwt)){
         return 'now you dont have a permission to do that ,, try to login again';
       }

      return Excel::download(new MemberExport, 'Members.xlsx');
    }

    public function ContactUsExport($jwt)
    {
       if(!$this->check_JWT($jwt)){
         return 'now you dont have a permission to do that ,, try to login again';
       }

      return Excel::download(new ContactUsExport, 'ContactUs.xlsx');
    }

    public function SubscriberExport($jwt)
    {
       if(!$this->check_JWT($jwt)){
         return 'now you dont have a permission to do that ,, try to login again';
       }

      return Excel::download(new SubscriberExport, 'Subscriber.xlsx');
    }

    public function ProductsExport($jwt)
    {
       if(!$this->check_JWT($jwt)){
         return 'now you dont have a permission to do that ,, try to login again';
       }

      return Excel::download(new ProductsExport, 'Products.xlsx');
    }



    public function updateStockWithExcel_once(Request $request)
    {
        $validator = \Validator::make($request->all(), [
          'excel_file' => 'required',
        ]);
        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }


            $fileName = 'once_excel_stock_file_'.rand(11111,99999).'.'.$request->excel_file->getClientOriginalExtension(); // renameing image
            $destinationPath = public_path('excel_stock_file');
            $request->excel_file->move($destinationPath, $fileName); // uploading file to given path

               $filePath = $destinationPath.'/'.$fileName;
           Excel::import(new SapCodeImport, $filePath);

           \File::delete($filePath);

         return response()->json([
             'status' => 'success',
         ]);
    }


}

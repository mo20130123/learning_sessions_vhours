<?php

namespace App\Http\Controllers\AdminApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ContactUs;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('verifyAdminApiAuth');
    }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         $connection = $request->connection;
         return ContactUs::
          where(function($q)use($search,$connection){
              if ($search)
                $q->where('name','like','%'.$search.'%')->orWhere('phone','like','%'.$search.'%')
                  ->orWhere('email','like','%'.$search.'%')->orWhere('id',$search);
              if($connection)
              {
                  switch ($connection)
                  {
                    case 'contacted':
                          $q->where('is_contacted',1);
                      break;
                    case 'notContacted':
                          $q->where('is_contacted',0);
                      break;
                  }
              }
          })
          ->latest('id')->paginate();
    }

    //--api--
    public function switch_contacted($id)
    {
         $Car = ContactUs::findOrFail($id);
         if( $Car->is_contacted )
         {
            $Car->update(['is_contacted' => '0']);
            $case = 0;
         }
         else
         {
            $Car->update(['is_contacted' => '1']);
            $case = 1;
         }

         return response()->json([
             'status' => 'success',
             'case' => $case
         ]);
    }

    //--api--
    public function destroy($id)
    {
         try {
           $deleted = ContactUs::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

    public function Export()
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\ContactUsExport, 'ContactUs.xlsx');
    }

}

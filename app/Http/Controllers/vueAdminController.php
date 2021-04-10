<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class vueAdminController extends Controller
{
    protected $model_name;
    protected $myClass;
    protected $search_attrs;
    protected $store_attrs;
    protected $update_attrs;
    protected $sort_attrs;
    protected $vars_for_selections; // must be assoc array


    public function __construct()
    {
       $this->middleware('verifyAdminApiAuth');
    }

    public function set_model_name($model_name)
    {
        $this->model_name = $model_name;

        //-- use class --
        $class_path = "\App\Models\\$model_name";
        $this->myClass = new $class_path();
    }

    public function selection_data()
    {
        if( !$this->vars_for_selections ) {
           $this->vars_for_selections = [];
        }

        return $this->vars_for_selections;
    }

    public function get_list(Request $request)
    {
         $search = $request->search;
         $search_attrs = $this->search_attrs;

         $data = $this->myClass::
          where(function($q)use($search,$search_attrs){
              if ($search)
              {
                  for ($i=0; $i < count($search_attrs) ; $i++)
                  {
                      if($i==0) {
                         $q->where( $search_attrs[0] ,'like','%'.$search.'%');
                      }
                      else {
                         $q->orWhere( $search_attrs[$i] ,'like','%'.$search.'%');
                      }
                  }//End for
              }//End if
           })
          ->latest('id')->paginate();
          return collect(['status' => 'success'])->merge($data);
    }

    public function store(Request $request)
    {
      //return  $request->all();
          $validator = \Validator::make($request->all(), $this->store_attrs );

          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          $items = [];
          foreach ($this->store_attrs as $key => $value)
          {
             array_push($items,$key);
          }
          $item = $this->myClass::create($request->only($items));

          $item->status = 1;
          return response()->json([
            'status' => 'success',
            'data' => $item
          ]);
    }

    //--api--
    public function update(Request $request)
    {
        $validator = \Validator::make($request->all(), $this->update_attrs );

        if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

        $item = $this->myClass::findOrFail($request->id);

        $items = [];
        foreach ($this->update_attrs as $key => $value)
        {
           array_push($items,$key);
        }
        $item->update($request->only($items));
        return response()->json([
          'status' => 'success',
          'data' => $item
        ]);
    }

    //--api--
    public function showORhide($id)
    {
         $item = $this->myClass::findOrFail($id);
         if( $item->status )
         {
            $item->update(['status' => '0']);
            $case = 0;
         }
         else
         {
            $item->update(['status' => '1']);
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
           $deleted = $this->myClass::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

    public function list_without_paginate()
    {
        return $this->myClass::select($this->sort_attrs)->orderBy('position')->get();
    }

    public function sort_view()
    {
        return view("Admin.".$this->model_name.".sort" );
    }

    public function updateRowsPosition(Request $request)
    {
          $validator = \Validator::make($request->all(), [
              'postionArray' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          foreach($request->postionArray as $key => $value)
          {
              $this->myClass::find($value)->update([
                'position' => (1+$key)
              ]);
          }
          return response()->json([
            'status' => 'success',
          ]);
    }

    //--api--
    public function switch_in_home($id)
    {
         $item = $this->myClass::findOrFail($id);
         if( $item->in_home )
         {
            $item->update(['in_home' => '0']);
            $case = 0;
         }
         else
         {
            $item->update(['in_home' => '1']);
            $case = 1;
         }

         return response()->json([
             'status' => 'success',
             'case' => $case
         ]);
    }




}

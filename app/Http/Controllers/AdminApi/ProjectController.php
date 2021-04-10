<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Project;
use App\ProjectImages;

class ProjectController extends Controller
{
    public function __construct()
    {
       $this->middleware('auth');
    }

    public function index()
    {
        return view('Admin.Project.index');
    }

    public function create()
    {
        return view('Admin.Project.create');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $ProjectImages = ProjectImages::where('project_id',$id)->get();
        return view('Admin.Project.edit',compact('project','ProjectImages'));
    }

    //---api----
    public function get_list(Request $request)
    {
         $search = $request->search;
         return Project::
          where(function($q)use($search){
              if ($search)
                $q->where('name','like','%'.$search.'%')->orWhere('description','like','%'.$search.'%')->orWhere('id',$search);
          })
          ->latest('id')->paginate();
    }

    public function store(Request $request)
    {
          $data = $request->validate([
              'image' => 'required',
              'banner' => 'required',
              'name' => 'required',
              'description' => 'required',
          ]);
          // dd( $request->all() );

          $fileName1 = 'projects_'.rand(11111,99999).'.'.$request->image->getClientOriginalExtension(); // renameing image
          $request->image->move( public_path('images/projects') , $fileName1); // uploading file to given path

          $fileName2 = 'projectsBanner_'.rand(11111,99999).'.'.$request->banner->getClientOriginalExtension(); // renameing image
          $request->banner->move( public_path('images/projectsBanners') , $fileName2); // uploading file to given path

          $Project_data = [
            'name' => $request->name,
            'description' => preg_replace( "/\r|\n/", "", $request->description ) ,
            'image' => $fileName1,
            'banner' => $fileName2
          ];

          $Project = Project::create($Project_data);



            //---ProjectImages---
          if($request->images_no)
          {
              for ($i=0; $i < count($request->images_no) ; $i++)
              {
                 if(isset($request->images[$i]))
                 {
                    ProjectImages::create([
                       'project_id' => $Project->id ,
                       'image' => $request->images[$i]
                    ]);
                 }
              }
          }//End: if($request->images_no)

          \Session::flash('flash_message',' project has been created ');
          return redirect('Admin/Project');
    }

    //--api--
    public function update(Request $request,$id)
    {
        $data = $request->validate([
            'image' => '',
            'banner' => '',
            'name' => 'required',
            'description' => 'required',
        ]);

        $item = Project::findOrFail($id);
        $Project_data = [
          'name' => $request->name,
          'description' => preg_replace( "/\r|\n/", "", $request->description ) ,
        ];

        if($request->image){
            $fileName1 = 'projects_'.rand(11111,99999).'.'.$request->image->getClientOriginalExtension(); // renameing image
            $request->image->move( public_path('images/projects') , $fileName1); // uploading file to given path
            $Project_data['image'] = $fileName1;
        }
        if($request->banner){
            $fileName2 = 'projectsBanner_'.rand(11111,99999).'.'.$request->banner->getClientOriginalExtension(); // renameing image
            $request->banner->move( public_path('images/projectsBanners') , $fileName2); // uploading file to given path
            $Project_data['banner'] = $fileName2;
        }

        $item->update($Project_data);

        if($request->old_images_ids){
          ProjectImages::where('project_id',$id)->whereNotIn('id',$request->old_images_ids)->delete();
        }
        else {
          ProjectImages::where('project_id',$id)->delete();
        }

          //---ProjectImages---
        if($request->images_no)
        {
            for ($i=0; $i < count($request->images_no) ; $i++)
            {
               if(isset($request->images[$i]))
               {
                  ProjectImages::create([
                     'project_id' => $id ,
                     'image' => $request->images[$i]
                  ]);
               }
            }
        }//End: if($request->images_no)

        \Session::flash('flash_message',' project has been updated ');
        return redirect('Admin/Project');
    }

    //--api--
    public function showORhide($id)
    {
         $item = Project::findOrFail($id);
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
           $deleted = Project::destroy($id);
         } catch (\Exception $e) {
           return 'false';
         }
         return 'true';
    }

}

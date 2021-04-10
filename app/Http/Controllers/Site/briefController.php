<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\MemberMarketingBrief;
use Illuminate\Support\Str;

class briefController extends Controller
{

      public function __construct()
      {
         $this->middleware('auth:Member');
      }

      public function create()
      {
          return view('Site.brief.create' );
      }

      public function edit($id)
      {
          $Brief = MemberMarketingBrief::findOrFail($id);
          return view('Site.brief.edit',compact('Brief') );
      }

      //api
      public function store(Request $request)
      {
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'about_brand' => 'required',
                'USPs' => 'required',
                'site_link' => '',
                'kpi' => 'required',
                'talk_to_primary' => 'required',
                'talk_to_secondary' => 'required',
                'key_response' => 'required',
                'colors' => 'required',
                'competitors' => 'required',
            ]);
            if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

            $Brief = MemberMarketingBrief::create([
                'member_id' => auth('Member')->id() ,
                'name' => $request->name,
                'about_brand' => $request->about_brand,
                'USPs' => $request->USPs,
                'site_link' => $request->site_link,
                'kpi' => $request->kpi,
                'talk_to_primary' => $request->talk_to_primary,
                'talk_to_secondary' => $request->talk_to_secondary,
                'key_response' => $request->key_response,
                'colors' => $request->colors,
                'competitors' => json_encode($request->competitors)
            ]);

            return response()->json([
                'status' => 'success',
                'Brief' => $Brief,
                'status_message' => __('api.your brief has been created')
            ]);
      }

      //api
      public function update(Request $request)
      {
            $validator = \Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'about_brand' => 'required',
                'USPs' => 'required',
                'site_link' => '',
                'kpi' => 'required',
                'talk_to_primary' => 'required',
                'talk_to_secondary' => 'required',
                'key_response' => 'required',
                'colors' => 'required',
                'competitors' => 'required',
            ]);
            if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

            $Brief = MemberMarketingBrief::findOrFail($request->id);
            $Brief->update([
                'name' => $request->name,
                'about_brand' => $request->about_brand,
                'USPs' => $request->USPs,
                'site_link' => $request->site_link,
                'kpi' => $request->kpi,
                'talk_to_primary' => $request->talk_to_primary,
                'talk_to_secondary' => $request->talk_to_secondary,
                'key_response' => $request->key_response,
                'colors' => $request->colors,
                'competitors' => json_encode($request->competitors)
            ]);

            return response()->json([
                'status' => 'success',
                'Brief' => $Brief,
                'status_message' => __('api.your brief has been updated')
            ]);
      }

      //--api--
      public function delete(Request $request)
      {
          $validator = \Validator::make($request->all(), [
              'brief_id' => 'required',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          try {
            $Brief = MemberMarketingBrief::findOrFail($request->brief_id);
            $Brief->delete();

          } catch (\Exception $e) {
              return response()->json([
                  'status' => 'failed',
                  'status_message' => __('api.brief has been failed to delete')
              ]);
          }
          
          return response()->json([
              'status' => 'success',
              'status_message' => __('api.brief has been delete')
          ]);
      }


}

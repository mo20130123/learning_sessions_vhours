<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\ContactUs;

class ContactUsController extends Controller
{
    public function __construct()
    {
        $this->middleware('ApiLang') ;
    }

    public function make_Contact(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',  // |unique:register,email
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'notValid', 'status_message' => __('api.notValid'), 'missing_data' => $validator->messages()]);
        }

        ContactUs::create($request->all());

        return response()->json([
            'status' => 'success',
            'status_message' => __('api.Thank you for your interest in SueperDeli')
        ]);
    }

}

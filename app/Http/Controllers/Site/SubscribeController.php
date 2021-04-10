<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Subscriber;

class SubscribeController extends Controller
{

      public function store(Request $request)
      {
          $validator = \Validator::make($request->all(), [
              'email' => 'required|email',
          ]);
          if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }

          Subscriber::create([ 'email' => $request->email ]);

          \Session::flash('flash_message', __('page.Thank you for subscribing with us'));
            return back();
      }

      // public function store(Request $request)
      // {
      //     $validator = \Validator::make($request->all(), [
      //         'email' => 'required|email',
      //     ]);
      //     if ($validator->fails()) { return response()->json([ 'status' => 'notValid' , 'data' => $validator->messages() ]);  }
      //
      //     Subscriber::create([ 'email' => $request->email ]);
      //
      //     return response()->json([
      //       'status' => 'success',
      //     ]);
      // }
}

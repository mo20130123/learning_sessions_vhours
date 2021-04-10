<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;
use Closure;

class verifyAdminApiAuth extends Middleware
{
      public function handle($request, Closure $next)
      {
            $get_jwt = $request->headers->get('jwt') ?? $request->route()->jwt ?? $request->jwt   ;

            if( $get_jwt && $Customer = \App\Models\Admin::where( 'jwt',$get_jwt )->first() )
            {
                 // send $Customer to the controller ,, I controller use it like this -> $request->Customer
                 // $request->merge(array("Customer" => $Customer));
                return $next($request);
            }
            else {
                return response()->json([
                   'status' => 'unValidJWT'
                ]);
            }
      }
}

<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{


  protected $except = [
       'api/logout',
   ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
               //---------if route is (Export)------
               if( strpos($request->path() , 'Export' ) ){
                  return $next($request);
               }


            return $next($request)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
        ->header('Access-Control-Allow-Methods', '*')
        // ->header('Access-Control-Allow-Headers', 'Content-Type, Authorizations');
        ->header('Access-Control-Allow-Headers', "*");
    }
}

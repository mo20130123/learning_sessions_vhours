<?php

namespace App\Http\Middleware;
use Illuminate\Session\Middleware\StartSession;


use Closure;
use App\City;

class ApiLang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
          $lang =  $request->headers->get('lang')??'ar';
          \App::setLocale( $lang );
          $request->merge(array("lang" => $lang));

          // if(true){
          //    return response()->json([
          //       'status' => 'appBlocked',
          //       'status_message' => __('api.appBlocked') ,
          //   ]);
          // }

          return $next($request);
    }
}

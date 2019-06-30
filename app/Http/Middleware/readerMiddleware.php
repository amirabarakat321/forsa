<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;


use Closure;

class readerMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() AND Auth::User()->type == "admin"){
            return $next($request);
        }elseif(Auth::check() AND Auth::User()->type == "supervisor")
        {
            $privil=json_decode(auth::user()->privilege, true);
            IF( $privil['view'] ==0)
            {
                return redirect('/home')->withErrors('ليس لديك صلحيه لاستخدام اللينك ');

            }else{
                return $next($request);
            }
        } else
            return redirect('/login');
    }
}

<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class admin
{

    public function handle($request, Closure $next)
    {
        if(Auth::check() ){
            if (Auth::User()->type == "admin" || Auth::User()->type == "supervisor" ) {
                return $next($request);
            } else  return  redirect('/home')->withErrors('ليس لديك صلحيه ');
           }
        else return redirect('/login');
    }
}

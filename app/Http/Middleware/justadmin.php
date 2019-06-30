<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;

use Closure;

class justadmin
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() ){
            if (Auth::User()->type == "admin" ) {
                return $next($request);
            }else  return  redirect('/home')->withErrors('ليس لديك صلحيه ');
        }
        else return redirect('/login');
    }
}

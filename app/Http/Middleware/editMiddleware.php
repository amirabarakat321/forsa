<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;


use Closure;

class editMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() AND Auth::User()->type == "supervisor")
        {
                $privil=json_decode(auth::user()->privilege, true);
                IF( $privil['edit'] ==0)
                {
                    return Redirect::back()->withErrors(['msg', 'you have not access ']);


                }else{
                    return $next($request);
                }
            }


        else return redirect('/login');
    }
}

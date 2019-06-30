<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;


use Closure;

class supervisorMiddleware
{
    public function handle($request, Closure $next)
    {
        if(Auth::check() AND Auth::User()->type == "supervisor")
            return $next($request);
        else return redirect('/login');
    }
}

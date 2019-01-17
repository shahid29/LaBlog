<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check() && Auth::user()->role->id==1) {
            return redirect()->route('admin.dashboard');
        }elseif (Auth::check() && Auth::user()->role->id==2){
            return redirect()->route('author.dashboard');
            }else{
            return $next($request);
        }

    }
}

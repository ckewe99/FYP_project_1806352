<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class checkUserCanDeleteOrEdit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->can_order) {
            Session::flash('alert-danger', 'The menu was closed. Please contact admin for more INFO');
            return redirect()->route('home');
        } else {
            return $next($request);
        }
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsSession
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}

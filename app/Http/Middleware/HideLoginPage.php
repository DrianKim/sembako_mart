<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HideLoginPage
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!session()->has('allow_login_access') || session('allow_login_access') !== true) {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        session()->forget('allow_login_access');

        return $next($request);
    }
}

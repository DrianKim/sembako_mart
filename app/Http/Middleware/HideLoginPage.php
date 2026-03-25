<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HideLoginPage
{
    public function handle(Request $request, Closure $next): Response
    {
        $hasAccess = session()->has('allow_login_access');
        $formOpened = session()->has('login_form_opened');

        if (!$hasAccess && !$formOpened) {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        if ($request->isMethod('GET') && $hasAccess) {
            session()->forget('allow_login_access');
            session(['login_form_opened' => true]);
        }

        if ($request->isMethod('POST') && !$formOpened) {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        return $next($request);
    }
}

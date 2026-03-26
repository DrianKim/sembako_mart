<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->status !== 'aktif') {
                auth()->logout();

                $token = Str::random(40);
                session(['login_token' => $token]);

                return redirect()->route('login', ['token' => $token])
                    ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin!');
            }
        }

        return $next($request);
    }
}

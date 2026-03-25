<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm(string $token)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $dashboard = match ($user->role) {
                'admin' => route('admin.dashboard'),
                'kasir' => route('kasir.dashboard'),
                'owner' => route('owner.dashboard'),
                default => '/',
            };
            return redirect($dashboard);
        }

        // Validasi token
        if (!session()->has('login_token') || session('login_token') !== $token) {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        return view('auth.login', ['token' => $token]);
    }

    public function login(Request $request, string $token)
    {
        // Validasi token
        if (!session()->has('login_token') || session('login_token') !== $token) {
            return redirect('/')->with('error', 'Akses ditolak');
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username harus diisi!',
            'password.required' => 'Password harus diisi!',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Username atau password salah!')->withInput();
        }

        if ($user->status === 'nonaktif') {
            return back()->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin!')->withInput();
        }

        Auth::login($user);
        session()->forget('login_token');

        Log::create([
            'id_user' => $user->id,
            'aktivitas' => "User " . $user->nama . " berhasil login sebagai '" . $user->role . "'",
            'waktu' => now(),
        ]);

        $dashboard = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'kasir' => route('kasir.dashboard'),
            'owner' => route('owner.dashboard'),
            default => '/',
        };

        return redirect($dashboard)->with('success', 'Anda Berhasil Login!');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Log::create([
                'id_user' => auth()->id(),
                'aktivitas' => "User " . auth()->user()->nama . " berhasil logout",
                'waktu' => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Berhasil logout!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            $user = Auth::user();

            $dashboard = match ($user->role) {
                'admin' => route('admin.dashboard'),
                'kasir' => route('kasir.dashboard'),
                'owner' => route('owner.dashboard'),
                default => route('login'),
            };

            return redirect($dashboard);
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username harus diisi!',
            'password.required' => 'Password harus diisi!',
        ]);

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', 'Username atau password salah!')->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return back()->with('error', 'Username atau password salah!')->withInput();
        }

        if ($user->status === 'nonaktif') {
            return back()->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi admin!')->withInput();
        }

        Auth::login($user);

        Log::create([
            'id_user'   => $user->id,
            'aktivitas' => "User '{$user->nama}' melakukan login sebagai '{$user->role}'",
            'waktu'     => now(),
        ]);

        $dashboard = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'kasir' => route('kasir.dashboard'),
            'owner' => route('owner.dashboard'),
            default => route('login'),
        };

        return redirect($dashboard)->with('success', 'Anda Berhasil Login!');
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            Log::create([
                'id_user' => Auth::id(),
                'aktivitas' => "User '" . Auth::user()->nama . "' melakukan logout sebagai '" . Auth::user()->role . "'",
                'waktu' => now(),
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Berhasil logout!');
    }
}

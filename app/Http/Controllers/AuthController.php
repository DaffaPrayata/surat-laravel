<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $login = $request->username;

        $user = User::where('username', $login)
            ->orWhere('email', $login)
            ->first();

        if (! $user) {
            return back()->withErrors([
                'username' => 'Akun tidak ditemukan'
            ])->withInput();
        }

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah'
            ])->withInput();
        }

        if (! $user->is_active) {
            return back()->withErrors([
                'username' => 'Akun tidak aktif'
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate(); // 🔥 INI WAJIB

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

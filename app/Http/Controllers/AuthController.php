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
        // 1. Validasi Input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginInput = $request->username;

        // 2. Cari User (Bisa pake Username atau Email)
        // WAJIB pake ->first() di akhir biar dapet datanya
        $user = User::where('username', $loginInput)
                    ->orWhere('email', $loginInput)
                    ->first();

        // 3. Cek apakah User ada
        if (!$user) {
            return back()->withErrors([
                'username' => 'Akun tidak ditemukan.'
            ])->withInput();
        }

        // 4. Cek Password
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'password' => 'Password salah.'
            ])->withInput();
        }

        // 5. Cek Status Aktif
        if (!$user->is_active) {
            return back()->withErrors([
                'username' => 'Akun Anda sedang dinonaktifkan.'
            ])->withInput();
        }

        // 6. Eksekusi Login
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate(); 

        return redirect()->intended(route('home')); // Pake intended biar balik ke halaman sebelumnya
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
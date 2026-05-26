<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Contracts\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        return view('pages.user', [
            'data' => User::render($request->search),
            'search' => $request->search,
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();
            $plainPassword = Str::random(8);

            $data['password'] = Hash::make($plainPassword);
            $data['is_active'] = true;
            $data['role'] = $request->role ?? 'staff';

            User::create($data);

            return back()->with('success_user', [
                'message' => 'User berhasil ditambahkan!',
                'password' => $plainPassword
            ]);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            $data = $request->validated();
            $data['is_active'] = $request->has('is_active');
            $data['role'] = $request->role;
            $newPlain = null;

            if ($request->has('reset_password')) {
                $newPlain = Str::random(8); // Pake random biar aman tiap user
                $data['password'] = Hash::make($newPlain);
            }

            // SIMPAN DULU KE DATABASE
            $user->update($data);

            // BARU RETURN NOTIF PASSWORD (KALAU ADA)
            if ($newPlain) {
                return back()->with('success_user', [
                    'message' => 'Password berhasil di-reset!',
                    'password' => $newPlain
                ]);
            }

            return back()->with('success', 'Data user berhasil diperbarui');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(User $user): RedirectResponse
    {
    try {

        // Cek apakah user masih memiliki surat
        if (Letter::where('user_id', $user->id)->exists()) {

            return back()->with(
                'error',
                'User tidak dapat dihapus karena masih memiliki data surat.'
            );
        }

            $user->delete();

            return back()->with(
                'success',
                'User berhasil dihapus.'
            );

        } catch (\Throwable $e) {

            Log::error('Gagal menghapus user', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return back()->with(
                'error',
                'Terjadi kesalahan saat menghapus user.'
            );
        }
    }
}
<?php

namespace App\Policies;

use App\Models\Letter;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LetterPolicy
{
    use HandlesAuthorization;

    /**
     * Semua user boleh liat daftar surat.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Siswa cuma boleh liat detail kalau namanya ada di kolom 'tujuan' (to).
     */
    public function view(User $user, Letter $letter): bool
    {
        if ($user->role === 'siswa') {
            return str_contains(strtolower($letter->to), strtolower($user->name));
        }
        return true;
    }

    /**
     * Cuma Admin & Staff yang bisa buat surat.
     */
    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'staff','siswa']);
    }

    /**
     * Cuma Admin & Staff yang bisa edit surat.
     */
    public function update(User $user, Letter $letter): bool
    {
        return in_array($user->role, ['admin', 'staff']);
    }

    /**
     * Cuma Admin yang bisa hapus surat.
     */
    public function delete(User $user, Letter $letter): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Fitur restore biasanya cuma buat Admin.
     */
    public function restore(User $user, Letter $letter): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Hapus permanen? Jelas cuma Admin.
     */
    public function forceDelete(User $user, Letter $letter): bool
    {
        return $user->role === 'admin';
    }
}
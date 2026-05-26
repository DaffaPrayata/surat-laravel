<?php

namespace App\Enums;

// Hapus 'protected', langsung 'enum' saja
enum Role: string
{
    case ADMIN = 'admin';
    case STAFF = 'staff';
    case SISWA = 'siswa';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::STAFF => 'Guru',
            self::SISWA => 'Siswa',
        };
    }
}
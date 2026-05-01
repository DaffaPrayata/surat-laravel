<?php

namespace App\Enums;

// Tambahin ': string' biar jadi Backed Enum
enum Role: string
{
    case ADMIN = 'admin';
    case STAFF = 'staff';
    case SISWA = 'siswa'; // Tambahin ini

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator',
            self::STAFF => 'Staff Tata Usaha',
            self::SISWA => 'Siswa',
        };
    }
}
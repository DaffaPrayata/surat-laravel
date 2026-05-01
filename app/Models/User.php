<?php

namespace App\Models;

use App\Enums\Role;
use App\Enums\Config as ConfigEnum;
use App\Models\Config; // 🔥 FIX
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'phone',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    // 🔥 Avatar fallback
    public function profilePicture(): Attribute
    {
        return Attribute::make(
            get: fn ($value) =>
                $value ?: 'https://ui-avatars.com/api/?background=6D67E4&color=fff&name=' . urlencode($this->name)
        );
    }

    // 🔥 Scope Active
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // 🔥 Scope Role
    public function scopeRole($query, Role $role)
    {
        return $query->where('role', $role->status());
    }

    // 🔥 Search lebih fleksibel
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $find) {
            return $query->where(function ($q) use ($find) {
                $q->where('name', 'LIKE', "%$find%")
                  ->orWhere('email', 'LIKE', "%$find%")
                  ->orWhere('phone', 'LIKE', "%$find%");
            });
        });
    }

    // 🔥 FIX UTAMA DI SINI
    public function scopeRender($query, $search)
    {
        return $query
            ->search($search)
            // ❌ HAPUS FILTER ROLE STAFF
            // ->role(Role::STAFF)
            ->latest()
            ->paginate(Config::getValueByCode(ConfigEnum::PAGE_SIZE))
            ->appends([
                'search' => $search,
            ]);
    }
}
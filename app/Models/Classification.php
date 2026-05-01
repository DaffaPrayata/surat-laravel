<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classification extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'name',
        'description',
    ];

    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($query, $find) {
            return $query
                ->where('type', 'LIKE', $find . '%')
                ->orWhere('code', 'LIKE', $find . '%')
                ->orWhere('name', 'LIKE', $find . '%');
        });
    }

    public function scopeRender($query, $search)
    {
        return $query
            ->search($search)
            ->latest()
            ->paginate(10)
            ->appends([
                'search' => $search,
            ]);
    }
}

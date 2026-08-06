<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $fillable = ['nama', 'deskripsi', 'role', 'roles', 'warna', 'is_active'];

    protected $casts = [
        'roles' => 'array',
    ];

    public function layanans()
    {
        return $this->hasMany(Layanan::class);
    }

    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role', 'name');
    }
}

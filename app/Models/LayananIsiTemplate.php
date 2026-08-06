<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananIsiTemplate extends Model
{
    protected $fillable = [
        'layanan_id',
        'isi_id',
        'isi_en',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}

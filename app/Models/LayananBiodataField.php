<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LayananBiodataField extends Model
{
    protected $fillable = [
        'layanan_id',
        'label',
        'label_en',
        'field_key',
        'suffix',
        'suffix_en',
        'urutan',
        'is_admin_field',
    ];

    public function layanan()
    {
        return $this->belongsTo(Layanan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'nip',
        'nama_karyawan',
        'unit',
        'posisi_pekerjaan',
        'profesi',
        'jabatan',
    ];
}

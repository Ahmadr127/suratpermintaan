<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Sinkronisasi User dari Simutu
    |--------------------------------------------------------------------------
    | Simutu adalah satu-satunya sumber data pegawai (master data).
    | Sistem ini MENARIK data dari simutu dan memperbarui:
    |  - tabel users  (akun login)      -> nama, username, email, password, role
    |  - tabel employees (master karyawan) -> dipakai UI filter & aturan role unit
    |
    | Prinsip non-destruktif:
    |  - Tidak pernah menghapus users / employees lokal.
    |  - Role lokal ('user'/'unit_*') TIDAK ditimpa; hanya diisi saat user baru.
    |  - Password disalin dari simutu (hash bcrypt kompatibel).
    */

    'enabled' => (bool) env('SIMUTU_SYNC_ENABLED', true),

    'db_connection' => env('SIMUTU_DB_CONNECTION', 'simutu'),

    'sync_password' => true,

    'block_login_statuses' => ['non-aktif'],

    // Data user dianggap basi setelah sekian detik -> lazy-sync saat login.
    'stale_after_seconds' => 3600,

    // Tetap pakai logika eksisting resolveRoleForEmployee (master/user/UserController).
    'jabatan_bawah' => ['STAFF', 'PENANGGUNG JAWAB', 'DOKTER SPESIALIS'],
];
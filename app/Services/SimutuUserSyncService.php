<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * Menarik data pegawai dari database Simutu (master data) ke:
 *  - tabel users     (akun login),
 *  - tabel employees (master karyawan yang dipakai UI/filter & aturan role unit).
 *
 * Prinsip non-destruktif:
 *  - Tidak pernah menghapus users / employees lokal.
 *  - Role lokal TIDAK ditimpa untuk user lama; hanya diisi saat user baru.
 *  - Password disalin dari simutu (hash bcrypt kompatibel).
 */
class SimutuUserSyncService
{
    public function enabled(): bool
    {
        return (bool) config('simutu_sync.enabled', true);
    }

    protected function connection(): string
    {
        return (string) config('simutu_sync.db_connection', 'simutu');
    }

    protected function fetchSimutuUsers(): \Illuminate\Support\Collection
    {
        return DB::connection($this->connection())
            ->table('users')
            ->leftJoin('tbl_unit', 'users.unit_id', '=', 'tbl_unit.id')
            ->leftJoin('tbl_role', 'users.role_id', '=', 'tbl_role.id')
            ->select(
                'users.id as simutu_id',
                'users.nama_lengkap',
                'users.nip',
                'users.username',
                'users.email',
                'users.password',
                'users.profesi',
                'users.status_user',
                'tbl_unit.nama_unit',
                'tbl_role.nama_role'
            )
            ->get();
    }

    public function syncForUsername(?string $username): ?User
    {
        if (! $this->enabled() || ! $username) {
            return null;
        }

        try {
            $simutu = DB::connection($this->connection())
                ->table('users')
                ->leftJoin('tbl_unit', 'users.unit_id', '=', 'tbl_unit.id')
                ->leftJoin('tbl_role', 'users.role_id', '=', 'tbl_role.id')
                ->select(
                    'users.id as simutu_id',
                    'users.nama_lengkap',
                    'users.nip',
                    'users.username',
                    'users.email',
                    'users.password',
                    'users.profesi',
                    'users.status_user',
                    'tbl_unit.nama_unit',
                    'tbl_role.nama_role'
                )
                ->where('users.username', $username)
                ->first();
        } catch (\Throwable $e) {
            Log::warning('Simutu syncForUsername gagal: '.$e->getMessage());
            return null;
        }

        if (! $simutu) {
            return null;
        }

        $simutuArr = (array) $simutu;

        // ikut menjaga tabel employees tetap sinkron untuk alur existing (filter/unit role)
        $this->applyToEmployee($simutuArr);

        $local = $this->findLocalUser($simutuArr);
        return $this->applyToLocal($simutuArr, $local, createIfMissing: true);
    }

    /**
     * Salin ke tabel employees (master karyawan) menggunakan format existing
     * (huruf besar, agar kompatibel dengan filter/resolveRoleForEmployee).
     */
    protected function applyToEmployee(array $simutu): void
    {
        if (empty($simutu['nip'])) {
            return;
        }

        $namaRole = strtoupper((string) ($simutu['nama_role'] ?? 'STAFF'));
        $unit = strtoupper((string) ($simutu['nama_unit'] ?? 'UMUM'));
        $profesi = strtoupper((string) ($simutu['profesi'] ?? 'NON MEDIS'));

        Employee::updateOrCreate(
            ['nip' => $simutu['nip']],
            [
                'nama_karyawan' => $simutu['nama_lengkap'],
                'unit' => $unit,
                'posisi_pekerjaan' => $namaRole ?: 'STAFF',
                'profesi' => $profesi ?: 'NON MEDIS',
                'jabatan' => $namaRole ?: 'STAFF',
            ]
        );
    }

    protected function findLocalUser(array $simutu): ?User
    {
        if (! empty($simutu['simutu_id'])) {
            $bySimutuId = User::where('simutu_id', $simutu['simutu_id'])->first();
            if ($bySimutuId) {
                return $bySimutuId;
            }
        }

        if (! empty($simutu['username'])) {
            $byUsername = User::where('username', $simutu['username'])->first();
            if ($byUsername) {
                return $byUsername;
            }
        }

        if (! empty($simutu['email'])) {
            $byEmail = User::where('email', $simutu['email'])->first();
            if ($byEmail) {
                return $byEmail;
            }
        }

        if (! empty($simutu['nama_lengkap'])) {
            $byName = User::whereRaw('LOWER(name) = ?', [mb_strtolower($simutu['nama_lengkap'])])->first();
            if ($byName) {
                return $byName;
            }
        }

        return null;
    }

    /**
     * Replikasi logika existing resolveRoleForEmployee(UserController).
     */
    public function resolveRole(string $jabatan, string $unit): string
    {
        $jabatan = strtoupper(trim($jabatan));
        if (in_array($jabatan, config('simutu_sync.jabatan_bawah', ['STAFF', 'PENANGGUNG JAWAB', 'DOKTER SPESIALIS']))) {
            return 'user';
        }

        $unitSlug = 'unit_'.Str::slug(strtolower($unit), '_');
        if (Role::where('name', $unitSlug)->exists()) {
            return $unitSlug;
        }

        return 'user';
    }

    protected function applyToLocal(array $simutu, ?User $local, bool $createIfMissing): ?User
    {
        $namaRole = (string) ($simutu['nama_role'] ?? '');
        $unit = strtoupper((string) ($simutu['nama_unit'] ?? ''));

        $data = [
            'name' => $simutu['nama_lengkap'] ?? ($local?->name),
            'username' => $simutu['username'] ?? ($local?->username),
            'email' => ($simutu['email'] ?? null) ?: ($local?->email),
            'simutu_id' => $simutu['simutu_id'] ?? null,
            'simutu_status' => $simutu['status_user'] ?? null,
            'simutu_synced_at' => now(),
        ];

        if (config('simutu_sync.sync_password', true) && ! empty($simutu['password'])) {
            $data['password'] = $simutu['password'];
        }

        if (! $local) {
            $data['role'] = $this->resolveRole($namaRole, $unit);
        }

        if ($local) {
            $local->update($data);
            return $local;
        }

        if (! $createIfMissing) {
            return null;
        }

        if (User::where('username', $data['username'])->exists()) {
            return null;
        }

        return User::create($data);
    }

    /**
     * Jalankan sinkronisasi penuh (users + employees).
     *
     * @return array{created:int, updated:int, checked:int, employees:int}
     */
    public function sync(bool $dryRun = false): array
    {
        $stats = ['checked' => 0, 'created' => 0, 'updated' => 0, 'employees' => 0];

        if (! $this->enabled()) {
            return $stats;
        }

        foreach ($this->fetchSimutuUsers() as $simutu) {
            $stats['checked']++;
            $simutuArr = (array) $simutu;

            if (! $dryRun) {
                $this->applyToEmployee($simutuArr);
                $stats['employees']++;
            }

            $local = $this->findLocalUser($simutuArr);

            if (! $local) {
                if ($dryRun) {
                    $stats['created']++;
                } else {
                    $user = $this->applyToLocal($simutuArr, null, createIfMissing: true);
                    if ($user) {
                        $stats['created']++;
                    }
                }
                continue;
            }

            $fresh = $this->applyToLocal($simutuArr, $local, createIfMissing: false);
            if ($fresh && $fresh->simutu_synced_at) {
                $stats['updated']++;
            }
        }

        return $stats;
    }
}
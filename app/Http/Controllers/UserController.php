<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::orderBy('name');

        if ($request->filled('search')) {
            $query->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search) . '%']);
        }

        $users = $query->get();
        $allRoles  = Role::orderBy('label')->get();

        $rolesQuery = Role::orderBy('label');
        if ($request->filled('search_role')) {
            $rolesQuery->where(function($q) use ($request) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($request->search_role) . '%'])
                  ->orWhereRaw('LOWER(label) LIKE ?', ['%' . strtolower($request->search_role) . '%']);
            });
        }
        $roles     = $rolesQuery->get();

        $empQuery = Employee::orderBy('nama_karyawan');
        if ($request->filled('search')) {
            $s = strtolower($request->search);
            $empQuery->whereRaw('LOWER(nama_karyawan) LIKE ?', ["%$s%"]);
        }
        if ($request->filled('search_karyawan')) {
            $s = strtolower($request->search_karyawan);
            $empQuery->where(function($q) use ($s) {
                $q->whereRaw('LOWER(nama_karyawan) LIKE ?', ["%$s%"])
                  ->orWhereRaw('LOWER(profesi) LIKE ?', ["%$s%"]);
            });
        }
        if ($request->filled('filter_unit')) {
            $empQuery->where('unit', $request->filter_unit);
        }
        if ($request->filled('filter_posisi')) {
            $empQuery->where('posisi_pekerjaan', $request->filter_posisi);
        }
        if ($request->filled('filter_jabatan')) {
            $empQuery->where('jabatan', $request->filter_jabatan);
        }
        $employees = $empQuery->get();

        // Distinct values untuk dropdown filter
        $filterUnits    = Employee::select('unit')->distinct()->orderBy('unit')->pluck('unit');
        $filterPosisis  = Employee::select('posisi_pekerjaan')->distinct()->orderBy('posisi_pekerjaan')->pluck('posisi_pekerjaan');
        $filterJabatans = Employee::select('jabatan')->distinct()->orderBy('jabatan')->pluck('jabatan');
        $tab       = $request->get('tab', 'user');

        return view('master.user.index', compact('users', 'roles', 'allRoles', 'employees', 'tab',
            'filterUnits', 'filterPosisis', 'filterJabatans'));
    }

    public function create()
    {
        $roles     = Role::orderBy('label')->get();
        $employees = Employee::orderBy('nama_karyawan')->get();
        return view('master.user.create', compact('roles', 'employees'));
    }

    // store lama — tidak dipakai lagi, redirect ke storeAll
    public function store(Request $request)
    {
        return redirect()->route('master.user.storeAll');
    }

    /**
     * Tentukan role otomatis berdasarkan jabatan dan unit karyawan.
     * Jabatan di bawah koordinator (STAFF, PENANGGUNG JAWAB, DOKTER SPESIALIS) → role "user"
     * Jabatan koordinator ke atas → role berdasarkan unit
     */
    private function resolveRoleForEmployee(Employee $emp): string
    {
        $jabatanBawah = ['STAFF', 'PENANGGUNG JAWAB', 'DOKTER SPESIALIS'];
        $jabatan = strtoupper(trim($emp->jabatan ?? ''));

        if (in_array($jabatan, $jabatanBawah)) {
            return 'user';
        }

        // Cari role berdasarkan unit
        $unitSlug = 'unit_' . Str::slug(strtolower($emp->unit), '_');
        if (Role::where('name', $unitSlug)->exists()) {
            return $unitSlug;
        }

        // Fallback ke user jika role unit belum ada
        return 'user';
    }

    /**
     * Generate username dari nama karyawan.
     * Format: namadepan.namabelakang (huruf kecil, tanpa gelar)
     */
    private function generateUsername(Employee $emp): string
    {
        $nama = $emp->nama_karyawan;

        // Buang semua setelah koma (gelar)
        if (str_contains($nama, ',')) {
            $nama = trim(substr($nama, 0, strpos($nama, ',')));
        }

        $gelarDepan = ['dr', 'drg', 'drs', 'dra', 'prof', 'ir', 'ns', 'apt', 'ners', 'kh', 'hj', 'h'];
        $kata = array_filter(explode(' ', $nama), fn($k) => strlen(trim($k)) > 0);
        $kata = array_values($kata);

        // Buang gelar depan
        while (!empty($kata) && in_array(strtolower(rtrim($kata[0], '.')), $gelarDepan)) {
            array_shift($kata);
        }

        $depan    = strtolower($kata[0] ?? 'karyawan');
        $belakang = strtolower($kata[1] ?? '');

        $base = $belakang ? $depan . '.' . $belakang : $depan;
        $base = preg_replace('/[^a-z0-9.]/', '', $base);

        // Pastikan unik
        $username = $base;
        $counter  = 1;
        while (User::where('username', $username)->exists()) {
            $username = $base . $counter;
            $counter++;
        }

        return $username;
    }

    /**
     * Buat akun untuk satu karyawan langsung (tanpa form).
     */
    public function storeOne(Employee $employee)
    {
        // Cek sudah punya akun
        if (User::whereRaw('LOWER(name) = ?', [strtolower($employee->nama_karyawan)])->exists()) {
            return redirect()->route('master.user.index', ['tab' => 'user'])
                ->with('error', $employee->nama_karyawan . ' sudah memiliki akun.');
        }

        $role     = $this->resolveRoleForEmployee($employee);
        $username = $this->generateUsername($employee);

        User::create([
            'name'     => $employee->nama_karyawan,
            'username' => $username,
            'password' => Hash::make('rsazra'),
            'role'     => $role,
        ]);

        return redirect()->route('master.user.index', ['tab' => 'user'])
            ->with('success', 'Akun berhasil dibuat: ' . $employee->nama_karyawan . ' (@' . $username . ')');
    }

    /**
     * Buat akun untuk semua karyawan yang belum punya akun sekaligus.
     */
    public function storeAll()
    {
        $employees = Employee::orderBy('nama_karyawan')->get();
        $existingNames = User::pluck('name')->map(fn($n) => strtolower($n))->toArray();

        $created = 0;
        $skipped = 0;

        foreach ($employees as $emp) {
            if (in_array(strtolower($emp->nama_karyawan), $existingNames)) {
                $skipped++;
                continue;
            }

            $role     = $this->resolveRoleForEmployee($emp);
            $username = $this->generateUsername($emp);

            User::create([
                'name'     => $emp->nama_karyawan,
                'username' => $username,
                'password' => Hash::make('rsazra'),
                'role'     => $role,
            ]);

            $existingNames[] = strtolower($emp->nama_karyawan);
            $created++;
        }

        $msg = $created . ' akun berhasil dibuat.';
        if ($skipped > 0) $msg .= ' ' . $skipped . ' karyawan dilewati (sudah punya akun).';

        return redirect()->route('master.user.index', ['tab' => 'user'])->with('success', $msg);
    }

    public function edit($id)
    {
        $user  = User::findOrFail($id);
        $roles = Role::orderBy('label')->get();
        return view('master.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user       = User::findOrFail($id);
        $validRoles = Role::pluck('name')->toArray();

        $request->validate([
            'role' => ['required', Rule::in($validRoles)],
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('master.user.index', ['tab' => 'user'])->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }
}

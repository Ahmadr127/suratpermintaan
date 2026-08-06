<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * Usage di route: middleware('role:admin,rekam_medis')
     *
     * Selain cek nama role secara langsung, middleware ini juga
     * membaca kolom `allowed_groups` dari tabel roles agar role
     * baru yang dibuat via UI bisa mendapat akses tanpa ubah kode.
     *
     * Contoh: route group 'staff' → middleware('role:admin,rekam_medis,farmasi')
     * Role baru dengan allowed_groups = ["staff"] otomatis lolos.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // 1. Cek langsung apakah nama role ada di daftar yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 2. Cek via allowed_groups di DB — role baru yang dibuat via UI
        $roleModel = Role::where('name', $userRole)->first();
        if ($roleModel && $roleModel->allowed_groups) {
            $allowedGroups = is_array($roleModel->allowed_groups)
                ? $roleModel->allowed_groups
                : json_decode($roleModel->allowed_groups, true);

            // Cek apakah salah satu dari $roles ada di allowed_groups role ini
            foreach ($roles as $r) {
                if (in_array($r, $allowedGroups ?? [])) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Akses ditolak.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Role;
use App\Services\SimutuUserSyncService;

class AuthController extends Controller
{
    // =========================
    // Form login
    // =========================
    public function loginForm()
    {
        return view('auth.login');
    }

    // =========================
    // Proses login
    // =========================
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);
        if (! Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            return back()->withErrors([
                'username' => 'Username atau password salah',
            ])->onlyInput('username');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        // Sinkronisasi ringan dari Simutu: segarkan profil + status user yang login.
        try {
            app(SimutuUserSyncService::class)->syncForUsername($request->username);
            $user->refresh();
        } catch (\Throwable $e) {
            Log::warning('Simutu lazy sync gagal saat login: '.$e->getMessage());
        }

        // Tolak akun yang dinonaktifkan di Simutu.
        if (
            $user->simutu_status
            && in_array($user->simutu_status, config('simutu_sync.block_login_statuses', ['non-aktif']))
        ) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()->withErrors([
                'username' => 'Akun dinonaktifkan di sistem Simutu.',
            ])->onlyInput('username');
        }

        // Cek redirect_to dari tabel roles
        $role = Role::where('name', $user->role)->first();
        if ($role && $role->redirect_to) {
            return redirect()->intended($role->redirect_to);
        }

        return redirect()->intended('/');
    }

    // =========================
    // Logout
    // =========================
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
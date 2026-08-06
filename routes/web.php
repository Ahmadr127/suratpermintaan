<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PermintaanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserLayananController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

// login page
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');

// login process
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (HARUS LOGIN)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    // DEBUG ROUTE - dihapus

    /* ===== ADMIN + REKAM MEDIS + FARMASI AREA ===== */
    Route::middleware(['role:admin,rekam_medis,farmasi'])->group(function () {
        Route::get('/permintaan', [PermintaanController::class, 'index'])->name('permintaan.index');
        Route::get('/permintaan/{id}/view', [PermintaanController::class, 'viewSurat'])->name('permintaan.view');
        Route::get('/permintaan/{id}/cetak', [PermintaanController::class, 'cetakSurat'])->name('permintaan.cetak');
        Route::get('/permintaan/{id}/edit', [PermintaanController::class, 'edit'])->name('permintaan.edit');
        Route::put('/permintaan/{id}', [PermintaanController::class, 'update'])->name('permintaan.update');
        Route::delete('/permintaan/{id}', [PermintaanController::class, 'destroy'])->name('permintaan.destroy');
        Route::patch('/permintaan/{id}/status', [PermintaanController::class, 'updateStatus'])->name('permintaan.updateStatus');
        Route::post('/permintaan/{id}/upload', [PermintaanController::class, 'uploadSurat'])->name('permintaan.upload');
    });

    /* ===== ADMIN ONLY AREA ===== */
    Route::middleware(['role:admin'])->group(function () {

        /* ===== MASTER KATEGORI ===== */
        Route::prefix('master/kategori')->name('master.kategori.')->group(function () {
            Route::get('/', [KategoriController::class, 'index'])->name('index');
            Route::get('/create', [KategoriController::class, 'create'])->name('create');
            Route::post('/', [KategoriController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [KategoriController::class, 'edit'])->name('edit');
            Route::put('/{id}', [KategoriController::class, 'update'])->name('update');
            Route::delete('/{id}', [KategoriController::class, 'destroy'])->name('destroy');
        });

        /* ===== MASTER LAYANAN ===== */
        Route::prefix('master/layanan')->name('master.layanan.')->group(function () {
            Route::get('/', [LayananController::class, 'index'])->name('index');
            Route::get('/create', [LayananController::class, 'create'])->name('create');
            Route::post('/', [LayananController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [LayananController::class, 'edit'])->name('edit');
            Route::put('/{id}', [LayananController::class, 'update'])->name('update');
            Route::delete('/{id}', [LayananController::class, 'destroy'])->name('destroy');
        });

        /* ===== MASTER USER ===== */
        Route::prefix('master/user')->name('master.user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::post('/store-one/{employee}', [UserController::class, 'storeOne'])->name('storeOne');
            Route::post('/store-all', [UserController::class, 'storeAll'])->name('storeAll');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        /* ===== MASTER EMPLOYEE ===== */
        Route::prefix('master/employee')->name('master.employee.')->group(function () {
            Route::post('/', [EmployeeController::class, 'store'])->name('store');
            Route::put('/{id}', [EmployeeController::class, 'update'])->name('update');
            Route::delete('/{id}', [EmployeeController::class, 'destroy'])->name('destroy');
        });

        /* ===== MASTER ROLE ===== */
        Route::prefix('master/role')->name('master.role.')->group(function () {
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::put('/{role}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{role}', [RoleController::class, 'destroy'])->name('destroy');
        });
    });

    /* ===== USER AREA ===== */
    Route::middleware(['role:user'])->group(function () {
        Route::get('/layanan', [UserLayananController::class, 'index'])->name('layanan.index');
        Route::post('/layanan', [UserLayananController::class, 'store'])->name('layanan.store');
        Route::get('/user/permintaan', [UserLayananController::class, 'myRequests'])->name('user.permintaan');
        Route::get('/user/permintaan/{id}', [UserLayananController::class, 'show'])->name('user.permintaan.show');
        Route::get('/user/permintaan/{id}/bukti', [UserLayananController::class, 'cetakBukti'])->name('user.permintaan.bukti');
        Route::get('/user/permintaan/{id}/download', [UserLayananController::class, 'download'])->name('user.permintaan.download');
        Route::get('/user/permintaan/{id}/preview', [UserLayananController::class, 'preview'])->name('user.permintaan.preview');
    });
});
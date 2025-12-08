<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Redirect Root URL
|--------------------------------------------------------------------------
*/

// Menampilkan landing page
Route::get('/', function () {
    return view('landing');
})->name('home');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

// Login Page
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

// Login Process
Route::post('/login', [AuthController::class, 'loginProcess'])->name('login.post');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| KARYAWAN (protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/karyawan/dashboard', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])
        ->name('karyawan.dashboard');
    
    Route::get('/karyawan/profile', [\App\Http\Controllers\Karyawan\DashboardController::class, 'profile'])
        ->name('karyawan.profile');
    
    Route::get('/karyawan/{id}/id-card', [\App\Http\Controllers\Karyawan\DashboardController::class, 'generateIDCard'])
        ->name('karyawan.id-card');
});

/*
|--------------------------------------------------------------------------
| ADMIN (protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // Karyawan
    Route::get('/admin/karyawan', [KaryawanController::class, 'index'])
        ->name('admin.karyawan'); // Menampilkan tabel karyawan

    // Halaman tambah karyawan dihapus, menggunakan modal pada dashboard

    Route::post('/admin/karyawan/store', [KaryawanController::class, 'store'])
        ->name('admin.karyawan.store'); // Tambah karyawan

    Route::get('/admin/karyawan/{id}/edit', [KaryawanController::class, 'edit'])
        ->name('admin.karyawan.edit'); // Ambil data untuk modal edit

    // Halaman edit karyawan dihapus, menggunakan modal pada dashboard

    Route::put('/admin/karyawan/{id}/update', [KaryawanController::class, 'update'])
        ->name('admin.karyawan.update'); // Update data (PUT from edit form)

    Route::delete('/admin/karyawan/{id}/delete', [KaryawanController::class, 'destroy'])
        ->name('admin.karyawan.delete'); // Hapus data

    // Users Management
    Route::get('/admin/users', [UsersController::class, 'index'])
        ->name('admin.users.index');

    Route::post('/admin/users/store', [UsersController::class, 'store'])
        ->name('admin.users.store');

    Route::put('/admin/users/{user}/update', [UsersController::class, 'update'])
        ->name('admin.users.update');

    Route::delete('/admin/users/{user}/delete', [UsersController::class, 'destroy'])
        ->name('admin.users.delete');

    // History
    Route::get('/admin/history', [HistoryController::class, 'index'])
        ->name('admin.history');

    // Report
    Route::get('/admin/report', [ReportController::class, 'index'])
        ->name('admin.report');
    
    Route::post('/admin/report/generate', [ReportController::class, 'generatePDF'])
        ->name('admin.report.generate');

    Route::get('/admin/report/preview/{id}', [ReportController::class, 'preview'])
        ->name('admin.report.preview');

    // Profile
    Route::get('/admin/profile', [ProfileController::class, 'show'])
        ->name('admin.profile');
    
    Route::put('/admin/profile/update', [ProfileController::class, 'update'])
        ->name('admin.profile.update');
    
    Route::put('/admin/profile/update-password', [ProfileController::class, 'updatePassword'])
        ->name('admin.profile.update-password');
});

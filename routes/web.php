<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KaryawanController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\HistoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\TrainingController as AdminTrainingController;
use App\Http\Controllers\Admin\LeaveController as AdminLeaveController;
use App\Http\Controllers\Admin\ProfileUpdateController;

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
| KARYAWAN (protected - Role: Karyawan)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'karyawan.role'])->group(function () {
    Route::get('/karyawan/dashboard', [\App\Http\Controllers\Karyawan\DashboardController::class, 'index'])
        ->name('karyawan.dashboard');

    Route::get('/karyawan/profile', [\App\Http\Controllers\Karyawan\DashboardController::class, 'profile'])
        ->name('karyawan.profile');

    Route::get('/karyawan/id-card/{nik}', [\App\Http\Controllers\Karyawan\DashboardController::class, 'generateIDCard'])
        ->name('karyawan.id-card');

    // Training Routes
    Route::get('/karyawan/training', [\App\Http\Controllers\Karyawan\TrainingController::class, 'index'])
        ->name('karyawan.training.index');
    Route::get('/karyawan/training/create', [\App\Http\Controllers\Karyawan\TrainingController::class, 'create'])
        ->name('karyawan.training.create');
    Route::post('/karyawan/training', [\App\Http\Controllers\Karyawan\TrainingController::class, 'store'])
        ->name('karyawan.training.store');
    Route::get('/karyawan/training/{training}', [\App\Http\Controllers\Karyawan\TrainingController::class, 'show'])
        ->name('karyawan.training.show');
    Route::get('/karyawan/training/{training}/edit', [\App\Http\Controllers\Karyawan\TrainingController::class, 'edit'])
        ->name('karyawan.training.edit');
    Route::put('/karyawan/training/{training}', [\App\Http\Controllers\Karyawan\TrainingController::class, 'update'])
        ->name('karyawan.training.update');
    Route::delete('/karyawan/training/{training}', [\App\Http\Controllers\Karyawan\TrainingController::class, 'destroy'])
        ->name('karyawan.training.destroy');

    // Leave Routes
    Route::get('/karyawan/leave', [\App\Http\Controllers\Karyawan\LeaveController::class, 'index'])
        ->name('karyawan.leave.index');
    Route::get('/karyawan/leave/create', [\App\Http\Controllers\Karyawan\LeaveController::class, 'create'])
        ->name('karyawan.leave.create');
    Route::post('/karyawan/leave', [\App\Http\Controllers\Karyawan\LeaveController::class, 'store'])
        ->name('karyawan.leave.store');
    Route::get('/karyawan/leave/{leave}', [\App\Http\Controllers\Karyawan\LeaveController::class, 'show'])
        ->name('karyawan.leave.show');
    Route::get('/karyawan/leave/{leave}/edit', [\App\Http\Controllers\Karyawan\LeaveController::class, 'edit'])
        ->name('karyawan.leave.edit');
    Route::put('/karyawan/leave/{leave}', [\App\Http\Controllers\Karyawan\LeaveController::class, 'update'])
        ->name('karyawan.leave.update');
    Route::delete('/karyawan/leave/{leave}', [\App\Http\Controllers\Karyawan\LeaveController::class, 'destroy'])
        ->name('karyawan.leave.destroy');
    Route::post('/karyawan/leave/{leave}/cancel', [\App\Http\Controllers\Karyawan\LeaveController::class, 'cancel'])
        ->name('karyawan.leave.cancel');

    // Profile Routes
    Route::get('/karyawan/profile/edit', [\App\Http\Controllers\Karyawan\ProfileController::class, 'edit'])
        ->name('karyawan.profile.edit');
    Route::put('/karyawan/profile', [\App\Http\Controllers\Karyawan\ProfileController::class, 'update'])
        ->name('karyawan.profile.update');
    Route::get('/karyawan/profile/history', [\App\Http\Controllers\Karyawan\ProfileController::class, 'history'])
        ->name('karyawan.profile.history');
    Route::post('/karyawan/profile-updates/{update}/cancel', [\App\Http\Controllers\Karyawan\ProfileController::class, 'cancelUpdate'])
        ->name('karyawan.profile-update.cancel');
});

/*
|--------------------------------------------------------------------------
| ADMIN (protected - Role: Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin.role'])->group(function () {

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

    // Notification Routes
    Route::get('/admin/notifications', [\App\Http\Controllers\Admin\NotificationController::class, 'index'])
        ->name('admin.notifications.index');
    Route::post('/admin/notifications/{notification}/read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])
        ->name('admin.notifications.read');
    Route::post('/admin/notifications/mark-all-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAllAsRead'])
        ->name('admin.notifications.mark-all-read');
    Route::get('/admin/notifications/unread-count', [\App\Http\Controllers\Admin\NotificationController::class, 'getUnreadCount'])
        ->name('admin.notifications.unread-count');

    // Training Routes (Admin)
    Route::get('/admin/training', [\App\Http\Controllers\Admin\TrainingController::class, 'index'])
        ->name('admin.training.index');
    Route::get('/admin/training/{training}', [\App\Http\Controllers\Admin\TrainingController::class, 'show'])
        ->name('admin.training.show');
    Route::post('/admin/training/{training}/approve', [\App\Http\Controllers\Admin\TrainingController::class, 'approve'])
        ->name('admin.training.approve');
    Route::post('/admin/training/{training}/reject', [\App\Http\Controllers\Admin\TrainingController::class, 'reject'])
        ->name('admin.training.reject');
    Route::get('/admin/training/{training}/download', [\App\Http\Controllers\Admin\TrainingController::class, 'downloadCertificate'])
        ->name('admin.training.download');
    Route::delete('/admin/training/{training}', [\App\Http\Controllers\Admin\TrainingController::class, 'destroy'])
        ->name('admin.training.destroy');

    // Leave Routes (Admin)
    Route::get('/admin/leave', [\App\Http\Controllers\Admin\LeaveController::class, 'index'])
        ->name('admin.leave.index');
    Route::get('/admin/leave/statistics', [\App\Http\Controllers\Admin\LeaveController::class, 'statistics'])
        ->name('admin.leave.statistics');
    Route::get('/admin/leave/{leave}', [\App\Http\Controllers\Admin\LeaveController::class, 'show'])
        ->name('admin.leave.show');
    Route::post('/admin/leave/{leave}/approve', [\App\Http\Controllers\Admin\LeaveController::class, 'approve'])
        ->name('admin.leave.approve');
    Route::post('/admin/leave/{leave}/reject', [\App\Http\Controllers\Admin\LeaveController::class, 'reject'])
        ->name('admin.leave.reject');

    // Profile Update Routes (Admin)
    Route::get('/admin/profile-updates', [\App\Http\Controllers\Admin\ProfileUpdateController::class, 'index'])
        ->name('admin.profile-updates.index');
    Route::post('/admin/profile-updates/{update}/approve', [\App\Http\Controllers\Admin\ProfileUpdateController::class, 'approve'])
        ->name('admin.profile-updates.approve');
    Route::post('/admin/profile-updates/{update}/reject', [\App\Http\Controllers\Admin\ProfileUpdateController::class, 'reject'])
        ->name('admin.profile-updates.reject');
});

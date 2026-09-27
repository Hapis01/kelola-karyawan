<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\KaryawanController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\TrainingController;
use App\Http\Controllers\Api\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group.
|
*/

// ==================== PUBLIC ROUTES ====================

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// ==================== PROTECTED ROUTES ====================

Route::middleware('auth:sanctum')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Refresh Token
    Route::post('/refresh-token', [AuthController::class, 'refreshToken']);

    // ==================== PROFILE ====================
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
    Route::post('/profile/update-password', [ProfileController::class, 'updatePassword']);

    // ==================== KARYAWAN ====================
    Route::apiResource('karyawan', KaryawanController::class);
    Route::get('/karyawan/search', [KaryawanController::class, 'search']);

    // ==================== LEAVE (CUTI) ====================
    Route::apiResource('leaves', LeaveController::class);
    Route::get('/leaves/status/{status}', [LeaveController::class, 'filterByStatus']);
    Route::post('/leaves/{leave}/approve', [LeaveController::class, 'approve']);
    Route::post('/leaves/{leave}/reject', [LeaveController::class, 'reject']);

    // ==================== TRAINING ====================
    Route::apiResource('trainings', TrainingController::class);
    Route::post('/trainings/{training}/enroll', [TrainingController::class, 'enroll']);
    Route::delete('/trainings/{training}/cancel', [TrainingController::class, 'cancelEnrollment']);

});

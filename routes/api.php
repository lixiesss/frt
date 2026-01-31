<?php

use App\Http\Controllers\Api\Admin\ApplicantController as AdminApplicantController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\FgdGroupController;
use App\Http\Controllers\Api\Admin\FgdSessionController;
use App\Http\Controllers\Api\Admin\FgdTestController;
use App\Http\Controllers\Api\Admin\FgdTopicController;
use App\Http\Controllers\Api\Admin\NotificationController;
use App\Http\Controllers\Api\Applicant\ApplicationController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\MajorController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::middleware(['web'])->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('google/redirect', [AuthController::class, 'redirectToGoogle']);
        Route::get('google/callback', [AuthController::class, 'handleGoogleCallback']);
    });
});
Route::get('departments', [DepartmentController::class, 'index']);
Route::get('majors', [MajorController::class, 'index']);

// Applicant
Route::middleware(['auth:sanctum', 'applicant'])->prefix('applicant')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    
    // Application management
    Route::get('application', [ApplicationController::class, 'index']);
    Route::post('application', [ApplicationController::class, 'store']);
    Route::patch('application/{id}', [ApplicationController::class, 'update']);
});

// Admin
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'me']);
    
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
    
    // Applicant management
    Route::get('applicants', [AdminApplicantController::class, 'index']);
    Route::get('applicants/{id}', [AdminApplicantController::class, 'show']);
    Route::patch('applicants/{id}/stage', [AdminApplicantController::class, 'updateStage']);
    Route::patch('applicants/{id}/assign-group', [AdminApplicantController::class, 'assignToGroup']);
    
    // FGD Management
    Route::apiResource('fgd-groups', FgdGroupController::class);
    Route::apiResource('fgd-sessions', FgdSessionController::class);
    Route::apiResource('fgd-topics', FgdTopicController::class);
    Route::get('fgd-topics/{id}/tests', [FgdTopicController::class, 'tests']);
    Route::apiResource('fgd-tests', FgdTestController::class);
    
    // Notifications
    Route::post('notifications/send-fgd', [NotificationController::class, 'sendFgdNotification']);
});

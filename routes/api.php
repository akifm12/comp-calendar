<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\RegulatorController;
use App\Http\Controllers\Api\V1\LicenseActivityController;
use App\Http\Controllers\Api\V1\ComplianceRequirementController;
use App\Http\Controllers\Api\V1\ComplianceCalendarController;
use App\Http\Controllers\Api\V1\UserComplianceProfileController;
use App\Http\Controllers\Api\V1\FcmTokenController;
use App\Http\Controllers\Api\V1\UserEventCompletionController;
use App\Http\Controllers\Api\V1\UserCustomDeadlineController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    // Auth
    Route::post('auth/login',    [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);

    // Public compliance data
    Route::get('regulators',              [RegulatorController::class, 'index']);
    Route::get('regulators/{regulator}',  [RegulatorController::class, 'show']);
    Route::get('license-activities',      [LicenseActivityController::class, 'index']);
    Route::get('compliance-requirements', [ComplianceRequirementController::class, 'index']);
    Route::get('compliance-calendar',     [ComplianceCalendarController::class, 'index']);

    // Authenticated
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::get('auth/me',      [AuthController::class, 'me']);

        Route::get('user/compliance-profiles',                            [UserComplianceProfileController::class, 'index']);
        Route::post('user/compliance-profiles',                           [UserComplianceProfileController::class, 'store']);
        Route::delete('user/compliance-profiles/{userComplianceProfile}', [UserComplianceProfileController::class, 'destroy']);

        Route::post('user/fcm-token', [FcmTokenController::class, 'store']);

        // Event completions (mark as done / toggle)
        Route::get('user/completed-events',          [UserEventCompletionController::class, 'index']);
        Route::post('user/completed-events/toggle',  [UserEventCompletionController::class, 'toggle']);

        // Custom deadlines (CRUD)
        Route::get('user/custom-deadlines',                          [UserCustomDeadlineController::class, 'index']);
        Route::post('user/custom-deadlines',                         [UserCustomDeadlineController::class, 'store']);
        Route::put('user/custom-deadlines/{customDeadline}',         [UserCustomDeadlineController::class, 'update']);
        Route::delete('user/custom-deadlines/{customDeadline}',      [UserCustomDeadlineController::class, 'destroy']);
    });
});

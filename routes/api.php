<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthControllerntroller::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/jobs', [JobController::class, 'index']);

Route::post('/jobs/{id}/apply', [ApplicationController::class, 'apply'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/jobs', [JobController::class, 'store']);
    // Route::get('/jobs/mine', [JobController::class, 'myJobs']);
    // Route::get('/jobs/{id}/applications', [ApplicationController::class, 'showApplicants']);
});

<?php

use App\Http\Controllers\CareerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionTypeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
     Route::apiResource('career', CareerController::class);
    Route::apiResource('course', CourseController::class);
    Route::apiResource('location', LocationController::class);
    Route::apiResource('permission', PermissionController::class);
    Route::apiResource('permissionType', PermissionTypeController::class);
    Route::apiResource('users', UserController::class);

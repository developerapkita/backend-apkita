<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\ImportDataController;
use App\Http\Controllers\Api\ProfileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/v1/user', function (Request $request) {
    
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/otp-send', [AuthController::class, 'otp_send']);
Route::post('/otp-verification', [AuthController::class, 'otp_verification']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/data-province', [AuthController::class, 'province']);
Route::get('/data-regency', [AuthController::class, 'regency']);
Route::get('/data-district', [AuthController::class, 'district']);
Route::POST('/token_validate', [AuthController::class, 'token_validate']);
Route::POST('/profile-complete', [AuthController::class, 'profile_complete']);
Route::POST('/set-pin', [AuthController::class, 'set_pin']);
Route::POST('/pin-validate', [AuthController::class, 'pin_validate']);

//ROUTING FOR PROFILE
Route::middleware(['auth.token','auth.role:member'])->group(function () {
    Route::get('/profile/{slug}', [ProfileController::class, 'show']);
    Route::put('/profile/{slug}', [ProfileController::class, 'update']);
});


//Community
Route::POST('/community/create', [CommunityController::class, 'create_community']);
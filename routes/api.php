<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\ImportDataController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\EventController;
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

// Route::middleware('auth:sanctum')->get('/v1/user', function (Request $request) {
    
// });

Route::post('/v1/register', [AuthController::class, 'register']);
Route::post('/v1/otp-send', [AuthController::class, 'otp_send']);
Route::post('/v1/otp-verification', [AuthController::class, 'otp_verification']);
Route::post('/v1/login', [AuthController::class, 'login']);
Route::POST('/v1/token_validate', [AuthController::class, 'token_validate']);
Route::POST('/v1/profile-complete/{slug}', [AuthController::class, 'profile_complete']);
Route::POST('/v1/set-pin', [AuthController::class, 'set_pin']);
Route::POST('/v1/pin-validate', [AuthController::class, 'pin_validate']);

Route::get('/v1/data-province', [PlaceController::class, 'getProvince']);
Route::get('/v1/data-regency/{provinceCode}', [PlaceController::class, 'getRegenciesByProvinceCode']);
Route::get('/v1/data-district/{regencyCode}', [PlaceController::class, 'getDistrictByRegencyCode']);

//ROUTING FOR PROFILE
Route::middleware(['auth:sanctum','rolecheck:member'])->prefix('/v1')->group(function () {
    Route::get('/profile/{slug}', [ProfileController::class, 'show']);
    Route::put('/profile/{slug}', [ProfileController::class, 'update']);

    Route::post('/community/create', [CommunityController::class, 'create_community']);

    Route::post('/event', [EventController::class, 'create']);
    Route::get("/event/{slug}",[EventController::class, 'show']);
    Route::put("/event/{slug}",[EventController::class, 'update']);
    Route::delete("/event/{slug}",[EventController::class, 'destroy']);
});


//Community

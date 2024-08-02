<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommunityController;
use App\Http\Controllers\Api\ImportDataController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PlaceController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ComplainController;

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

Route::get('/v1/data-province', [PlaceController::class, 'getProvince']);
Route::get('/v1/data-regency/{provinceCode}', [PlaceController::class, 'getRegenciesByProvinceCode']);
Route::get('/v1/data-district/{regencyCode}', [PlaceController::class, 'getDistrictByRegencyCode']);


Route::middleware(['auth:sanctum'])->prefix('/v1')->group(function () {
    //ROUTING FOR Auth
    Route::POST('/profile-complete/{slug}', [AuthController::class, 'profile_complete']);
    Route::POST('/set-pin/{id}', [AuthController::class, 'set_pin']);
    Route::POST('/pin-validate/{id}', [AuthController::class, 'pin_validate']);
    Route::POST('/update-pin/{slug}', [AuthController::class, 'update_pin']);
    Route::POST('/update-password/{slug}', [AuthController::class, 'update_password']);
    //ROUTING FOR PROFILE
    Route::get('/profile/{slug}', [ProfileController::class, 'show']);
    Route::put('/profile/{slug}', [ProfileController::class, 'update']);
    Route::post('/community/create/{slug}', [CommunityController::class, 'create_community']);
    Route::get('/community/{id}', [CommunityController::class, 'check_community']);
    Route::POST('/community/{id}/{inviter}/{slug}', [CommunityController::class, 'join_community_qr']);


    Route::middleware(['rolecheck:member'])->group(function () {
        Route::get("/complain/{slug}",[ComplainController::class, 'show']);
        Route::post("/complain",[ComplainController::class, 'create']);
        Route::put("/complain/{slug}",[ComplainController::class, 'update']);
        Route::delete("/complain/{slug}",[ComplainController::class, 'delete']);
    });
    Route::middleware(['rolecheck:admin,manager'])->group(function () {
        Route::post('/event', [EventController::class, 'create']);
        Route::get("/event/{slug}",[EventController::class, 'show']);
        Route::put("/event/{slug}",[EventController::class, 'update']);
        Route::delete("/event/{slug}",[EventController::class, 'destroy']);
    
        Route::put("/complain/{slug}",[ComplainController::class, 'replyData']);
    });

});

//Community

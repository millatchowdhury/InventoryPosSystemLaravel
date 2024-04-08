<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// User Authentication
Route::post('/user-registration', [UserController::class, 'UserRegistration']);
Route::post('/user-login', [UserController::class, 'UserLogin']);
Route::post('/send-otp', [UserController::class, 'SendOTPCode']);
Route::post('/verify-otp', [UserController::class, 'VerifyOTP']);
Route::post('/reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/user-update',[UserController::class, 'UpdateProfile'])->middleware([TokenVerificationMiddleware::class]);


// Category API
Route::post('/create-category', [CategoryController::class, 'CategoryCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/list-category', [CategoryController::class, 'CategoryList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/delete-category', [CategoryController::class, 'CategoryDelete'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/update-category', [CategoryController::class, 'CategoryUpdate'])->middleware([TokenVerificationMiddleware::class]);







// test perpose
// Route::post('/test-create-token', [UserController::class, 'testCreateToken']);
// Route::post('/test-verify-token', [UserController::class, 'testVerifyToken']);
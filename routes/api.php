<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController,
    AuthController,
    AdminController
};

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

Route::get('/', function () {
    return [
        'app' => 'Yorlad API',
        'version' => '1.0.0',
    ];
});

Route::get('/users', [AdminController::class, 'fetchAllUsers']);
Route::get('/products', [AdminController::class, 'fetchAllProducts']);
Route::get('/orders', [AdminController::class, 'fetchAllOrders']);
Route::get('/withdrawals', [AdminController::class, 'fetchAllWithdrawals']);

Route::post('/reset-password', [AuthController::class, 'resetPassword']);
Route::post('/send-otp', [AuthController::class, 'sendOtp']);
Route::post('/send-reset-otp', [AuthController::class, 'sendResetOtp']);
//Route::get('/plans', [UserController::class, 'getPlans']);
//Route::get('/plans/{planId}', [UserController::class, 'getPlanData']);
//Route::get('/withdrawals', [UserController::class, 'getWithdrawals']);
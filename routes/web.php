<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController,
    UserController,
    AdminController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [UserController::class, 'index']);
Route::group(['middleware' => ['guest']], function () {
    Route::get('/register/{referral?}', [AuthController::class, 'showRegistrationForm']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name("login");
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/account', [UserController::class, 'getAccount']);
    Route::get('/orders', [UserController::class, 'getOrders']);
    Route::get('/orders/active', [UserController::class, 'getActiveOrders']);
    Route::get('/orders/count', [UserController::class, 'getActiveOrderCount']);
    Route::get('/withdrawals', [UserController::class, 'getWithdrawals']);
    Route::post('/order', [UserController::class, 'order']);
    Route::get('/order/{id}', [UserController::class, 'getOrder']);
    Route::get('/order/task/{id}', [UserController::class, 'runDailyTask']);
    Route::post('/bank-details/verify', [UserController::class, 'verifyBankDetails']);
    Route::post('/bank-details', [UserController::class, 'addBankDetails']);
    Route::get('/products', [UserController::class, 'products']);
    Route::get('/product/{id}', [UserController::class, 'productData']);
    Route::post('/withdrawal/pin', [UserController::class, 'saveWithdrawalPin']);
    Route::post('/withdraw', [UserController::class, 'withdraw']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::group(['middleware' => ['yorlad']], function () {
        Route::get('/dashboard/logout', [AdminController::class, 'logout']);
        Route::get('/dashboard/', [AdminController::class, 'index']);
        Route::get('/dashboard/products', [AdminController::class, 'showProducts']);
        Route::get('/dashboard/orders', [AdminController::class, 'showOrders']);
        Route::get('/dashboard/withdrawals', [AdminController::class, 'showWithdrawals']);
        Route::get('/dashboard/order/confirm/{id}', [AdminController::class, 'confirmOrder']);
        Route::get('/dashboard/withdrawal/confirm/{id}', [AdminController::class, 'confirmWithdrawal']);
    });
});
Route::get('/payment-callback', [UserController::class, 'verifyTransaction']);
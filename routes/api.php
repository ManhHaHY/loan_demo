<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\LoansController;
use App\Http\Controllers\Api\PaymentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'namespace' => 'Api',
    'prefix' => 'v1/'
], function () {
    Route::group([
        'prefix' => 'auth'
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);

        Route::group([
            'middleware' => ['auth:sanctum'],
        ], function () {
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });

    Route::group([
        'middleware' => ['auth:sanctum']
    ], function(){
        Route::match(['get', 'post'],'/loans/search', [LoansController::class, 'index']);
        Route::match(['put', 'patch','post'], '/loans/update/{loan}', [LoansController::class, 'update']);
        Route::post('loans', [LoansController::class, 'store']);
        Route::patch('loans/approve', [LoansController::class, 'approveLoan']);
        Route::get('loans/detail/{loan}', [LoansController::class, 'show']);

        Route::match(['get', 'post'],'payment/list', [PaymentController::class, 'listPayment']);
        Route::post('payment/create', [PaymentController::class, 'loanPayment']);
        Route::post('payment/approve', [PaymentController::class, 'approvePayment']);
        Route::get('payment/detail/{paymentId}', [PaymentController::class, 'paymentDetails']);
    });

});

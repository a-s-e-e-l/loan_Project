<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Code_requestController;
use App\Http\Controllers\update_userController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\all_userController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/request/code', [Code_requestController::class, 'code_request']);
//Route::post('/login', [LoginController::class, 'login']);
Route::post('/process/verification/code', [LoginController::class, 'login']);
Route::post('/user/update', [update_userController::class, 'update']);
Route::post('/process/payment', [paymentController::class, 'payment']);
Route::post('/users/all', [all_userController::class, 'all_user']);
Route::post('/users/debtor', [all_userController::class, 'debtor_user']);
Route::post('/users/creditor', [all_userController::class, 'creditor_user']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

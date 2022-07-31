<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Code_requestController;
use App\Http\Controllers\update_userController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\pay_loanController;
use App\Http\Controllers\all_userController;
use App\Http\Controllers\nearController;
use App\Http\Controllers\notificationController;
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
Route::post('/login', [LoginController::class, 'login']);

Route::get('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::post('/user/update', [update_userController::class, 'update'])->middleware('auth:sanctum');
Route::post('/user/setup', [update_userController::class, 'setup'])->middleware('auth:sanctum');
Route::get('/user/edit', [update_userController::class, 'edit'])->middleware('auth:sanctum');

/*
 * transacton/
 * debit // for add debit
 * credit // for add credit
 * payment // for add payment
 * accept  // for accept
 */
Route::post('/add_creditor', [paymentController::class, 'add_creditor'])->middleware('auth:sanctum');
Route::post('/add_debitor', [paymentController::class, 'add_debitor'])->middleware('auth:sanctum');
Route::post('/payment', [pay_loanController::class, 'payment'])->middleware('auth:sanctum');
Route::post('/accept', [paymentController::class, 'accept'])->middleware('auth:sanctum');

Route::get('/users/all', [all_userController::class, 'all_user'])->middleware('auth:sanctum');
Route::get('/users/debitor', [all_userController::class, 'debitor_user'])->middleware('auth:sanctum');
Route::get('/users/creditor', [all_userController::class, 'creditor_user'])->middleware('auth:sanctum');
Route::post('/user/search', [all_userController::class, 'search'])->middleware('auth:sanctum');

Route::post('/users/select', [nearController::class, 'select_user'])->middleware('auth:sanctum');

Route::get('/creditor/near', [nearController::class, 'near_creditor'])->middleware('auth:sanctum');
Route::get('/debitor/near', [nearController::class, 'near_debitor'])->middleware('auth:sanctum');

Route::post('/notification/add/to', [notificationController::class, 'add_notification_to'])->middleware('auth:sanctum');
Route::post('/notification/add/from', [notificationController::class, 'add_notification_from'])->middleware('auth:sanctum');
Route::get('/notification', [notificationController::class, 'all_notification'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

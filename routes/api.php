<?php

use App\Http\Controllers\LoginControllerController;
use App\Http\Controllers\Code_requestController;
use App\Http\Controllers\update_userController;
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
Route::post('/code_req', [Code_requestController::class, 'code_request']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/update-user', [update_userController::class, 'update']);


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

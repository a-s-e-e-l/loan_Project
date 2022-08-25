<?php

use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Dash_transaction\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Dash_user\UserController;
use App\Http\Controllers\LocalizationController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth:sanctum');
Route::get('/dashboard/user', function () {
    return view('dashboard1');
})->middleware('auth:sanctum');

require __DIR__ . '/auth.php';

Route::get('/admin', function () {
    return view('new');
})->middleware('auth:sanctum');

Route::post('/lang', [LocalizationController::class, 'setLang']);

Route::get('register', [RegisterController::class, 'create'])
    ->name('register');
Route::get('login', [LoginController::class, 'create'])
    ->name('login');
Route::controller(UserController::class)->group(function () {
    Route::get('users', 'index')->name('users')->middleware('auth:sanctum');
    Route::get('user/edit/{id}', 'edit')->name('user.edit')->middleware('auth:sanctum');
    Route::get('user/create', 'create')->name('user.create')->middleware('auth:sanctum');
    Route::post('user/store', 'store')->name('user.store')->middleware('auth:sanctum');
    Route::get('user/destroy/{id}', 'destroy')->name('user.destroy')->middleware('auth:sanctum');
    Route::get('user/show/{id}', 'show')->name('user.show')->middleware('auth:sanctum');
    Route::put('user/update/{id}', 'update')->name('user.update')->middleware('auth:sanctum');
});
Route::controller(TransactionController::class)->group(function () {
    Route::get('transactions', 'index')->name('transactions')->middleware('auth:sanctum');
    Route::get('transaction/edit/{id}', 'edit')->name('transaction.edit')->middleware('auth:sanctum');
    Route::get('transaction/create', 'create')->name('transaction.create')->middleware('auth:sanctum');
    Route::post('transaction/store', 'store')->name('transaction.store')->middleware('auth:sanctum');
    Route::get('transaction/destroy/{id}', 'destroy')->name('transaction.destroy')->middleware('auth:sanctum');
    Route::get('transaction/show/{id}', 'show')->name('transaction.show')->middleware('auth:sanctum');
    Route::put('transaction/update/{id}', 'update')->name('transaction.update')->middleware('auth:sanctum');
});

//Route::resource('users', UserController::class)->middleware('auth:sanctum');

Route::post('login', [LoginController::class, 'store']);
Route::post('register', [RegisterController::class, 'store']);

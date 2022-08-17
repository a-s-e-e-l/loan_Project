<?php

use App\Http\Controllers\Admin\Auth\RegisterController;
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

//    ->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
//require __DIR__ . '/admin.php';


Route::get('/admin', function () {
    return view('new');
});

Route::post('/lang', [LocalizationController::class, 'setLang']);

Route::post('/foo', function () {
    echo 1;
    return;
});
Route::get('register', [RegisterController::class, 'create'])
    ->name('register');
Route::get('login', [LoginController::class, 'create'])
    ->name('login');
//Route::get('login', [LoginController::class, 'create']);
//Route::get('register', [RegisterController::class, 'create']);
//
Route::get('user', [UserController::class, 'show'])
    ->name('user');
Route::post('login', [LoginController::class, 'store']);
Route::post('register', [RegisterController::class, 'store']);


Route::group([
    'namespace' => 'Auth',
], function () {
    Route::get('/adminpanel', function () {
        return view('layout.adminpanel.dashboard');
    });
//    Route::post('/log', [LoginController::class, 'store']);

// ... existing routes

});

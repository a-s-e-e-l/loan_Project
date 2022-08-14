<?php

use Illuminate\Support\Facades\Route;

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
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

Route::get('/new/dashboard', function () {
    return view('new');
});

Route::get('/login2', function () {
    return view('Auth.login2');
});

Route::get('/adminpanel', function () {
    return view('layout.adminpanel.dashboard');
});

Route::post('/lang', [LocalizationController::class, 'setLang']);

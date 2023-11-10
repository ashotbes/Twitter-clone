<?php

use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TweetController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', [TweetController::class, 'index'])->name('tweets.index')->middleware('auth');
Route::post('/tweets', [TweetController::class, 'store'])->name('tweets.store')->middleware('auth');
Route::delete('/tweets/{tweet}/delete', [TweetController::class, 'destroy'])->middleware('auth');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')->middleware('auth');

Route::get('/account/{tweet}', [AccountController::class, 'index'])->middleware('auth');
Route::post('/account/{tweet}/update', [AccountController::class, 'update'])->middleware('auth');

require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\FriendsController;
use App\Http\Controllers\MemoryController;
use App\Http\Controllers\MemoryPictureController;
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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::resource(
    '/memories',
    MemoryController::class
)->middleware(['auth', 'verified']);

Route::get('friends/search', [FriendsController::class, 'search'])->middleware(['auth', 'verified']);

Route::resource(
    '/friends',
    FriendsController::class
)->middleware(['auth', 'verified']);

Route::resource(
    '/memorypictures',
    MemoryPictureController::class
)->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';

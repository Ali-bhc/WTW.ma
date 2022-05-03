<?php

use App\Http\Controllers\MovieController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\RecommendationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;


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

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/bookmark/{movieId}' , [HomeController::class, 'bookmark'])->name('bookmark');

Route::post('/unBookmark/{movieId}' , [HomeController::class, 'UnBookmark'])->name('UnBookmark');

Route::get('/movie/{id}', [MovieController::class, 'index'])->name('movie');

Route::get('/person/{id}', [PersonController::class, 'index'])->name('person');

Route::get('/ForYou', [RecommendationController::class, 'index'])->name('ForYou')->middleware('auth');



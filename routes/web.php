<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AllMoviesController;
use App\Http\Controllers\AllActorsController;
use App\Http\Controllers\AllPersonsController;


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

Route::get('/', [HomeController::class, 'index'])->name('home');
//Route::get('/AllMovies/{page}', [AllMoviesController::class, 'getpage'])->name('AllMovies');
Route::get('/AllMovies/{page}', [AllMoviesController::class, 'getAllMovies']);
//Route::get('/AllActors/{page}', [AllActorsController::class, 'getpage'])->name('AllActors');
Route::get('/AllPersons/{page}', [AllPersonsController::class, 'getpage'])->name('AllPersons');


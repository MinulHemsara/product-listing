<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use App\Models\Listing;
// use App\Models\listing as ModelsListing;
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

Route::get('/', [ListingController::class,'index']);

Route::get('/listings/create', [ListingController::class,'create'])->middleware('auth');


Route::post('/listings', [ListingController::class,'store'])->middleware('auth');


Route::get('/listings/{listing}/edit', [ListingController::class,'edit'])->middleware('auth');

Route::put('/listings/{listing}',[ListingController::class,'update'])->middleware('auth');
Route::delete('/listings/{listing}',[ListingController::class,'delete'])->middleware('auth');

Route::get('/listings/manage',[ListingController::class,'manage'])->middleware('auth');


Route::get('/listings/{listing}', [ListingController::class,'show'])->middleware('guest');

Route::get('/register',[UserController::class,'create'])->middleware('guest');


Route::post('/users',[UserController::class,'store']);

Route::post('/logout',[UserController::class,'logout'])->middleware('auth');

Route::get('/login',[UserController::class,'login'])->name('guest');

Route::post('/users/authenticate',[UserController::class,'authenticate']);
<?php

use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BoardroomController;
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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::apiResource('boardroom',BoardroomController::class);
Route::apiResource('reservation',ReservationController::class);
Route::get('get-auth',[UserController::class,'getAuthUser'])->name('auth.get');
Route::get('delete-reservations',[ReservationController::class,'deleteReservations'])->name('delete.reservations');

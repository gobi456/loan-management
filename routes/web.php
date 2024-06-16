<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/loan-details', [LoanController::class, 'index'])->middleware('auth')->name('loan-details');
Route::get('/process-data', [LoanController::class, 'processData'])->middleware('auth');

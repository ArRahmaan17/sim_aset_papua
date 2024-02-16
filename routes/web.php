<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\Perolehan\PerolehanController;
use Illuminate\Support\Facades\Route;

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

Route::middleware(['authenticated'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/perolehan', [PerolehanController::class, 'index'])->name('perolehan');
    Route::name('master.')->group(function () {
        Route::get('/master/asal-usul', [MasterController::class, 'masterAsalUsul'])->name('asal-usul');
    });
});
Route::middleware(['un_authenticated'])->group(function () {
    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login-process');
});

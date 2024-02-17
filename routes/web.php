<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\Perolehan\PerolehanController;
use App\Imports\MasterImport;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;

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
    // DangerLine
    Route::get('/import-master', function () {
        Excel::import(new MasterImport, public_path('master.xlsx'));
        return response()->json(['status' => 'done', 'message' => 'Master imported']);
    })->name('home');
    // end DangerLine
    Route::get('/perolehan', [PerolehanController::class, 'index'])->name('perolehan');
    Route::name('master.')->group(function () {
        Route::get('/master/asal-usul', [MasterController::class, 'masterAsalUsul'])->name('asal-usul');
        Route::get('/master/kondisi', [MasterController::class, 'masterKondisi'])->name('kondisi');
    });
});
Route::middleware(['un_authenticated'])->group(function () {
    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login-process');
});

<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MenuController;
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

Route::middleware(['authenticated', 'have-organisasi'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    // DangerLine
    Route::get('/import-master', function () {
        Excel::import(new MasterImport, public_path('master.xlsx'));
        return response()->json(['status' => 'done', 'message' => 'Master imported']);
    })->name('import-master');
    // end DangerLine
    Route::middleware(['authenticated'])->name('master.')->group(function () {
        Route::get('/master/asal-usul', [MasterController::class, 'masterAsalUsul'])->name('asal-usul');
        Route::get('/master/kondisi', [MasterController::class, 'masterKondisi'])->name('kondisi');
        Route::get('/master/satuan', [MasterController::class, 'masterSatuan'])->name('satuan');
        Route::get('/master/status-tanah', [MasterController::class, 'masterStatusTanah'])->name('status-tanah');
        Route::get('/master/golongan-barang', [MasterController::class, 'masterGolonganBarang'])->name('golongan-barang');
        Route::get('/master/warna', [MasterController::class, 'masterWarna'])->name('warna');
        Route::get('/master/hak', [MasterController::class, 'masterHak'])->name('hak');
        Route::get('/master/menu', [MenuController::class, 'index'])->name('menu');
        Route::post('/master/update-parent-menu', [MenuController::class, 'updateParent'])->name('update-parent-menu');
        Route::get('/master/list-menu', [MenuController::class, 'all'])->name('list-menu');
        Route::get('/master/menu/show/{id}', [MenuController::class, 'show'])->name('menu.show');
        Route::post('/master/menu/store', [MenuController::class, 'store'])->name('menu.store');
    });
    Route::get('/perolehan', [PerolehanController::class, 'index'])->name('perolehan');
    Route::post('/perolehan/store', [PerolehanController::class, 'store'])->name('perolehan.store');
    Route::get('/perolehan/all-bap', [PerolehanController::class, 'getAllOrganizationBaps'])->name('perolehan.bap');
});
Route::middleware(['authenticated'])->group(function () {
    Route::post('/set-organisasi', [AuthController::class, 'setOrganisasi'])->name('set-organisasi');
    Route::get('/master/organisasi-child', [MasterController::class, 'masterOrganisasiChild'])->name('master.organisasi-child');
});
Route::middleware(['un_authenticated'])->group(function () {
    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('login-process');
});

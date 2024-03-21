<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GolonganBarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MasaManfaatController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\Perolehan\PerolehanController;
use App\Http\Controllers\RehabController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StatusTanahController;
use App\Http\Controllers\WarnaController;
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

Route::middleware(['throttle:application', 'authenticated', 'have-organisasi'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::name('master.')->group(function () {
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
        Route::get('/master/menu/show/{id?}', [MenuController::class, 'show'])->name('menu.show');
        Route::get('/master/menu/show/detail/{id?}', [MenuController::class, 'showDetail'])->name('menu.show-detail');
        Route::put('/master/menu/update/{id?}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/master/menu/delete/{id?}', [MenuController::class, 'destroy'])->name('menu.delete');
        Route::post('/master/menu/store', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/master/barang', [BarangController::class, 'index'])->name('barang');
        Route::get('/master/barang/show/{id?}', [BarangController::class, 'show'])->name('barang.show');
        Route::post('/master/barang/store', [BarangController::class, 'store'])->name('barang.store');
        Route::put('/master/barang/update/{id?}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/master/barang/delete/{id?}', [BarangController::class, 'destroy'])->name('barang.delete');
        Route::get('/master/barang/all', [BarangController::class, 'all'])->name('barang.all');
        Route::get('/master/masamanfaat', [MasaManfaatController::class, 'index'])->name('masamanfaat');
        Route::post('/master/masamanfaat/store', [MasaManfaatController::class, 'store'])->name('masamanfaat.store');
        Route::put('/master/masamanfaat/update/{id?}', [MasaManfaatController::class, 'update'])->name('masamanfaat.update');
        Route::get('/master/masamanfaat/data-table', [MasaManfaatController::class, 'dataTable'])->name('masamanfaat.data-table');
        Route::get('/master/masamanfaat/data-belum-masamanfaat', [MasaManfaatController::class, 'belumMasaManfaat'])->name('masamanfaat.data-belum-masamanfaat');
        Route::get('/master/masamanfaat/show/{id?}', [MasaManfaatController::class, 'show'])->name('masamanfaat.show');
        Route::delete('/master/masamanfaat/delete/{id?}', [MasaManfaatController::class, 'destroy'])->name('masamanfaat.delete');
        Route::get('/master/organisasi', [OrganisasiController::class, 'index'])->name('organisasi');
        Route::get('/master/organisasi/all', [OrganisasiController::class, 'all'])->name('organisasi.all');
        Route::get('/master/warna', [WarnaController::class, 'index'])->name('warna');
        Route::get('/master/warna/data-table', [WarnaController::class, 'dataTable'])->name('warna.data-table');
        Route::get('/master/warna/{id?}', [WarnaController::class, 'show'])->name('warna.show');
        Route::post('/master/warna/store', [WarnaController::class, 'store'])->name('warna.store');
        Route::put('/master/warna/update/{id?}', [WarnaController::class, 'update'])->name('warna.update');
        Route::delete('/master/warna/delete/{id?}', [WarnaController::class, 'destroy'])->name('warna.delete');
        Route::get('/master/lokasi', [LokasiController::class, 'index'])->name('lokasi');
        Route::get('/master/lokasi/data-table', [LokasiController::class, 'dataTable'])->name('lokasi.data-table');
        Route::get('/master/lokasi/show/{id?}', [LokasiController::class, 'show'])->name('lokasi.show');
        Route::post('/master/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
        Route::put('/master/lokasi/update/{id?}', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/master/lokasi/delete/{id?}', [LokasiController::class, 'destroy'])->name('lokasi.delete');
        Route::get('/master/satuan', [SatuanController::class, 'index'])->name('satuan');
        Route::post('/master/satuan/store', [SatuanController::class, 'store'])->name('satuan.store');
        Route::get('/master/satuan/data-table', [SatuanController::class, 'dataTable'])->name('satuan.data-table');
        Route::get('/master/satuan/show/{id?}', [SatuanController::class, 'show'])->name('satuan.show');
        Route::put('/master/satuan/update/{id?}', [SatuanController::class, 'update'])->name('satuan.update');
        Route::delete('/master/satuan/delete/{id?}', [SatuanController::class, 'destroy'])->name('satuan.delete');
        Route::get('/master/statustanah', [StatusTanahController::class, 'index'])->name('statustanah');
        Route::post('/master/statustanah/store', [StatusTanahController::class, 'store'])->name('statustanah.store');
        Route::get('/master/statustanah/show/{id?}', [StatusTanahController::class, 'show'])->name('statustanah.show');
        Route::get('/master/statustanah/data-table', [StatusTanahController::class, 'dataTable'])->name('statustanah.data-table');
        Route::put('/master/statustanah/update/{id?}', [StatusTanahController::class, 'update'])->name('statustanah.update');
        Route::delete('/master/statustanah/delete/{id?}', [StatusTanahController::class, 'destroy'])->name('statustanah.delete');
        Route::get('/master/golonganbarang', [GolonganBarangController::class, 'index'])->name('golonganbarang');
        Route::get('/master/golonganbarang/data-table', [GolonganBarangController::class, 'dataTable'])->name('golonganbarang.data-table');
        Route::post('/master/golonganbarang/store', [GolonganBarangController::class, 'store'])->name('golonganbarang.store');
        Route::get('/master/golonganbarang/show/{id?}', [GolonganBarangController::class, 'show'])->name('golonganbarang.show');
        Route::put('/master/golonganbarang/update/{id?}', [GolonganBarangController::class, 'update'])->name('golonganbarang.update');
        Route::delete('/master/golonganbarang/delete/{id?}', [GolonganBarangController::class, 'destroy'])->name('golonganbarang.delete');
        Route::get('/master/rehab', [RehabController::class, 'index'])->name('rehab');
        Route::post('/master/rehab/store', [RehabController::class, 'store'])->name('rehab.store');
        Route::get('/master/rehab/data-table', [RehabController::class, 'dataTable'])->name('rehab.data-table');
        Route::get('/master/rehab/show/{id?}', [RehabController::class, 'show'])->name('rehab.show');
        Route::put('/master/rehab/update/{id?}', [RehabController::class, 'update'])->name('rehab.update');
        Route::delete('/master/rehab/delete/{id?}', [RehabController::class, 'destroy'])->name('rehab.delete');
    });
    Route::get('/perolehan', [PerolehanController::class, 'index'])->name('perolehan');
    Route::post('/perolehan/store', [PerolehanController::class, 'store'])->name('perolehan.store');
    Route::put('/perolehan/update/{ba?}', [PerolehanController::class, 'update'])->name('perolehan.update');
    Route::get('/perolehan/all-bap', [PerolehanController::class, 'getAllOrganizationBaps'])->name('perolehan.bap');
    Route::get('/perolehan/bap/check/{ba?}/{column?}', [PerolehanController::class, 'bapCheck'])->name('perolehan.bap.check');
    Route::get('/perolehan/bap/detail/{id?}', [PerolehanController::class, 'getDetailBap'])->name('perolehan.bap.show');
    Route::get('/auth/app/logout', [AuthController::class, 'logout'])->name('logout.application');
    Route::get('/auth/system/logout', [AuthController::class, 'logout_system'])->name('logout.system');
});
Route::middleware(['throttle:application', 'authenticated'])->group(function () {
    Route::post('/set-organisasi', [AuthController::class, 'setOrganisasi'])->name('set-organisasi');
    Route::get('/', [HomeController::class, 'selectApplication'])->name('select-application')->middleware('select-app');
    Route::post('/', [HomeController::class, 'chooseApplication'])->name('choose-application')->middleware('select-app');
    Route::get('/master/organisasi-child', [MasterController::class, 'masterOrganisasiChild'])->name('master.organisasi-child');
});
Route::middleware(['un_authenticated'])->group(function () {
    // DangerLine
    // Route::get('/import-master', function () {
    //     Excel::import(new MasterImport, public_path('master.xlsx'));
    //     return response()->json(['status' => 'done', 'message' => 'Master imported']);
    // })->name('import-master');
    // end DangerLine
    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware(['throttle:login-process'])->name('login-process');
});

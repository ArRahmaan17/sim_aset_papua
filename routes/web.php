<?php

use App\Http\Controllers\AsalUsulController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\GolonganBarangController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JenisTransaksiController;
use App\Http\Controllers\JurnalController;
use App\Http\Controllers\KapitalisasiController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\KondisiController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\MasaManfaatController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PenyusutanController;
use App\Http\Controllers\Perolehan\PerolehanController;
use App\Http\Controllers\Perolehan\PerolehanSP2DController;
use App\Http\Controllers\RehabController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\StatusTanahController;
use App\Http\Controllers\UserControlController;
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
        Route::get('/master/data/asal-usul', [MasterController::class, 'masterAsalUsul'])->name('data.asal-usul');
        Route::get('/master/data/kondisi', [MasterController::class, 'masterKondisi'])->name('data.kondisi');
        Route::get('/master/data/satuan', [MasterController::class, 'masterSatuan'])->name('data.satuan');
        Route::get('/master/data/status-tanah', [MasterController::class, 'masterStatusTanah'])->name('data.status-tanah');
        Route::get('/master/data/golongan-barang', [MasterController::class, 'masterGolonganBarang'])->name('data.golongan-barang');
        Route::get('/master/data/warna', [MasterController::class, 'masterWarna'])->name('data.warna');
        Route::get('/master/data/hak', [MasterController::class, 'masterHak'])->name('data.hak');
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
        Route::get('/master/organisasi/useable', [OrganisasiController::class, 'useable'])->name('organisasi.useable');
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
        Route::get('/master/ruangan', [RuanganController::class, 'index'])->name('ruangan');
        Route::get('/master/ruangan/data-table', [RuanganController::class, 'dataTable'])->name('ruangan.data-table');
        Route::get('/master/ruangan/last-room-number/{organisasi?}', [RuanganController::class, 'lastRoomNumber'])->name('ruangan.last-room-number');
        Route::get('/master/ruangan/show/{id?}', [RuanganController::class, 'show'])->name('ruangan.show');
        Route::post('/master/ruangan/store', [RuanganController::class, 'store'])->name('ruangan.store');
        Route::put('/master/ruangan/update/{id?}', [RuanganController::class, 'update'])->name('ruangan.update');
        Route::delete('/master/ruangan/delete/{id?}', [RuanganController::class, 'destroy'])->name('ruangan.delete');
        Route::get('/master/kondisi', [KondisiController::class, 'index'])->name('kondisi');
        Route::get('/master/kondisi/data-table', [KondisiController::class, 'dataTable'])->name('kondisi.data-table');
        Route::get('/master/kondisi/show/{id?}', [KondisiController::class, 'show'])->name('kondisi.show');
        Route::post('/master/kondisi/store', [KondisiController::class, 'store'])->name('kondisi.store');
        Route::put('/master/kondisi/update/{id?}', [KondisiController::class, 'update'])->name('kondisi.update');
        Route::delete('/master/kondisi/delete/{id?}', [KondisiController::class, 'destroy'])->name('kondisi.delete');
        Route::get('/master/klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi');
        Route::get('/master/klasifikasi/data-table', [KlasifikasiController::class, 'dataTable'])->name('klasifikasi.data-table');
        Route::get('/master/klasifikasi/show/{id?}', [KlasifikasiController::class, 'show'])->name('klasifikasi.show');
        Route::post('/master/klasifikasi/store', [KlasifikasiController::class, 'store'])->name('klasifikasi.store');
        Route::put('/master/klasifikasi/update/{id?}', [KlasifikasiController::class, 'update'])->name('klasifikasi.update');
        Route::delete('/master/klasifikasi/delete/{id?}', [KlasifikasiController::class, 'destroy'])->name('klasifikasi.delete');
        Route::get('/master/jurnal', [JurnalController::class, 'index'])->name('jurnal');
        Route::get('/master/jurnal/data-table', [JurnalController::class, 'dataTable'])->name('jurnal.data-table');
        Route::get('/master/jurnal/show/{id?}', [JurnalController::class, 'show'])->name('jurnal.show');
        Route::post('/master/jurnal/store', [JurnalController::class, 'store'])->name('jurnal.store');
        Route::put('/master/jurnal/update/{id?}', [JurnalController::class, 'update'])->name('jurnal.update');
        Route::delete('/master/jurnal/delete/{id?}', [JurnalController::class, 'destroy'])->name('jurnal.delete');
        Route::get('/master/jenis-transaksi', [JenisTransaksiController::class, 'index'])->name('jenis-transaksi');
        Route::get('/master/jenis-transaksi/data-table', [JenisTransaksiController::class, 'dataTable'])->name('jenis-transaksi.data-table');
        Route::get('/master/jenis-transaksi/show/{id?}', [JenisTransaksiController::class, 'show'])->name('jenis-transaksi.show');
        Route::post('/master/jenis-transaksi/store', [JenisTransaksiController::class, 'store'])->name('jenis-transaksi.store');
        Route::put('/master/jenis-transaksi/update/{id?}', [JenisTransaksiController::class, 'update'])->name('jenis-transaksi.update');
        Route::delete('/master/jenis-transaksi/delete/{id?}', [JenisTransaksiController::class, 'destroy'])->name('jenis-transaksi.delete');
        Route::get('/master/kapitalisasi', [KapitalisasiController::class, 'index'])->name('kapitalisasi');
        Route::get('/master/kapitalisasi/useable-kobarang', [KapitalisasiController::class, 'useable'])->name('kapitalisasi.useable-kobarang');
        Route::get('/master/kapitalisasi/data-table', [KapitalisasiController::class, 'dataTable'])->name('kapitalisasi.data-table');
        Route::get('/master/kapitalisasi/show/{id?}', [KapitalisasiController::class, 'show'])->name('kapitalisasi.show');
        Route::post('/master/kapitalisasi/store', [KapitalisasiController::class, 'store'])->name('kapitalisasi.store');
        Route::put('/master/kapitalisasi/update/{id?}', [KapitalisasiController::class, 'update'])->name('kapitalisasi.update');
        Route::delete('/master/kapitalisasi/delete/{id?}', [KapitalisasiController::class, 'destroy'])->name('kapitalisasi.delete');
        Route::get('/master/asal-usul', [AsalUsulController::class, 'index'])->name('asal-usul');
        Route::get('/master/asal-usul/useable', [AsalUsulController::class, 'useable'])->name('asal-usul.useable');
        Route::get('/master/asal-usul/data-table', [AsalUsulController::class, 'dataTable'])->name('asal-usul.data-table');
        Route::get('/master/asal-usul/show/{id?}', [AsalUsulController::class, 'show'])->name('asal-usul.show');
        Route::post('/master/asal-usul/store', [AsalUsulController::class, 'store'])->name('asal-usul.store');
        Route::put('/master/asal-usul/update/{id?}', [AsalUsulController::class, 'update'])->name('asal-usul.update');
        Route::delete('/master/asal-usul/delete/{id?}', [AsalUsulController::class, 'destroy'])->name('asal-usul.delete');
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
        Route::get('/master/rehab/list-barang', [RehabController::class, 'listBarang'])->name('rehab.list-barang');
        Route::get('/master/rehab/data-table', [RehabController::class, 'dataTable'])->name('rehab.data-table');
        Route::get('/master/rehab/show/{id?}', [RehabController::class, 'show'])->name('rehab.show');
        Route::put('/master/rehab/update/{id?}', [RehabController::class, 'update'])->name('rehab.update');
        Route::delete('/master/rehab/delete/{id?}', [RehabController::class, 'destroy'])->name('rehab.delete');
    });
    Route::get('/perolehan-sp2d', [PerolehanSP2DController::class, 'index'])->name('perolehan-sp2d');
    Route::post('/perolehan-sp2d/store', [PerolehanSP2DController::class, 'store'])->name('perolehan-sp2d.store');
    Route::put('/perolehan-sp2d/update/{ba?}', [PerolehanSP2DController::class, 'update'])->name('perolehan-sp2d.update');
    Route::get('/perolehan-sp2d/all-kegiatan/{idprogram?}', [PerolehanSP2DController::class, 'getKegiatan'])->name('perolehan-sp2d.get-kegiatan');
    Route::get('/perolehan-sp2d/bap/detail/{id?}', [PerolehanSP2DController::class, 'getDetailBap'])->name('perolehan-sp2d.bap.show');
    Route::get('/perolehan-sp2d/all-rekening/{idkegiatan?}', [PerolehanSP2DController::class, 'getRekening'])->name('perolehan-sp2d.get-rekening');
    Route::get('/perolehan', [PerolehanController::class, 'index'])->name('perolehan');
    Route::post('/perolehan/store', [PerolehanController::class, 'store'])->name('perolehan.store');
    Route::put('/perolehan/update/{ba?}', [PerolehanController::class, 'update'])->name('perolehan.update');
    Route::get('/perolehan/all-bap', [PerolehanController::class, 'getAllOrganizationBaps'])->name('perolehan.bap');
    Route::get('/perolehan/bap/check/{ba?}/{column?}', [PerolehanController::class, 'bapCheck'])->name('perolehan.bap.check');
    Route::get('/perolehan/bap/detail/{id?}', [PerolehanController::class, 'getDetailBap'])->name('perolehan.bap.show');
    Route::get('/penyusutan', [PenyusutanController::class, 'index'])->name('penyusutan');
    Route::get('/auth/app/logout', [AuthController::class, 'logout'])->name('logout.application');
    Route::get('/auth/system/logout', [AuthController::class, 'logout_system'])->name('logout.system');
    Route::name('control.')->group(function () {
        Route::get('/control-user', [UserControlController::class, 'index'])->name('user');
        Route::post('/control-user', [UserControlController::class, 'profileChange'])->name('user');
        Route::get('/control-user/user-role', [UserControlController::class, 'dataTable'])->name('user-role.data-table');
        Route::get('/control-user/role', [UserControlController::class, 'roleCreate'])->name('role.create');
        Route::post('/control-user/role', [UserControlController::class, 'roleStore'])->name('role.store');
        Route::get('/control-user/role/{id?}', [UserControlController::class, 'roleShow'])->name('role.show');
        Route::put('/control-user/role/{id?}', [UserControlController::class, 'roleUpdate'])->name('role.update');
        Route::delete('/control-user/role/{id?}', [UserControlController::class, 'roleDestroy'])->name('role.delete');
        Route::get('/control-user/create', [UserControlController::class, 'userCreate'])->name('create-user');
    });
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

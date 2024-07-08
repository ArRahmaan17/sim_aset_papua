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
use App\Http\Controllers\Perolehan\PerolehanAPBDController;
use App\Http\Controllers\Perolehan\PerolehanController;
use App\Http\Controllers\Perolehan\PerolehanSP2DController;
use App\Http\Controllers\RehabController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\Sp2dController;
use App\Http\Controllers\ssh\Master\HakTanahController;
use App\Http\Controllers\ssh\Master\JenisAsset;
use App\Http\Controllers\ssh\Master\MasterKib;
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
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['menu-permission']);
    Route::name('master.')->prefix('master')->group(function () {
        Route::get('/data/asal-usul', [MasterController::class, 'masterAsalUsul'])->name('data.asal-usul');
        Route::get('/data/kib-master', [MasterController::class, 'masterKib'])->name('data.kib_master');
        Route::get('/data/kondisi', [MasterController::class, 'masterKondisi'])->name('data.kondisi');
        Route::get('/data/satuan', [MasterController::class, 'masterSatuan'])->name('data.satuan');
        Route::get('/data/status-tanah', [MasterController::class, 'masterStatusTanah'])->name('data.status-tanah');
        Route::get('/data/golongan-barang', [MasterController::class, 'masterGolonganBarang'])->name('data.golongan-barang');
        Route::get('/data/warna', [MasterController::class, 'masterWarna'])->name('data.warna');
        Route::get('/data/hak', [MasterController::class, 'masterHak'])->name('data.hak');
        Route::get('/menu', [MenuController::class, 'index'])->name('menu')->middleware(['menu-permission']);
        Route::post('/update-parent-menu', [MenuController::class, 'updateParent'])->name('update-parent-menu');
        Route::get('/list-menu', [MenuController::class, 'all'])->name('list-menu');
        Route::get('/menu/show/{id?}', [MenuController::class, 'show'])->name('menu.show');
        Route::get('/menu/show/detail/{id?}', [MenuController::class, 'showDetail'])->name('menu.show-detail');
        Route::put('/menu/update/{id?}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/menu/delete/{id?}', [MenuController::class, 'destroy'])->name('menu.delete');
        Route::post('/menu/store', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/barang', [BarangController::class, 'index'])->name('barang')->middleware(['menu-permission']);
        Route::get('/barang/show/{id?}', [BarangController::class, 'show'])->name('barang.show');
        Route::post('/barang/store', [BarangController::class, 'store'])->name('barang.store');
        Route::put('/barang/update/{id?}', [BarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/delete/{id?}', [BarangController::class, 'destroy'])->name('barang.delete');
        Route::get('/barang/all', [BarangController::class, 'all'])->name('barang.all');
        Route::get('/masamanfaat', [MasaManfaatController::class, 'index'])->name('masamanfaat')->middleware(['menu-permission']);
        Route::post('/masamanfaat/store', [MasaManfaatController::class, 'store'])->name('masamanfaat.store');
        Route::put('/masamanfaat/update/{id?}', [MasaManfaatController::class, 'update'])->name('masamanfaat.update');
        Route::get('/masamanfaat/data-table', [MasaManfaatController::class, 'dataTable'])->name('masamanfaat.data-table');
        Route::get('/masamanfaat/data-belum-masamanfaat', [MasaManfaatController::class, 'belumMasaManfaat'])->name('masamanfaat.data-belum-masamanfaat');
        Route::get('/masamanfaat/show/{id?}', [MasaManfaatController::class, 'show'])->name('masamanfaat.show');
        Route::delete('/masamanfaat/delete/{id?}', [MasaManfaatController::class, 'destroy'])->name('masamanfaat.delete');
        Route::get('/organisasi', [OrganisasiController::class, 'index'])->name('organisasi')->middleware(['menu-permission']);
        Route::get('/organisasi/all', [OrganisasiController::class, 'all'])->name('organisasi.all');
        Route::get('/organisasi/useable', [OrganisasiController::class, 'useable'])->name('organisasi.useable');
        Route::get('/warna', [WarnaController::class, 'index'])->name('warna')->middleware(['menu-permission']);
        Route::get('/warna/data-table', [WarnaController::class, 'dataTable'])->name('warna.data-table');
        Route::get('/warna/{id?}', [WarnaController::class, 'show'])->name('warna.show');
        Route::post('/warna/store', [WarnaController::class, 'store'])->name('warna.store');
        Route::put('/warna/update/{id?}', [WarnaController::class, 'update'])->name('warna.update');
        Route::delete('/warna/delete/{id?}', [WarnaController::class, 'destroy'])->name('warna.delete');
        Route::get('/hak-tanah', [HakTanahController::class, 'index'])->name('hak-tanah')->middleware(['menu-permission']);
        Route::get('/hak-tanah/data-table', [HakTanahController::class, 'dataTable'])->name('hak-tanah.data-table');
        Route::get('/hak-tanah/{id?}', [HakTanahController::class, 'show'])->name('hak-tanah.show');
        Route::post('/hak-tanah/store', [HakTanahController::class, 'store'])->name('hak-tanah.store');
        Route::put('/hak-tanah/update/{id?}', [HakTanahController::class, 'update'])->name('hak-tanah.update');
        Route::delete('/hak-tanah/delete/{id?}', [HakTanahController::class, 'destroy'])->name('hak-tanah.delete');
        Route::get('/master-kib', [MasterKib::class, 'index'])->name('master-kib')->middleware(['menu-permission']);
        Route::get('/master-kib/data-table', [MasterKib::class, 'dataTable'])->name('master-kib.data-table');
        Route::get('/master-kib/{id?}', [MasterKib::class, 'show'])->name('master-kib.show');
        Route::post('/master-kib/store', [MasterKib::class, 'store'])->name('master-kib.store');
        Route::put('/master-kib/update/{id?}', [MasterKib::class, 'update'])->name('master-kib.update');
        Route::delete('/master-kib/delete/{id?}', [MasterKib::class, 'destroy'])->name('master-kib.delete');
        Route::get('/jenis-aset', [JenisAsset::class, 'index'])->name('jenis-aset')->middleware(['menu-permission']);
        Route::get('/jenis-aset/data-table', [JenisAsset::class, 'dataTable'])->name('jenis-aset.data-table');
        Route::get('/jenis-aset/{id?}', [JenisAsset::class, 'show'])->name('jenis-aset.show');
        Route::post('/jenis-aset/store', [JenisAsset::class, 'store'])->name('jenis-aset.store');
        Route::put('/jenis-aset/update/{id?}', [JenisAsset::class, 'update'])->name('jenis-aset.update');
        Route::delete('/jenis-aset/delete/{id?}', [MasterKib::class, 'destroy'])->name('jenis-aset.delete');
        Route::get('/lokasi', [LokasiController::class, 'index'])->name('lokasi')->middleware(['menu-permission']);
        Route::get('/lokasi/data-table', [LokasiController::class, 'dataTable'])->name('lokasi.data-table');
        Route::get('/lokasi/show/{id?}', [LokasiController::class, 'show'])->name('lokasi.show');
        Route::post('/lokasi/store', [LokasiController::class, 'store'])->name('lokasi.store');
        Route::put('/lokasi/update/{id?}', [LokasiController::class, 'update'])->name('lokasi.update');
        Route::delete('/lokasi/delete/{id?}', [LokasiController::class, 'destroy'])->name('lokasi.delete');
        Route::get('/ruangan', [RuanganController::class, 'index'])->name('ruangan')->middleware(['menu-permission']);
        Route::get('/ruangan/data-table', [RuanganController::class, 'dataTable'])->name('ruangan.data-table');
        Route::get('/ruangan/last-room-number/{organisasi?}', [RuanganController::class, 'lastRoomNumber'])->name('ruangan.last-room-number');
        Route::get('/ruangan/show/{id?}', [RuanganController::class, 'show'])->name('ruangan.show');
        Route::post('/ruangan/store', [RuanganController::class, 'store'])->name('ruangan.store');
        Route::put('/ruangan/update/{id?}', [RuanganController::class, 'update'])->name('ruangan.update');
        Route::delete('/ruangan/delete/{id?}', [RuanganController::class, 'destroy'])->name('ruangan.delete');
        Route::get('/kondisi', [KondisiController::class, 'index'])->name('kondisi')->middleware(['menu-permission']);
        Route::get('/kondisi/data-table', [KondisiController::class, 'dataTable'])->name('kondisi.data-table');
        Route::get('/kondisi/show/{id?}', [KondisiController::class, 'show'])->name('kondisi.show');
        Route::post('/kondisi/store', [KondisiController::class, 'store'])->name('kondisi.store');
        Route::put('/kondisi/update/{id?}', [KondisiController::class, 'update'])->name('kondisi.update');
        Route::delete('/kondisi/delete/{id?}', [KondisiController::class, 'destroy'])->name('kondisi.delete');
        Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi')->middleware(['menu-permission']);
        Route::get('/klasifikasi/data-table', [KlasifikasiController::class, 'dataTable'])->name('klasifikasi.data-table');
        Route::get('/klasifikasi/show/{id?}', [KlasifikasiController::class, 'show'])->name('klasifikasi.show');
        Route::post('/klasifikasi/store', [KlasifikasiController::class, 'store'])->name('klasifikasi.store');
        Route::put('/klasifikasi/update/{id?}', [KlasifikasiController::class, 'update'])->name('klasifikasi.update');
        Route::delete('/klasifikasi/delete/{id?}', [KlasifikasiController::class, 'destroy'])->name('klasifikasi.delete');
        Route::get('/jurnal', [JurnalController::class, 'index'])->name('jurnal')->middleware(['menu-permission']);
        Route::get('/jurnal/data-table', [JurnalController::class, 'dataTable'])->name('jurnal.data-table');
        Route::get('/jurnal/show/{id?}', [JurnalController::class, 'show'])->name('jurnal.show');
        Route::post('/jurnal/store', [JurnalController::class, 'store'])->name('jurnal.store');
        Route::put('/jurnal/update/{id?}', [JurnalController::class, 'update'])->name('jurnal.update');
        Route::delete('/jurnal/delete/{id?}', [JurnalController::class, 'destroy'])->name('jurnal.delete');
        Route::get('/jenis-transaksi', [JenisTransaksiController::class, 'index'])->name('jenis-transaksi')->middleware(['menu-permission']);
        Route::get('/jenis-transaksi/data-table', [JenisTransaksiController::class, 'dataTable'])->name('jenis-transaksi.data-table');
        Route::get('/jenis-transaksi/show/{id?}', [JenisTransaksiController::class, 'show'])->name('jenis-transaksi.show');
        Route::post('/jenis-transaksi/store', [JenisTransaksiController::class, 'store'])->name('jenis-transaksi.store');
        Route::put('/jenis-transaksi/update/{id?}', [JenisTransaksiController::class, 'update'])->name('jenis-transaksi.update');
        Route::delete('/jenis-transaksi/delete/{id?}', [JenisTransaksiController::class, 'destroy'])->name('jenis-transaksi.delete');
        Route::get('/kapitalisasi', [KapitalisasiController::class, 'index'])->name('kapitalisasi')->middleware(['menu-permission']);
        Route::get('/kapitalisasi/useable-kobarang', [KapitalisasiController::class, 'useable'])->name('kapitalisasi.useable-kobarang');
        Route::get('/kapitalisasi/data-table', [KapitalisasiController::class, 'dataTable'])->name('kapitalisasi.data-table');
        Route::get('/kapitalisasi/show/{id?}', [KapitalisasiController::class, 'show'])->name('kapitalisasi.show');
        Route::post('/kapitalisasi/store', [KapitalisasiController::class, 'store'])->name('kapitalisasi.store');
        Route::put('/kapitalisasi/update/{id?}', [KapitalisasiController::class, 'update'])->name('kapitalisasi.update');
        Route::delete('/kapitalisasi/delete/{id?}', [KapitalisasiController::class, 'destroy'])->name('kapitalisasi.delete');
        Route::get('/asal-usul', [AsalUsulController::class, 'index'])->name('asal-usul')->middleware(['menu-permission']);
        Route::get('/asal-usul/useable', [AsalUsulController::class, 'useable'])->name('asal-usul.useable');
        Route::get('/asal-usul/data-table', [AsalUsulController::class, 'dataTable'])->name('asal-usul.data-table');
        Route::get('/asal-usul/show/{id?}', [AsalUsulController::class, 'show'])->name('asal-usul.show');
        Route::post('/asal-usul/store', [AsalUsulController::class, 'store'])->name('asal-usul.store');
        Route::put('/asal-usul/update/{id?}', [AsalUsulController::class, 'update'])->name('asal-usul.update');
        Route::delete('/asal-usul/delete/{id?}', [AsalUsulController::class, 'destroy'])->name('asal-usul.delete');
        Route::get('/satuan', [SatuanController::class, 'index'])->name('satuan')->middleware(['menu-permission']);
        Route::post('/satuan/store', [SatuanController::class, 'store'])->name('satuan.store');
        Route::get('/satuan/data-table', [SatuanController::class, 'dataTable'])->name('satuan.data-table');
        Route::get('/satuan/show/{id?}', [SatuanController::class, 'show'])->name('satuan.show');
        Route::put('/satuan/update/{id?}', [SatuanController::class, 'update'])->name('satuan.update');
        Route::delete('/satuan/delete/{id?}', [SatuanController::class, 'destroy'])->name('satuan.delete');
        Route::get('/statustanah', [StatusTanahController::class, 'index'])->name('statustanah')->middleware(['menu-permission']);
        Route::post('/statustanah/store', [StatusTanahController::class, 'store'])->name('statustanah.store');
        Route::get('/statustanah/show/{id?}', [StatusTanahController::class, 'show'])->name('statustanah.show');
        Route::get('/statustanah/data-table', [StatusTanahController::class, 'dataTable'])->name('statustanah.data-table');
        Route::put('/statustanah/update/{id?}', [StatusTanahController::class, 'update'])->name('statustanah.update');
        Route::delete('/statustanah/delete/{id?}', [StatusTanahController::class, 'destroy'])->name('statustanah.delete');
        Route::get('/golonganbarang', [GolonganBarangController::class, 'index'])->name('golonganbarang')->middleware(['menu-permission']);
        Route::get('/golonganbarang/data-table', [GolonganBarangController::class, 'dataTable'])->name('golonganbarang.data-table');
        Route::post('/golonganbarang/store', [GolonganBarangController::class, 'store'])->name('golonganbarang.store');
        Route::get('/golonganbarang/show/{id?}', [GolonganBarangController::class, 'show'])->name('golonganbarang.show');
        Route::put('/golonganbarang/update/{id?}', [GolonganBarangController::class, 'update'])->name('golonganbarang.update');
        Route::delete('/golonganbarang/delete/{id?}', [GolonganBarangController::class, 'destroy'])->name('golonganbarang.delete');
        Route::get('/rehab', [RehabController::class, 'index'])->name('rehab')->middleware(['menu-permission']);
        Route::post('/rehab/store', [RehabController::class, 'store'])->name('rehab.store');
        Route::get('/rehab/list-barang', [RehabController::class, 'listBarang'])->name('rehab.list-barang');
        Route::get('/rehab/data-table', [RehabController::class, 'dataTable'])->name('rehab.data-table');
        Route::get('/rehab/show/{id?}', [RehabController::class, 'show'])->name('rehab.show');
        Route::put('/rehab/update/{id?}', [RehabController::class, 'update'])->name('rehab.update');
        Route::delete('/rehab/delete/{id?}', [RehabController::class, 'destroy'])->name('rehab.delete');
    });
    Route::get('/sp2d', [Sp2dController::class, 'index'])->name('sp2d')->middleware(['menu-permission']);
    Route::get('/sp2d/data-table', [Sp2dController::class, 'dataTable'])->name('sp2d.data-table');
    Route::get('/perolehan-sp2d', [PerolehanSP2DController::class, 'index'])->name('perolehan-sp2d')->middleware(['menu-permission']);
    Route::post('/perolehan-sp2d/store', [PerolehanSP2DController::class, 'store'])->name('perolehan-sp2d.store');
    Route::put('/perolehan-sp2d/update/{ba?}', [PerolehanSP2DController::class, 'update'])->name('perolehan-sp2d.update');
    Route::get('/perolehan-sp2d/all-kegiatan/{idprogram?}', [PerolehanSP2DController::class, 'getKegiatan'])->name('perolehan-sp2d.get-kegiatan');
    Route::get('/perolehan-sp2d/bap/detail/{id?}', [PerolehanSP2DController::class, 'getDetailBap'])->name('perolehan-sp2d.bap.show');
    Route::get('/perolehan-sp2d/all-rekening/{idkegiatan?}', [PerolehanSP2DController::class, 'getRekening'])->name('perolehan-sp2d.get-rekening');
    Route::get('/perolehan-apbd', [PerolehanAPBDController::class, 'index'])->name('perolehan-apbd');
    Route::post('/perolehan-apbd/store', [PerolehanAPBDController::class, 'store'])->name('perolehan-apbd.store');
    Route::put('/perolehan-apbd/update/{ba?}', [PerolehanAPBDController::class, 'update'])->name('perolehan-apbd.update');
    Route::get('/perolehan-apbd/all-kegiatan/{idprogram?}', [PerolehanAPBDController::class, 'getKegiatan'])->name('perolehan-apbd.get-kegiatan');
    Route::get('/perolehan-apbd/bap/detail/{id?}', [PerolehanAPBDController::class, 'getDetailBap'])->name('perolehan-apbd.bap.show');
    Route::get('/perolehan-apbd/all-rekening/{idkegiatan?}/{idprogram?}', [PerolehanAPBDController::class, 'getRekening'])->name('perolehan-apbd.get-rekening');
    Route::get('/perolehan', [PerolehanController::class, 'index'])->name('perolehan')->middleware(['menu-permission']);
    Route::post('/perolehan/store', [PerolehanController::class, 'store'])->name('perolehan.store');
    Route::put('/perolehan/update/{ba?}', [PerolehanController::class, 'update'])->name('perolehan.update');
    Route::get('/perolehan/all-bap', [PerolehanController::class, 'getAllOrganizationBaps'])->name('perolehan.bap');
    Route::get('/perolehan/all-bap', [PerolehanController::class, 'getAllOrganizationApbdBaps'])->name('perolehan.bap.apbd');
    Route::get('/perolehan/bap/check/{ba?}/{column?}', [PerolehanController::class, 'bapCheck'])->name('perolehan.bap.check');
    Route::get('/perolehan/bap/detail/{id?}', [PerolehanController::class, 'getDetailBap'])->name('perolehan.bap.show');
    Route::get('/penyusutan', [PenyusutanController::class, 'index'])->name('penyusutan')->middleware(['menu-permission']);
    Route::get('/penyusutan/data-table', [PenyusutanController::class, 'dataTable'])->name('penyusutan.data-table');
    Route::get('/auth/app/logout', [AuthController::class, 'logout'])->name('logout.application');
    Route::get('/auth/system/logout', [AuthController::class, 'logout_system'])->name('logout.system');
    Route::name('control.')->group(function () {
        Route::get('/control-user', [UserControlController::class, 'index'])->name('user');
        Route::get('/control-user', [UserControlController::class, 'index'])->name('user');
        Route::post('/control-user', [UserControlController::class, 'profileChange'])->name('user');
        Route::post('/control-user/change-password', [UserControlController::class, 'passwordChange'])->name('user.change-password');
        Route::get('/control-user/user-role', [UserControlController::class, 'dataTable'])->name('user-role.data-table');
        Route::get('/control-user/role', [UserControlController::class, 'roleCreate'])->name('role.create');
        Route::post('/control-user/role', [UserControlController::class, 'roleStore'])->name('role.store');
        Route::get('/control-user/role/{id?}', [UserControlController::class, 'roleShow'])->name('role.show');
        Route::put('/control-user/role/{id?}', [UserControlController::class, 'roleUpdate'])->name('role.update');
        Route::delete('/control-user/role/{id?}', [UserControlController::class, 'roleDestroy'])->name('role.delete');
        Route::get('/control-user/create', [UserControlController::class, 'userCreate'])->name('create-user');
        Route::post('/control-user/create', [UserControlController::class, 'userStore'])->name('create-user');
    });
});
Route::middleware(['throttle:application', 'authenticated'])->group(function () {
    Route::post('/set-organisasi', [AuthController::class, 'setOrganisasi'])->name('set-organisasi');
    Route::get('/', [HomeController::class, 'selectApplication'])->name('select-application')->middleware('select-app');
    Route::post('/', [HomeController::class, 'chooseApplication'])->name('choose-application')->middleware('select-app');
    Route::get('/organisasi-child', [MasterController::class, 'masterOrganisasiChild'])->name('master.organisasi-child');
});
Route::middleware(['un_authenticated'])->group(function () {
    // DangerLine
    // Route::get('/import-master', function () {
    //     Excel::import(new MasterImport, public_path('master.xlsx'));
    //     return response()->json(['status' => 'done', 'message' => 'Master imported']);
    // })->name('import-master');
    Route::get('/pulllll', function () {
        $output = shell_exec('cd .. && git pull');

        return response()->json(['status' => 'done', 'message' => $output]);
    })->name('git-pull');
    // end DangerLine
    Route::get('/auth/login', [AuthController::class, 'index'])->name('login');
    Route::post('/auth/login', [AuthController::class, 'login'])->middleware(['throttle:login-process'])->name('login-process');
});

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function masterAsalUsul()
    {
        return response()->json([
            'html_kategori' => dataToOption(DB::table('masterasalusul')->select(DB::raw('distinct(kategori) as name'))->orderBy('kategori')->get()),
            'html_asal_usul' => dataToOption(DB::table('masterasalusul')->select(['kategori as attribute', 'kodeasalusul as id', 'asalusul as name'])->orderByRaw('kategori, asalusul ASC')->get(), true)
        ]);
    }
    public function masterKondisi()
    {
        return response()->json([
            'html_kondisi' => dataToOption(DB::table('masterkondisi')->select(DB::raw('kodekondisi as id, kondisi as name'))->orderBy('kodekondisi')->get()),
        ]);
    }
    public function masterSatuan()
    {
        return response()->json([
            'html_satuan' => dataToOption(DB::table('mastersatuan')->select(DB::raw('kodesatuan as id, satuan as name'))->orderBy('kodesatuan')->get()),
        ]);
    }
    public function masterStatusTanah()
    {
        return response()->json([
            'html_status_tanah' => dataToOption(DB::table('masterstatustanah')->select(DB::raw('kodestatustanah as id, statustanah as name'))->orderBy('kodestatustanah')->get()),
        ]);
    }
    public function masterGolonganBarang()
    {
        return response()->json([
            'html_golongan_barang' => dataToOption(DB::table('mastergolonganbarang')->select(DB::raw('kodegolonganbarang as id, golonganbarang as name'))->orderBy('kodegolonganbarang')->get()),
        ]);
    }
    public function masterWarna()
    {
        return response()->json([
            'html_warna' => dataToOption(DB::table('masterwarna')->select(DB::raw('kodewarna as id, warna as name'))->orderBy('kodewarna')->get()),
        ]);
    }
    public function masterHak()
    {
        return response()->json([
            'html_hak' => dataToOption(DB::table('masterhak')->select(DB::raw('kodehak as id, hak as name'))->orderBy('kodehak')->get()),
        ]);
    }
}

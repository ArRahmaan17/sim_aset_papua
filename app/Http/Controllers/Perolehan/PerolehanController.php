<?php

namespace App\Http\Controllers\Perolehan;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerolehanController extends Controller
{
    public function index()
    {
        $dataMaster = DB::table('masterbarang')->where('kodesubsub', '<>', 0)->get();
        return view('layout.perolehan.index', compact('dataMaster'));
    }
    public function store(Request $request)
    {
        $bap = $request->except('detail', '_token');
        $kibs = $request->only('detail');
        $bap['kodejenistransaksi'] = 101;
        $bap['tanggalbap'] = convertAlphabeticalToNumberDate($request->tanggalbap);
        $bap['kodeurusan'] = $must['kodeurusan'] = 1;
        $bap['kodesuburusan'] = $must['kodesuburusan'] = 0;
        $bap['kodeorganisasi'] = $must['kodeorganisasi'] = 0;
        $bap['kodesuborganisasi'] = $must['kodesuborganisasi'] = 0;
        $bap['kodeunit'] = $must['kodeunit'] = 0;
        $bap['kodesubunit'] = $must['kodesubunit'] = 0;
        $bap['kodesubsubunit'] = $must['kodesubsubunit'] = 0;
        $bap['tahunorganisasi'] = $must['tahunorganisasi'] = 2024;
        $kodebap = DB::table('bap')->insertGetId($bap, 'kodebap');
        foreach ($kibs['detail'] as $index => $kib) {
            $kib = array_merge($kib, $must);
            $kib['nilaibarang'] = convertStringToNumber($kib['nilaibarang']);
            $kib['uraibarang'] = $kib['urai'];
            $kib['tahunperolehan'] = 2024;
            $kib['kodepemilik'] = 34;
            $kib['kodeklasifikasi'] = ($kib['nilaibarang'] >= intval(classificationType($kib)->nilai)) ? 1 : 2;
            $kib['kodeklasifikasi_u'] = ($kib['nilaibarang'] >= intval(classificationType($kib)->nilai)) ? 1 : 2;
            $kib['koderegister'] = getKoderegister($kib);
            $jumlah = $kib['jumlah'];
            unset($kib['select-asal-usul-barang-perolehan-aset'], $kib['jumlah'], $kib['iddetail'], $kib['kodemasterbarang'], $kib['urai']);
            for ($i = 0; $i < (int)$jumlah; $i++) {
                $kodekib = DB::table('kib')->insertGetId($kib, 'kodekib');
                $kib['nilaitransaksi'] = $kib['nilaibarang'];
                $kib['kodekib'] = $kodekib;
                unset($kib['deskripsibarang'], $kib['nilaibarang'], $kib['luas'], $kib['tahunperolehan'], $kib['kodeasalusul'], $kib['qrcode_foto'], $kib['kodepemilik']);
                $kib['kodebap'] = $kodebap;
                $kib['uraiorganisasi'] = 'URUSAN PEMERINTAHAN WAJIB YANG BERKAITAN DENGAN PELAYANAN DASAR';
                $kib['kodejenistransaksi'] = 101;
                $kib['kodejurnal'] = 0;
                $kib['tanggaltransaksi'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                $kib['tanggalpenyusutan'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                DB::table('kibtransaksi')->insert($kib);
            }
        }
        return response()->json(['message' => 'berhasil menambahkan perolehan']);
    }
}

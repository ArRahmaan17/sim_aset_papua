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
        $bap['tanggalkontrak'] = isset($request->tanggalkontrak) ? convertAlphabeticalToNumberDate($request->tanggalkontrak) : null;
        $bap['tanggalbaterima'] = isset($request->tanggalbapterima) ? convertAlphabeticalToNumberDate($request->tanggalbaterima) : null;
        $bap['tanggalkuitansi'] = isset($request->tanggalkuitansi) ? convertAlphabeticalToNumberDate($request->tanggalkuitansi) : null;

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
            $jumlah = $kib['jumlah'];
            for ($i = 0; $i < (int)$jumlah; $i++) {
                $copied = array_merge($kib, $must);
                $copied['nilaibarang'] = convertStringToNumber($kib['nilaibarang']);
                if (isset($kib['tglimb'])) {
                    $copied['tglimb'] = convertAlphabeticalToNumberDate($kib['tglimb']);
                }
                $copied['uraibarang'] = $kib['urai'];
                $copied['tahunperolehan'] = 2024;
                $copied['kodepemilik'] = 34;
                $copied['uraiorganisasi'] = 'URUSAN PEMERINTAHAN WAJIB YANG BERKAITAN DENGAN PELAYANAN DASAR';
                $copied['kodeklasifikasi'] = ($copied['nilaibarang'] >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                $copied['kodeklasifikasi_u'] = ($copied['nilaibarang'] >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                $copied['koderegister'] = getKoderegister($copied);
                unset($copied['select-asal-usul-barang-perolehan-aset'], $copied['jumlah'], $copied['iddetail'], $copied['kodemasterbarang'], $copied['urai']);
                $kodekib = DB::table('kib')->insertGetId($copied, 'kodekib');
                unset(
                    $copied['deskripsibarang'],
                    $copied['nilaibarang'],
                    $copied['luas'],
                    $copied['tahunperolehan'],
                    $copied['kodeasalusul'],
                    $copied['qrcode_foto'],
                    $copied['kodepemilik'],
                    $copied['kodekondisi'],
                    $copied['tahunpembuatan'],
                    $copied['kodegolonganbarang'],
                    $copied['kodewarna'],
                    $copied['bahan'],
                    $copied['nopabrik'],
                    $copied['norangka'],
                    $copied['nomesin'],
                    $copied['nobpkb'],
                    $copied['kodesatuan'],
                    $copied['merktype'],
                    $copied['ukuran'],
                    $copied['alamat'],
                    $copied['noimb'],
                    $copied['tglimb'],
                    $copied['kodestatustanah'],
                    $copied['luaslantai'],
                    $copied['kodehak'],
                    $copied['konstruksi'],
                    $copied['panjang'],
                    $copied['lebar'],
                    $copied['nilaihibahtotal'],
                    $copied['judul'],
                    $copied['pencipta'],
                    $copied['asaldaerah'],
                    $copied['jenis'],
                );
                $copied['nilaitransaksi'] = $kib['nilaibarang'];
                $copied['kodekib'] = $kodekib;
                $copied['kodebap'] = $kodebap;
                $copied['kodejenistransaksi'] = 101;
                $copied['kodejurnal'] = 0;
                $copied['tanggaltransaksi'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                $copied['tanggalpenyusutan'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                DB::table('kibtransaksi')->insert($copied);
            }
        }
        return response()->json(['message' => 'berhasil menambahkan perolehan']);
    }
}

<?php

namespace App\Http\Controllers\Perolehan;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerolehanController extends Controller
{
    public function index()
    {
        $dataMaster = DB::table('masterbarang')->where('kodesubsub', '<>', 0)->get();
        $dataBap = Bap::getAllOrganizationBaps();
        return view('layout.perolehan.index', compact('dataMaster', 'dataBap'));
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
        $copied = clone (session('organisasi'));
        $bap['kodeurusan'] = $must['kodeurusan'] = $copied->kodeurusan;
        $bap['kodesuburusan'] = $must['kodesuburusan'] = $copied->kodesuburusan;
        $bap['kodesubsuburusan'] = $must['kodesubsuburusan'] = $copied->kodesubsuburusan;
        $bap['kodeorganisasi'] = $must['kodeorganisasi'] = $copied->kodeorganisasi;
        $bap['kodesuborganisasi'] = $must['kodesuborganisasi'] = $copied->kodesuborganisasi;
        $bap['kodeunit'] = $must['kodeunit'] = $copied->kodeunit;
        $bap['kodesubunit'] = $must['kodesubunit'] = $copied->kodesubunit;
        $bap['kodesubsubunit'] = $must['kodesubsubunit'] = $copied->kodesubsubunit;
        $bap['tahunorganisasi'] = $must['tahunorganisasi'] = $copied->tahunorganisasi;
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
                $copied['tanggalperolehan'] = now('Asia/Jakarta');
                $copied['kodepemilik'] = 34;
                $copied['uraiorganisasi'] = getOrganisasi();
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
                    $copied['tanggalperolehan'],
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

    public function update(Request $request, $ba)
    {
        $kibs = $request->only('detail');
        DB::beginTransaction();
        try {
            $bap = DB::table('bap')->where('kodebap', $ba)->first();
            $copied = clone (session('organisasi'));
            $must['kodeurusan'] = $copied->kodeurusan;
            $must['kodesuburusan'] = $copied->kodesuburusan;
            $must['kodesubsuburusan'] = $copied->kodesubsuburusan;
            $must['kodeorganisasi'] = $copied->kodeorganisasi;
            $must['kodesuborganisasi'] = $copied->kodesuborganisasi;
            $must['kodeunit'] = $copied->kodeunit;
            $must['kodesubunit'] = $copied->kodesubunit;
            $must['kodesubsubunit'] = $copied->kodesubsubunit;
            $must['tahunorganisasi'] = $copied->tahunorganisasi;
            foreach ($kibs['detail'] as $index => $kib) {
                $data = DB::table('kibtransaksi as kt')
                    ->join('kib as k', 'kt.kodekib', '=', 'k.kodekib')
                    ->where([
                        'kt.kodebap' => $bap->idbap,
                        'k.uraiorganisasi' => $kib['uraiorganisasi'] ?? getOrganisasi(),
                        'k.uraibarang' => $kib['uraibarang'] ?? '',
                        'k.tahunperolehan' => $kib['tahunperolehan'] ?? 0,
                        'k.tanggalperolehan' => $kib['tanggalperolehan'] ?? now('Asia/Jakarta'),
                    ])
                    ->get()
                    ->toArray();
                if (count($data) > 0) {
                    $copied = (array)(clone (object)$kib);
                    unset($copied['kodekib'], $copied['select-asal-usul-barang-perolehan-aset'], $copied['jumlah'], $copied['iddetail'], $copied['kodemasterbarang'], $copied['urai'], $copied['kodekib']);
                    $kodekib = array_map(function ($obj) {
                        return $obj->kodekib;
                    }, $data);
                    $kodekibtransaksi = array_map(function ($obj) {
                        return $obj->kodekibtransaksi;
                    }, $data);
                    $updatekib = DB::table('kib')
                        ->whereIn('kodekib', $kodekib)
                        ->update($copied);
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
                        $copied['nopolisi'],
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
                        $copied['nosensus'],
                        $copied['nolokasi'],
                        $copied['nodokumen'],
                        $copied['kodekibtanah'],
                        $copied['tgldok'],
                        $copied['tglmulai'],
                        $copied['nosertifikat'],
                        $copied['tglsertifikat'],
                        $copied['penggunaan'],
                        $copied['bertingkat'],
                        $copied['beton'],
                        $copied['penerbit'],
                        $copied['spesifikasi'],
                        $copied['statusdata'],
                        $copied['koderuang'],
                        $copied['asalusul_u'],
                        $copied['saldoawal'],
                        $copied['kodejenisbangunan'],
                        $copied['kodekibtanah_u'],
                        $copied['nilaiakumulasibarang'],
                        $copied['lokasi'],
                        $copied['qrcode'],
                        $copied['kodedigunakan'],
                        $copied['kodeeksis'],
                        $copied['kodejelaseksis'],
                        $copied['jelaseksis'],
                        $copied['kode17'],
                        $copied['isperolehanatribusi'],
                        $copied['mutasi_apbd'],
                        $copied['penyedia_atb'],
                        $copied['spesifikasi_atb'],
                        $copied['alamat_penyedia_atb'],
                        $copied['dokumen_pendukung_lainnya'],
                        $copied['bentuk_fisik'],
                        $copied['sumber_bast'],
                        $copied['pengguna_atb'],
                        $copied['bidang_penanggungjawab_atb'],
                        $copied['tahunpenilaian'],
                        $copied['koderegister_sipkd'],
                        $copied['tahun_sipkd'],
                        $copied['bermasalah'],
                        $copied['keterangan_lokasi'],
                        $copied['detail_lokasi'],
                        $copied['jumlahlantai'],
                        $copied['tanggalperolehan'],
                    );
                    DB::table('kibtransaksi')
                        ->whereIn('kodekibtransaksi', $kodekibtransaksi)
                        ->update($copied);
                } else {
                    $jumlah = $kib['jumlah'];
                    for ($i = 0; $i < (int)$jumlah; $i++) {
                        $copied = array_merge($kib, $must);
                        $copied['nilaibarang'] = convertStringToNumber($kib['nilaibarang']);
                        if (isset($kib['tglimb'])) {
                            $copied['tglimb'] = convertAlphabeticalToNumberDate($kib['tglimb']);
                        }
                        $copied['uraibarang'] = $kib['urai'];
                        $copied['tahunperolehan'] = env('TAHUN_APLIKASI');
                        $copied['tanggalperolehan'] = now('Asia/Jakarta');
                        $copied['kodepemilik'] = 34;
                        $copied['uraiorganisasi'] = getOrganisasi();
                        $copied['kodeklasifikasi'] = ($copied['nilaibarang'] >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                        $copied['kodeklasifikasi_u'] = ($copied['nilaibarang'] >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                        $copied['koderegister'] = getKoderegister($copied);
                        unset($copied['kodekib'], $copied['select-asal-usul-barang-perolehan-aset'], $copied['jumlah'], $copied['iddetail'], $copied['kodemasterbarang'], $copied['urai']);
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
                            $copied['tanggalperolehan'],
                        );
                        $copied['nilaitransaksi'] = $kib['nilaibarang'];
                        $copied['kodekib'] = $kodekib;
                        $copied['kodebap'] = $bap->idbap;
                        $copied['kodejenistransaksi'] = 101;
                        $copied['kodejurnal'] = 0;
                        $copied['tanggaltransaksi'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                        $copied['tanggalpenyusutan'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                        DB::table('kibtransaksi')->insert($copied);
                    }
                }
            }
            DB::commit();
            $status = 200;
            $message = ['message' => 'Berhasil melakukan perubahan'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 422;
            $message = ['message' => 'Gagal melakukan perubahan'];
        }
        return response()->json($message, $status);
    }

    public function getDetailBap($kodebap)
    {
        $data = Bap::getDetailBap($kodebap);
        $data['dataKib'] = collect(array_values($data['dataKib']))->flatten()->all();
        if (count($data['dataKibTransaksi']) > 0 || count($data['dataKib']) > 0) {
            $response = ['message' => 'Detail Bap berhasil ditemukan', 'data' => $data];
            $status = 200;
        } else {
            $response = ['message' => 'Detail Bap gagal ditemukan', 'data' => $data];
            $status = 404;
        }
        return response()->json($response, $status);
    }

    public function getAllOrganizationBaps(Request $request)
    {
        $data = Bap::getAllOrganizationBaps();
        if (count($data) == 0) {
            $response = ['message' => 'Data Bap tidak di temukan', 'data' => $data];
            $status = 404;
        } else {
            $response = ['message' => 'Data Bap Di temukan', 'data' => $data];
            $status = 200;
        }
        return response()->json($response, $status);
    }
}

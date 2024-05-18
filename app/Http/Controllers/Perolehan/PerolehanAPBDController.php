<?php

namespace App\Http\Controllers\Perolehan;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerolehanAPBDController extends Controller
{
    public function index()
    {
        $dataMaster = DB::table('masterbarang')->where('kodesubsub', '<>', 0)->get();
        $dataPerogramAPBD = DB::table('anggaran.sp2d')
            ->selectRaw('nuprgrm as id, nmprgrm as name')
            ->where('nuprgrm', '<>', null)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nuprgrm',
                'nmprgrm'
            )
            ->get();
        $dataBap = Bap::getAllOrganizationBapsApbd();

        return view('layout.perolehanapbd.index', compact('dataMaster', 'dataBap', 'dataPerogramAPBD'));
    }

    public function getKegiatan($idProgram)
    {
        $dataPerogramAPBD = DB::table('anggaran.sp2d')->selectRaw("nukegunit as id, concat(nukegunit,' - ',nmkegunit) as name")
            ->where('nuprgrm', $idProgram)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nukegunit',
                'nmkegunit'
            )
            ->get();
        $dataPerogramAPBD = dataToOption($dataPerogramAPBD);

        return response()->json(['message' => 'Semua Data Kegiatan', 'data' => $dataPerogramAPBD]);
    }

    public function getRekening($idProgram)
    {
        $dataRekeningAPBD = DB::table('anggaran.sp2d')->selectRaw(
            "nosp2d, tglsp2d, kdper, nmper, sp2d.nilai as nilai, (sp2d.nilai - (case when (select count(0) from kib as k join kibsp2d as ks on k.kodekib = ks.kodekib where ks.nosp2d = sp2d.nosp2d and ks.tglsp2d = sp2d.tglsp2d and ks.kdper = sp2d.kdper) > 0 then (select sum(ks.nilai) from kib as k join kibsp2d as ks on k.kodekib = ks.kodekib where ks.nosp2d = sp2d.nosp2d and ks.tglsp2d = sp2d.tglsp2d and ks.kdper = sp2d.kdper) else 0 end)) as sisa_nilai,keperluan"
        )
            ->where('nukegunit', $idProgram)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nosp2d',
                'tglsp2d',
                'kdper',
                'nmper',
                'nilai',
                'keperluan'
            )
            ->get();

        return response()->json(['message' => 'Semua Data Rekening', 'data' => $dataRekeningAPBD]);
    }

    public function getDetailBap($idbap)
    {
        $bap = Bap::where('idbap', $idbap)->first();
        $data = Bap::getDetailBapApbd($bap->kodebap);
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

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $bap = $request->except('detail', '_token', 'atribusi');
            $kibs = $request->only('detail');
            $atribusi = $request->only('atribusi');
            $bap['kodejenistransaksi'] = 101;
            $bap['tanggalbap'] = convertAlphabeticalToNumberDate($request->tanggalbap);
            $bap['tanggalkontrak'] = isset($request->tanggalkontrak) ? convertAlphabeticalToNumberDate($request->tanggalkontrak) : null;
            $bap['tanggalbaterima'] = isset($request->tanggalbapterima) ? convertAlphabeticalToNumberDate($request->tanggalbaterima) : null;
            $bap['tanggalkuitansi'] = isset($request->tanggalkuitansi) ? convertAlphabeticalToNumberDate($request->tanggalkuitansi) : null;
            $copied = clone session('organisasi');
            $bap['kodeurusan'] = $must['kodeurusan'] = $copied->kodeurusan;
            $bap['kodesuburusan'] = $must['kodesuburusan'] = $copied->kodesuburusan;
            $bap['kodesubsuburusan'] = $must['kodesubsuburusan'] = $copied->kodesubsuburusan;
            $bap['kodeorganisasi'] = $must['kodeorganisasi'] = $copied->kodeorganisasi;
            $bap['kodesuborganisasi'] = $must['kodesuborganisasi'] = $copied->kodesuborganisasi;
            $bap['kodeunit'] = $must['kodeunit'] = $copied->kodeunit;
            $bap['kodesubunit'] = $must['kodesubunit'] = $copied->kodesubunit;
            $bap['kodesubsubunit'] = $must['kodesubsubunit'] = $copied->kodesubsubunit;
            $bap['tahunorganisasi'] = $must['tahunorganisasi'] = $copied->tahunorganisasi;
            $sp2d = clone (object) ($bap);
            unset($bap['program'], $bap['kegiatan']);
            $kodebap = DB::table('bap')->insertGetId($bap, 'kodebap');
            if (count($atribusi) > 0) {
                foreach ($atribusi['atribusi'] as $index => $att) {
                    $nilai_total_attribusi = convertStringToNumber($att['nilaibarang']);
                    $data_attribusi = [
                        'kodegolongan' => 153,
                        'kodebidang' => 1,
                        'kodekelompok' => 1,
                        'kodesub' => 9,
                        'kodesubsub' => 1,
                        'uraibarang' => 'Aset Tidak Berwujud Lainya...',
                        'deskripsibarang' => $att['deskripsibarang'],
                        'nilaibarang' => $nilai_total_attribusi,
                        'tahunperolehan' => env('APP_YEAR'),
                        'uraiorganisasi' => getOrganisasi(),
                        'kodeasalusul' => 1,
                        'kodeklasifikasi' => (intval($nilai_total_attribusi) >= intval(classificationType([
                            'kodegolongan' => 153,
                            'kodebidang' => 1,
                            'kodekelompok' => 1,
                            'kodesub' => 9,
                            'kodesubsub' => 1,
                        ])->nilai ?? (-1))) ? 1 : 2,
                        'kodeklasifikasi_u' => (intval($nilai_total_attribusi) >= intval(classificationType([
                            'kodegolongan' => 153,
                            'kodebidang' => 1,
                            'kodekelompok' => 1,
                            'kodesub' => 9,
                            'kodesubsub' => 1,
                        ])->nilai ?? (-1))) ? 1 : 2,
                        'koderegister' => getKoderegister(array_merge(
                            $must,
                            [
                                'tahunperolehan' => env('APP_YEAR'),
                                'kodegolongan' => 153,
                                'kodebidang' => 1,
                                'kodekelompok' => 1,
                                'kodesub' => 9,
                                'kodesubsub' => 1,
                            ]
                        )),
                        'kodepemilik' => 12
                    ];
                    $kodekibAttribusi =  DB::table('kib')->insertGetId(array_merge($data_attribusi, $must), 'kodekib');
                    $data_attribusi['kodekib'] = $kodekibAttribusi;
                    $data_attribusi['kodebap'] = $kodebap;
                    $data_attribusi['nilaitransaksi'] = $data_attribusi['nilaibarang'];
                    $data_attribusi['kodejenistransaksi'] = 101;
                    $data_attribusi['kodejurnal'] = 0;
                    $data_attribusi['tanggaltransaksi'] = now('Asia/Jakarta');
                    $data_attribusi['tanggalpenyusutan'] = Carbon::createFromFormat('Y-m-d', convertAlphabeticalToNumberDate($request->tanggalbap))->addYear();
                    unset($data_attribusi['deskripsibarang'], $data_attribusi['nilaibarang'], $data_attribusi['tahunperolehan'], $data_attribusi['kodeasalusul'], $data_attribusi['kodepemilik']);
                    DB::table('kibtransaksi')->insert(array_merge($data_attribusi, $must));
                    $data_sp2d_attribusi = [];
                    foreach ($att['rekening'] as $index => $rekening) {
                        [$data_sp2d_attribusi[$index]['nosp2d'], $data_sp2d_attribusi[$index]['tglsp2d']] = explode('_', $rekening['id']);
                        $data_sp2d_attribusi[$index]['kdper'] = $rekening['kdper'];
                        $data_sp2d_attribusi[$index]['kodekib'] = $kodekibAttribusi;
                        $data_sp2d_attribusi[$index]['tahun'] = env('TAHUN_APLIKASI');
                        $data_sp2d_attribusi[$index]['nilai'] = intval(convertStringToNumber($rekening['nilai'])) / 100;
                        $data_sp2d_attribusi[$index]['nuprgrm'] = $sp2d->program;
                        $data_sp2d_attribusi[$index]['kdkegunit'] = $sp2d->kegiatan;
                        $data_sp2d_attribusi[$index]['persentase'] = $rekening['persentase'];
                        $data_sp2d_attribusi[$index]['kdunit'] = getkdunit($data_sp2d_attribusi[$index]);
                    }
                    DB::table('kibsp2d')->insert($data_sp2d_attribusi);
                }
            }
            foreach ($kibs['detail'] as $index => $kib) {
                $jumlah = $kib['jumlah'];
                for ($i = 0; $i < (int) $jumlah; $i++) {
                    $copied = array_merge($kib, $must);
                    $copied['nilaibarang'] = convertStringToNumber($kib['nilaibarang']);
                    if (isset($kib['tglimb'])) {
                        $copied['tglimb'] = convertAlphabeticalToNumberDate($kib['tglimb']);
                    }
                    $copied['uraibarang'] = $kib['urai'];
                    $copied['tahunperolehan'] = 2024;
                    $copied['tanggalperolehan'] = now('Asia/Jakarta');
                    $copied['kodepemilik'] = 12;
                    $copied['uraiorganisasi'] = getOrganisasi();
                    $copied['kodeklasifikasi'] = (intval($copied['nilaibarang']) >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                    $copied['kodeklasifikasi_u'] = (intval($copied['nilaibarang']) >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                    $copied['koderegister'] = getKoderegister($copied);
                    $kib_sp2d = clone (object) $kib['sp2d'];
                    unset($copied['sp2d'], $copied['select-asal-usul-barang-perolehan-aset'], $copied['jumlah'], $copied['iddetail'], $copied['kodemasterbarang'], $copied['urai']);
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
                    $copied['nilaitransaksi'] = convertStringToNumber($kib['nilaibarang']);
                    $copied['kodekib'] = $kodekib;
                    $copied['kodebap'] = $kodebap;
                    $copied['kodejenistransaksi'] = 101;
                    $copied['kodejurnal'] = 0;
                    $copied['tanggaltransaksi'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                    $copied['tanggalpenyusutan'] = Carbon::createFromFormat('Y-m-d', convertAlphabeticalToNumberDate($request->tanggalbap))->addYear();
                    DB::table('kibtransaksi')->insert($copied);
                    $data_sp2d = [];
                    foreach ($kib_sp2d as $index => $datasp2d) {
                        [$data_sp2d[$index]['nosp2d'], $data_sp2d[$index]['tglsp2d']] = explode('_', $datasp2d['id']);
                        $data_sp2d[$index]['kdper'] = $datasp2d['kdper'];
                        $data_sp2d[$index]['kodekib'] = $kodekib;
                        $data_sp2d[$index]['tahun'] = env('TAHUN_APLIKASI');
                        $data_sp2d[$index]['nilai'] = (intval(convertStringToNumber($datasp2d['nilai'])) / $jumlah) / 100;
                        $data_sp2d[$index]['nuprgrm'] = $sp2d->program;
                        $data_sp2d[$index]['kdkegunit'] = $sp2d->kegiatan;
                        $data_sp2d[$index]['persentase'] = $datasp2d['persentase'];
                        $data_sp2d[$index]['kdunit'] = getkdunit($data_sp2d[$index]);
                    }
                    DB::table('kibsp2d')->insert($data_sp2d);
                }
            }
            DB::commit();
            $response = ['message' => 'berhasil menyimpan perolehan sp2d'];
            $status = 200;
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = ['message' => 'gagal menyimpan perolehan sp2d'];
            $status = 422;
        }

        return response()->json($response, $status);
    }

    public function update(Request $request, $ba)
    {
        $kibs = $request->only('detail');
        DB::beginTransaction();
        try {
            $bap = DB::table('bap')->where('kodebap', $ba)->first();
            $copied = clone session('organisasi');
            $must['kodeurusan'] = $copied->kodeurusan;
            $must['kodesuburusan'] = $copied->kodesuburusan;
            $must['kodesubsuburusan'] = $copied->kodesubsuburusan;
            $must['kodeorganisasi'] = $copied->kodeorganisasi;
            $must['kodesuborganisasi'] = $copied->kodesuborganisasi;
            $must['kodeunit'] = $copied->kodeunit;
            $must['kodesubunit'] = $copied->kodesubunit;
            $must['kodesubsubunit'] = $copied->kodesubsubunit;
            $must['tahunorganisasi'] = $copied->tahunorganisasi;
            $sp2d = clone (object) ($request->only('program', 'kegiatan'));
            $datakib = DB::table('bap as b')->select('kt.kodekib')
                ->join('kibtransaksi as kt', 'kt.kodebap', '=', 'b.idbap')
                ->leftJoin('penyusutan as p', 'p.kodekib', '=', 'kt.kodekib')
                ->where('b.kodebap', $bap->kodebap)->get()->map(function ($kodekib) {
                    return $kodekib->kodekib;
                })->toArray();
            $requestdatakib = array_map(function ($requestkib) {
                return intval($requestkib['kodekib']);
            }, $kibs['detail']);
            $removerequest = array_merge(array_diff($datakib, $requestdatakib), array_diff($requestdatakib, $datakib));
            foreach ($kibs['detail'] as $index => $kib) {
                $kib_sp2d = clone (object) ($kib['sp2d']);
                if (gettype($kib_sp2d) == 'object' && isset($kib_sp2d->scalar)) {
                    $kib_sp2d = json_decode($kib_sp2d->scalar);
                }
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
                    $copied = (array) (clone (object) $kib);
                    unset($copied['kodekib'], $copied['select-asal-usul-barang-perolehan-aset'], $copied['jumlah'], $copied['iddetail'], $copied['kodemasterbarang'], $copied['urai'], $copied['kodekib']);
                    $kodekib = array_map(function ($obj) {
                        return $obj->kodekib;
                    }, $data);
                    $kodekibtransaksi = array_map(function ($obj) {
                        return $obj->kodekibtransaksi;
                    }, $data);
                    unset($copied['sp2d']);
                    $copied['nilaibarang'] = intval(convertStringToNumber($copied['nilaibarang'])) / 100;
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
                        $copied['sp2d'],
                    );
                    DB::table('kibtransaksi')
                        ->whereIn('kodekibtransaksi', $kodekibtransaksi)
                        ->update($copied);
                    $data_sp2d = [];
                    DB::table('kibsp2d')->whereIn('kodekib', $kodekib)->delete();
                    foreach ($kib_sp2d as $index => $datasp2d) {
                        $datasp2d = (array) $datasp2d;
                        [$data_sp2d[$index]['nosp2d'], $data_sp2d[$index]['tglsp2d']] = explode('_', $datasp2d['id']);
                        $data_sp2d[$index]['kdper'] = $datasp2d['kdper'];
                        $data_sp2d[$index]['kodekib'] = $kodekib[0];
                        $data_sp2d[$index]['tahun'] = env('TAHUN_APLIKASI');
                        $data_sp2d[$index]['nilai'] = intval(convertStringToNumber($datasp2d['nilai']));
                        $data_sp2d[$index]['nuprgrm'] = $sp2d->program;
                        $data_sp2d[$index]['kdkegunit'] = $sp2d->kegiatan;
                        $data_sp2d[$index]['persentase'] = $datasp2d['persentase'];
                        $data_sp2d[$index]['kdunit'] = getkdunit($data_sp2d[$index]);
                    }
                    DB::table('kibsp2d')->insert($data_sp2d);
                } else {
                    $jumlah = $kib['jumlah'];
                    for ($i = 0; $i < (int) $jumlah; $i++) {
                        $copied = array_merge($kib, $must);
                        $copied['nilaibarang'] = convertStringToNumber($kib['nilaibarang']);

                        if (isset($kib['tglimb'])) {
                            $copied['tglimb'] = convertAlphabeticalToNumberDate($kib['tglimb']);
                        }
                        $copied['uraibarang'] = $kib['urai'];
                        $copied['tahunperolehan'] = env('TAHUN_APLIKASI');
                        $copied['tanggalperolehan'] = now('Asia/Jakarta');
                        $copied['kodepemilik'] = 12;
                        $copied['uraiorganisasi'] = getOrganisasi();
                        $copied['kodeklasifikasi'] = ($copied['nilaibarang'] >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                        $copied['kodeklasifikasi_u'] = ($copied['nilaibarang'] >= intval(classificationType($copied)->nilai)) ? 1 : 2;
                        $copied['koderegister'] = getKoderegister($copied);
                        $kib_sp2d = clone (object) $kib['sp2d'];
                        unset($copied['sp2d'], $copied['kodekib'], $copied['select-asal-usul-barang-perolehan-aset'], $copied['jumlah'], $copied['iddetail'], $copied['kodemasterbarang'], $copied['urai']);
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
                        $copied['nilaitransaksi'] = convertStringToNumber($kib['nilaibarang']);
                        $copied['kodekib'] = $kodekib;
                        $copied['kodebap'] = $bap->idbap;
                        $copied['kodejenistransaksi'] = 101;
                        $copied['kodejurnal'] = 0;
                        $copied['tanggaltransaksi'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                        $copied['tanggalpenyusutan'] = convertAlphabeticalToNumberDate($request->tanggalbap);
                        DB::table('kibtransaksi')->insert($copied);
                    }
                    $data_sp2d = [];
                    DB::table('kibsp2d')->where('kodekib', $kodekib)->delete();
                    foreach ($kib_sp2d as $index => $datasp2d) {
                        [$data_sp2d[$index]['nosp2d'], $data_sp2d[$index]['tglsp2d']] = explode('_', $datasp2d['id']);
                        $data_sp2d[$index]['kdper'] = $datasp2d['kdper'];
                        $data_sp2d[$index]['kodekib'] = $kodekib;
                        $data_sp2d[$index]['tahun'] = env('TAHUN_APLIKASI');
                        $data_sp2d[$index]['nilai'] = intval(convertStringToNumber($datasp2d['nilai'])) / 100;
                        $data_sp2d[$index]['nuprgrm'] = $sp2d->program;
                        $data_sp2d[$index]['kdkegunit'] = $sp2d->kegiatan;
                        $data_sp2d[$index]['persentase'] = $datasp2d['persentase'];
                        $data_sp2d[$index]['kdunit'] = getkdunit($data_sp2d[$index]);
                    }
                    DB::table('kibsp2d')->insert($data_sp2d);
                }
            }
            if (DB::table('penyusutan')->whereIn('kodekib', $removerequest)->count() > 1) {
                throw new Exception('detail aset yang telah di susut tidak dapat di hapus', 422);
            } else {
                DB::table('kibtransaksi')->whereIn('kodekib', $removerequest)->delete();
                DB::table('kibsp2d')->whereIn('kodekib', $removerequest)->delete();
                DB::table('kib')->whereIn('kodekib', $removerequest)->delete();
            }
            DB::commit();
            $status = 200;
            $message = ['message' => 'Berhasil melakukan perubahan perolehan sp2d'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 422;
            $message = ['message' => 'Gagal melakukan perubahan perolehan sp2d'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
        }

        return response()->json($message, $status);
    }
}

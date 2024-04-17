<?php

namespace App\Http\Controllers\Perolehan;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerolehanSP2DController extends Controller
{
    public function index()
    {
        $dataMaster = DB::table('masterbarang')->where('kodesubsub', '<>', 0)->get();
        $dataPerogramSP2D = DB::table('sp2d')->selectRaw('nuprgrm as id, nmprgrm as name')
            ->where('nuprgrm', '<>', null)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nuprgrm',
                'nmprgrm'
            )
            ->get();
        $dataBap = Bap::getAllOrganizationBapsSp2d();
        return view('layout.perolehansp2d.index', compact('dataMaster', 'dataBap', 'dataPerogramSP2D'));
    }

    public function getKegiatan($idProgram)
    {
        $dataPerogramSP2D = DB::table('sp2d')->selectRaw('nukegunit as id, concat(nukegunit," - ",nmkegunit) as name')
            ->where('nuprgrm', $idProgram)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nukegunit',
                'nmkegunit'
            )
            ->get();
        $dataPerogramSP2D = dataToOption($dataPerogramSP2D);
        return response()->json(['message' => 'Semua Data Kegiatan', 'data' => $dataPerogramSP2D]);
    }

    public function getRekening($idProgram)
    {
        $dataRekeningSP2D = DB::table('sp2d')->selectRaw(
            'nosp2d, tglsp2d, kdper, nmper, sp2d.nilai as nilai, (sp2d.nilai - (case when (select count(0) from kib as k join kibsp2d as ks on k.kodekib = ks.kodekib where ks.nosp2d = sp2d.nosp2d and ks.tglsp2d = sp2d.tglsp2d and ks.kdper = sp2d.kdper) > 0 then (select sum(ks.nilai) from kib as k join kibsp2d as ks on k.kodekib = ks.kodekib where ks.nosp2d = sp2d.nosp2d and ks.tglsp2d = sp2d.tglsp2d and ks.kdper = sp2d.kdper) else 0 end)) as sisa_nilai,keperluan'
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
        return response()->json(['message' => 'Semua Data Rekening', 'data' => $dataRekeningSP2D]);
    }
    public function getDetailBap($kodebap)
    {
        $data = Bap::getDetailBapSp2d($kodebap);
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
            $sp2d = clone (object) ($bap);
            unset($bap['program'], $bap['kegiatan']);
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
                        list($data_sp2d[$index]['nosp2d'], $data_sp2d[$index]['tglsp2d']) = explode('_', $datasp2d['id']);
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
            DB::commit();
            $response = ['message' => 'berhasil menyimpan perolehan sp2d'];
            $status = 200;
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            $response = ['message' => 'gagal menyimpan perolehan sp2d'];
            $status = 422;
        }
        return response()->json($response, $status);
    }
}

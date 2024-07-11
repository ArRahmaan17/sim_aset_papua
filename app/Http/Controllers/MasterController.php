<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function masterOrganisasi(Request $request)
    {
        $array = [
            'kodeurusan',
            'kodesuburusan',
            'kodesubsuburusan',
            'kodeorganisasi',
            'kodesuborganisasi',
            'kodeunit',
            'kodesubunit',
            'kodesubsubunit',
        ];
        $where = [];
        foreach (explode('.', $request->organisasi) as $index => $kode) {
            $where[] = [''.$array[$index], $kode];
        }
        $organisasi = DB::table('masterorganisasi')
            ->where($where)
            ->orderBy('kodeurusan')->first();

        return $organisasi;
    }

    public function masterOrganisasiChild(Request $request)
    {
        $array = [
            'kodeurusan',
            'kodesuburusan',
            'kodesubsuburusan',
            'kodeorganisasi',
            'kodesuborganisasi',
            'kodeunit',
            'kodesubunit',
            'kodesubsubunit',
        ];
        $counter = 0;
        $where = [];
        foreach (explode('.', $request->value) as $index => $kode) {
            if ($kode != 0) {
                $where[] = [''.$array[$index], $kode];
            } else {
                if ($index != 2) {
                    if ($counter == 0) {
                        $where[] = [''.$array[$index], '<>', $kode];
                        $counter++;
                    }
                } else {
                    if ($counter == 0) {
                        $where[] = [''.$array[$index], '<>', $kode];
                        $counter++;
                    } elseif ($counter == 1) {
                        $where[] = [''.$array[$index],  $kode];
                        $counter++;
                    }
                }
            }
        }

        return response()->json([
            'html_organisasi_child' => dataToOption(DB::table('masterorganisasi')->select(DB::raw("CONCAT(kodeurusan, '.', LPAD(kodesuburusan::text, 2, '0'), '.', kodesubsuburusan, '.', LPAD(kodeorganisasi::text, 2, '0'), '.', kodesuborganisasi, '.', LPAD(kodeunit::text, 2, '0'), '.', LPAD(kodesubunit::text, 2, '0'),'.', LPAD(kodesubsubunit::text,2, '0')) as id, concat(CONCAT(kodeurusan, '.', LPAD(kodesuburusan::text, 2, '0'), '.', kodesubsuburusan, '.', LPAD(kodeorganisasi::text, 2, '0'), '.', kodesuborganisasi, '.', LPAD(kodeunit::text, 2, '0'), '.', LPAD(kodesubunit::text, 2, '0'),'.', LPAD(kodesubsubunit::text,2, '0')),'|',organisasi) as name"))->where($where)->orderBy('kodeurusan')->get()),
        ]);
    }

    public function masterAsalUsul()
    {
        return response()->json([
            'html_kategori' => dataToOption(DB::table('masterasalusul')->select(DB::raw('distinct(kategori) as name'))->orderBy('kategori')->get()),
            'html_asal_usul' => dataToOption(DB::table('masterasalusul')->select(['kategori as attribute', 'kodeasalusul as id', 'asalusul as name'])->orderByRaw('kategori, asalusul ASC')->get(), true),
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

    public function masterKib()
    {
        return response()->json([
            'html_kib_master' => dataToOption(DB::table('kib_master')->select(DB::raw("id as id, concat(type, ' - ', kib) as name"))->orderBy('id')->get()),
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

    public function masterBarang()
    {
        return response()->json([
            'html_barang' => dataToOption(DB::table('masterbarang')
                ->select(DB::raw("concat(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id, concat(explode(kodegolongan::text, '', 1), '.', explode(kodegolongan::text, '', 2), '.', explode(kodegolongan::text, '', 3) , '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' - ', urai) as name"))
                ->where('kodesubsub', '<>', 0)
                ->orderBy('kodemasterbarang')->get()),
        ]);
    }

    public function masterBarangShow($id)
    {
        [$kodegolongan, $kodebidang, $kodekelompok, $kodesub, $kodesubsub] = explode('.', $id);

        return response()->json([
            'data' => DB::table('masterbarang')
                ->select('urai')
                ->where([
                    'kodegolongan' => $kodegolongan,
                    'kodebidang' => $kodebidang,
                    'kodekelompok' => $kodekelompok,
                    'kodesub' => $kodesub,
                    'kodesubsub' => $kodesubsub,
                ])
                ->orderBy('kodemasterbarang')->first(),
        ]);
    }

    public function masterRekening(Request $request)
    {
        $assets = DB::table('anggaran.sp2d as p')
            ->selectRaw("p.kdper as id, concat(p.kdper, '-', p.nmper) as name");
        if ($request->has('rekening')) {
            if (is_string($request->rekening)) {
                $assets = $assets->where('kdper', '<>', $request['rekening']);
            } else {
                $assets = $assets->whereNotIn('kdper', $request['rekening']);
            }
        }
        $assets = $assets->groupByRaw('p.kdper, p.nmper')->get();

        return response()->json([
            'html_rekening' => dataToOption($assets),
        ]);
    }
}

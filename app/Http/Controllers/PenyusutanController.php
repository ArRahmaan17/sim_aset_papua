<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyusutanController extends Controller
{
    public function index()
    {
        return view('layout.penyusutan.index');
    }
    public function dataTable(Request $request)
    {
        $totalData = DB::table('penyusutan as p')
            ->select('b.kodebap', 'k.kodekib', 'k.alamat', 'k.keterangan', 'p.nilai', 'p.tahun', 'p.tgl_penyusutan', 'b.tahunorganisasi')
            ->join('kibtransaksi as kt', 'p.kodekib', '=', 'kt.kodekib')
            ->join('kib as k', 'kt.kodekib', '=', 'k.kodekib')
            ->join('bap as b', 'kt.kodebap', '=', 'b.idbap');
        if (intval(session('user')->idrole) > 3) {
            $totalData->where([
                'p.kodeurusan' => session('organisais')->kodeurusan,
                'p.kodesuburusan' => session('organisais')->kodesuburusan,
                'p.kodesubsuburusan' => session('organisais')->kodesubsuburusan,
                'p.kodeorganisasi' => session('organisais')->kodeorganisasi,
                'p.kodesuborganisasi' => session('organisais')->kodesuborganisasi,
                'p.kodeunit' => session('organisais')->kodeunit,
                'p.kodesubunit' => session('organisais')->kodesubunit,
                'p.kodesubsubunit' => session('organisais')->kodesubsubunit,
            ]);
        }
        $totalData = $totalData->orderByRaw('p.kodeurusan, p.kodesuburusan, p.kodesubsuburusan, p.kodeorganisasi, p.kodesuborganisasi, p.kodeunit, p.kodesubunit, p.kodesubsubunit asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('penyusutan as p')
                ->select('b.kodebap', 'k.kodekib', 'k.alamat', 'k.keterangan', 'p.nilai', 'p.tahun', 'p.tgl_penyusutan', 'b.tahunorganisasi')
                ->join('kibtransaksi as kt', 'p.kodekib', '=', 'kt.kodekib')
                ->join('kib as k', 'kt.kodekib', '=', 'k.kodekib')
                ->join('bap as b', 'kt.kodebap', '=', 'b.idbap');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('p.kodeurusan, p.kodesuburusan, p.kodesubsuburusan, p.kodeorganisasi, p.kodesuborganisasi, p.kodeunit, p.kodesubunit, p.kodesubsubunit ' . $request['order'][0]['dir']);
            }
            if (intval(session('user')->idrole) > 3) {
                $assets->where([
                    'p.kodeurusan' => session('organisais')->kodeurusan,
                    'p.kodesuburusan' => session('organisais')->kodesuburusan,
                    'p.kodesubsuburusan' => session('organisais')->kodesubsuburusan,
                    'p.kodeorganisasi' => session('organisais')->kodeorganisasi,
                    'p.kodesuborganisasi' => session('organisais')->kodesuborganisasi,
                    'p.kodeunit' => session('organisais')->kodeunit,
                    'p.kodesubunit' => session('organisais')->kodesubunit,
                    'p.kodesubsubunit' => session('organisais')->kodesubsubunit,
                ]);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('penyusutan as p')
                ->select('b.kodebap', 'k.kodekib', 'k.alamat', 'k.keterangan', 'p.nilai', 'p.tahun', 'p.tgl_penyusutan', 'b.tahunorganisasi')
                ->join('kibtransaksi as kt', 'p.kodekib', '=', 'kt.kodekib')
                ->join('kib as k', 'kt.kodekib', '=', 'k.kodekib')
                ->join('bap as b', 'kt.kodebap', '=', 'b.idbap')
                ->where('penyusutan', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('p.kodeurusan, p.kodesuburusan, p.kodesubsuburusan, p.kodeorganisasi, p.kodesuborganisasi, p.kodeunit, p.kodesubunit, p.kodesubsubunit ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (intval(session('user')->idrole) > 3) {
                $assets->where([
                    'p.kodeurusan' => session('organisais')->kodeurusan,
                    'p.kodesuburusan' => session('organisais')->kodesuburusan,
                    'p.kodesubsuburusan' => session('organisais')->kodesubsuburusan,
                    'p.kodeorganisasi' => session('organisais')->kodeorganisasi,
                    'p.kodesuborganisasi' => session('organisais')->kodesuborganisasi,
                    'p.kodeunit' => session('organisais')->kodeunit,
                    'p.kodesubunit' => session('organisais')->kodesubunit,
                    'p.kodesubsubunit' => session('organisais')->kodesubsubunit,
                ]);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('penyusutan as p')
                ->select('b.kodebap', 'k.kodekib', 'k.alamat', 'k.keterangan', 'p.nilai', 'p.tahun', 'p.tgl_penyusutan', 'b.tahunorganisasi')
                ->join('kibtransaksi as kt', 'p.kodekib', '=', 'kt.kodekib')
                ->join('kib as k', 'kt.kodekib', '=', 'k.kodekib')
                ->join('bap as b', 'kt.kodebap', '=', 'b.idbap')
                ->where('penyusutan', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('p.kodeurusan, p.kodesuburusan, p.kodesubsuburusan, p.kodeorganisasi, p.kodesuborganisasi, p.kodeunit, p.kodesubunit, p.kodesubsubunit ' . $request['order'][0]['dir']);
            }
            if (intval(session('user')->idrole) > 3) {
                $totalFiltered->where([
                    'p.kodeurusan' => session('organisais')->kodeurusan,
                    'p.kodesuburusan' => session('organisais')->kodesuburusan,
                    'p.kodesubsuburusan' => session('organisais')->kodesubsuburusan,
                    'p.kodeorganisasi' => session('organisais')->kodeorganisasi,
                    'p.kodesuborganisasi' => session('organisais')->kodesuborganisasi,
                    'p.kodeunit' => session('organisais')->kodeunit,
                    'p.kodesubunit' => session('organisais')->kodesubunit,
                    'p.kodesubsubunit' => session('organisais')->kodesubsubunit,
                ]);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = '' . $item->kodebap;
            $row[] = '' . $item->kodekib;
            $row[] = '' . $item->alamat;
            $row[] = '' . $item->keterangan;
            $row[] = '' . $item->nilai;
            $row[] = '' . $item->tahunorganisasi;
            $row[] = '' . $item->tgl_penyusutan;
            $row[] = $item->kodekib;
            $dataFiltered[] = $row;
        }
        $response = [
            'draw' => $request['draw'],
            'recordsFiltered' => $totalFiltered,
            'recordsTotal' => count($dataFiltered),
            'aaData' => $dataFiltered,
        ];

        return Response()->json($response, 200);
    }
}

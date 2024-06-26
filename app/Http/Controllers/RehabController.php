<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RehabController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.rehab.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterrehab')
            ->selectRaw('DISTINCT(urai)')
            ->groupByRaw('kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub, urai')
            ->orderBy('urai', 'asc')
            ->get()->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterrehab')
                ->select('kodegolongan', 'kodebidang', 'kodekelompok', 'kodesub', 'kodesubsub', 'urai');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('urai '.$request['order'][0]['dir']);
            }
            $assets = $assets->groupByRaw('kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub, urai')->get();
        } else {
            $assets = DB::table('masterrehab')
                ->select('kodegolongan', 'kodebidang', 'kodekelompok', 'kodesub', 'kodesubsub', 'urai')
                ->where('urai', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('urai '.$request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->groupByRaw('kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub, urai')->get();

            $totalFiltered = DB::table('masterrehab')
                ->selectRaw('DISTINCT(urai)')
                ->where('urai', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('urai '.$request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->groupByRaw('kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub, urai')->get()->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = null;
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->kodegolongan.'.'.$item->kodebidang.'.'.$item->kodekelompok.'.'.$item->kodesub.'.'.$item->kodesubsub.' '.$item->urai;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodegolongan.'.'.$item->kodebidang.'.'.$item->kodekelompok.'.'.$item->kodesub.'.'.$item->kodesubsub;
            $row[] = DB::table('masterrehab')->where([
                'kodegolongan' => $item->kodegolongan,
                'kodebidang' => $item->kodebidang,
                'kodekelompok' => $item->kodekelompok,
                'kodesub' => $item->kodesub,
                'kodesubsub' => $item->kodesubsub,
            ])->get();
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

    public function listBarang(Request $request)
    {
        $totalData = DB::table('masterbarang as mb')->select('mb.kodegolongan', 'mb.kodebidang', 'mb.kodekelompok', 'mb.kodesub', 'mb.kodesubsub', 'mb.urai', 'mr.koderehab')
            ->leftJoin(
                'masterrehab as mr',
                [
                    ['mr.kodegolongan', 'mb.kodegolongan'],
                    ['mr.kodebidang', 'mb.kodebidang'],
                    ['mr.kodekelompok', 'mb.kodekelompok'],
                    ['mr.kodesub', 'mb.kodesub'],
                    ['mr.kodesubsub', 'mb.kodesubsub'],
                ]
            )
            ->where([
                ['mb.kodesub', 0],
                ['mb.kodekelompok', '<>', 0],
            ])->groupByRaw('kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub, urai, koderehab')->get();
        $totalData = $totalData->where('koderehab', null)->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterbarang as mb')
                ->select('mb.kodegolongan', 'mb.kodebidang', 'mb.kodekelompok', 'mb.kodesub', 'mb.kodesubsub', 'mb.urai', 'mr.koderehab')
                ->leftJoin(
                    'masterrehab as mr',
                    [
                        ['mr.kodegolongan', 'mb.kodegolongan'],
                        ['mr.kodebidang', 'mb.kodebidang'],
                        ['mr.kodekelompok', 'mb.kodekelompok'],
                        ['mr.kodesub', 'mb.kodesub'],
                        ['mr.kodesubsub', 'mb.kodesubsub'],
                    ]
                )->where([
                    ['mb.kodesub', 0],
                    ['mb.kodekelompok', '<>', 0],
                ])->groupByRaw('kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub, urai, koderehab')->get();
            $assets = collect(array_values($assets->where('koderehab', null)->values()->all()));
            if ($request['length'] != '-1') {
                $assets = $assets->only(limitOffsetToArray($request['length'], ($request['start'] + 1)));
            }
            if (isset($request['order'][0]['column'])) {
                $assets = $assets->sortBy('urai', SORT_REGULAR, $request['order'][0]['column'] == 'desc' ? true : false)->values()->all();
            }
            $assets = $assets;
        } else {
            $assets = DB::table('masterbarang as mb')
                ->select('mb.kodegolongan', 'mb.kodebidang', 'mb.kodekelompok', 'mb.kodesub', 'mb.kodesubsub', 'mb.urai', 'mr.koderehab')
                ->leftJoin(
                    'masterrehab as mr',
                    [
                        ['mr.kodegolongan', 'mb.kodegolongan'],
                        ['mr.kodebidang', 'mb.kodebidang'],
                        ['mr.kodekelompok', 'mb.kodekelompok'],
                        ['mr.kodesub', 'mb.kodesub'],
                        ['mr.kodesubsub', 'mb.kodesubsub'],
                    ]
                )->where([
                    ['mb.kodesub', 0],
                    ['mb.kodekelompok', '<>', 0],
                    ['mb.urai', 'like', '%'.$request['search']['value'].'%'],
                ])->get();
            if (isset($request['order'][0]['column'])) {
                $assets = $assets->sortBy('urai', SORT_REGULAR, $request['order'][0]['column'] == 'desc' ? true : false)->values()->all();
            }
            if ($request['length'] != '-1') {
                // return json_encode([limitOffsetToArray($request['length'], ($request['start'] + 1)), $request['length'], $request['start']]);
                $assets = $assets->only(limitOffsetToArray($request['length'], ($request['start'] + 1)))->values()->all();
            }

            $totalData =
                DB::table('masterbarang as mb')
                    ->select('mb.kodegolongan', 'mb.kodebidang', 'mb.kodekelompok', 'mb.kodesub', 'mb.kodesubsub', 'mb.urai', 'mr.koderehab')
                    ->leftJoin(
                        'masterrehab as mr',
                        [
                            ['mr.kodegolongan', 'mb.kodegolongan'],
                            ['mr.kodebidang', 'mb.kodebidang'],
                            ['mr.kodekelompok', 'mb.kodekelompok'],
                            ['mr.kodesub', 'mb.kodesub'],
                            ['mr.kodesubsub', 'mb.kodesubsub'],
                        ]
                    )->where([
                        ['mb.kodesub', 0],
                        ['mb.kodekelompok', '<>', 0],
                        ['mb.urai', 'like', '%'.$request['search']['value'].'%'],
                    ])->get();
            if (isset($request['order'][0]['column'])) {
                $totalData = $totalData->sortBy('urai', SORT_REGULAR, $request['order'][0]['column'] == 'desc' ? true : false)->values()->all();
            }
            $totalFiltered = $totalData->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $item->kodegolongan.'.'.$item->kodebidang.'.'.$item->kodekelompok.'.'.$item->kodesub.'.'.$item->kodesubsub.' '.$item->urai;
            $row[] = "<button class='btn btn-warning use' ><i class='bx bx-check'></i> Pakai</button>";
            $row[] = $item->kodegolongan.'.'.$item->kodebidang.'.'.$item->kodekelompok.'.'.$item->kodesub.'.'.$item->kodesubsub;
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = [];
            $kodebarang = explode('.', $request->kodebarang);
            for ($i = 0; $i < count($request->persentase_awal); $i++) {
                if ($request->persentase_awal[$i] == $request->persentase_awal[$i + 1] || $request->persentase_akhir[$i] == $request->persentase_akhir[$i + 1] || $request->tahunmasamanfaat[$i] == $request->tahunmasamanfaat[$i + 1]) {
                    throw new Exception('mohon untuk pengisian nilai detail data rehab untuk tidak sama', 422);
                }
                $data[] = [
                    'kodegolongan' => $kodebarang[0],
                    'kodebidang' => $kodebarang[1],
                    'kodekelompok' => $kodebarang[2],
                    'kodesub' => $kodebarang[3],
                    'kodesubsub' => $kodebarang[4],
                    'urai' => $request->urai,
                    'persentase_awal' => $request->persentase_awal[$i],
                    'persentase_awal' => $request->persentase_awal[$i],
                    'persentase_akhir' => $request->persentase_akhir[$i],
                    'tahunmasamanfaat' => $request->tahunmasamanfaat[$i],
                ];
            }
            DB::table('masterrehab')->insert($data);
            DB::commit();
            $response = ['message' => 'berhasil menambahkan data master rebah'];

            return response()->json($response, 200);
        } catch (Exception $th) {
            DB::rollBack();
            $response = ['message' => 'gagal menambahkan data master rebah'];
            if ($th->getCode() == 422) {
                $response = ['message' => $th->getMessage()];
            }

            return response()->json($response, 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kodebarang = explode('.', $id);
        $data = DB::table('masterrehab')->where([
            'kodegolongan' => $kodebarang[0],
            'kodebidang' => $kodebarang[1],
            'kodekelompok' => $kodebarang[2],
            'kodesub' => $kodebarang[3],
            'kodesubsub' => $kodebarang[4],
        ])->get();
        if (count($data) == 0) {
            $response = ['message' => 'data master rehab ditemukan', 'data' => $data];
            $status = 404;
        } else {
            $status = 200;
            $response = ['message' => 'data master rehab tidak ditemukan', 'data' => $data];
        }

        return response()->json($response, $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $kodebarang = $id;
            for ($i = 0; $i < count($request->koderehab); $i++) {
                DB::table('masterrehab')->where([
                    'kodegolongan' => $kodebarang[0],
                    'kodebidang' => $kodebarang[1],
                    'kodekelompok' => $kodebarang[2],
                    'kodesub' => $kodebarang[3],
                    'kodesubsub' => $kodebarang[4],
                    'koderehab' => $request->koderehab[$i],
                ])->update([
                    'persentase_awal' => $request->persentase_awal[$i],
                    'persentase_akhir' => $request->persentase_akhir[$i],
                    'tahunmasamanfaat' => $request->tahunmasamanfaat[$i],
                ]);
            }
            DB::commit();
        } catch (Exception $th) {
            DB::rollBack();
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $kodebarang = explode('.', $id);
            $count_rehab = DB::table('kibtransaksi as kt')
                ->join('bap as b', 'b.idbap', '=', 'kt.kodebap')
                ->join('kib as k', 'k.kodekib', '=', 'kt.kodekib')
                ->where([
                    'k.kodegolongan' => $kodebarang[0],
                    'k.kodebidang' => $kodebarang[1],
                    'k.kodekelompok' => $kodebarang[2],
                    'k.kodesub' => $kodebarang[3],
                    'k.kodesubsub' => $kodebarang[4],
                    'b.kodejenistransaksi' => 113,
                ])->count();
            if ($count_rehab > 0) {
                throw new Exception('Data tidak dihapus dikarenakan digunakan oleh data lain, harap hapus terlebih dahulu data tersebut', 422);
            }
            DB::table('masterrehab')
                ->where([
                    'kodegolongan' => $kodebarang[0],
                    'kodebidang' => $kodebarang[1],
                    'kodekelompok' => $kodebarang[2],
                    'kodesub' => $kodebarang[3],
                    'kodesubsub' => $kodebarang[4],
                ])
                ->delete();
            $response = ['message' => 'data master rehab berhasil di hapus'];
            DB::commit();

            return response()->json($response, 200);
        } catch (Exception $th) {
            DB::rollBack();
            if ($th->getCode() == 422) {
                $response = ['message' => $th->getMessage()];
            }
            $response = ['message' => 'data master rehab gagal di hapus'];

            return response()->json($response, 422);
        }
    }
}

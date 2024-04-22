<?php

namespace App\Http\Controllers;

use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KapitalisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.kapitalisasi.index');
    }

    public function useable()
    {
        $data = DB::table('masterbarang as m')
            ->selectRaw("concat(m.kodegolongan , ',', m.kodebidang) as id, concat(m.kodegolongan , ',', m.kodebidang, '-', m.urai) as name")
            ->join('masterkapitalisasi as m2', function (JoinClause $join) {
                $join->on('m2.kodegolongan', '!=', 'm.kodegolongan')
                    ->on('m2.kodebidang', '!=', 'm.kodebidang');
            })
            ->where(
                [
                    ['m.kodegolongan', '<>', 0],
                    ['m.kodebidang', '<>', 0],
                    ['m.kodekelompok', '=', 0],
                    ['m.kodesub', '=', 0],
                    ['m.kodesubsub', '=', 0],

                ]
            )->whereRaw("not exists (select concat(kodegolongan , ',', kodebidang) from masterkapitalisasi)")
            ->groupByRaw(
                'm.kodegolongan, m.kodebidang, m.urai'
            )
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'master kode barang berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'master kode barang berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterkapitalisasi')
            ->orderBy('kodekapitalisasi', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterkapitalisasi')
                ->select('*');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kodegolongan '.$request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('masterkapitalisasi')->select('*')
                ->where('kodegolongan', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kodegolongan '.$request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('masterkapitalisasi')
                ->select('*')
                ->where('kodegolongan', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('kodegolongan '.$request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = ''.splitKodeGolongan($item->kodegolongan).'.'.stringPad($item->kodebidang);
            $row[] = 'Rp. '.number_format($item->nilai);
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodekapitalisasi;
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
        [$request->kodegolongan, $request->kodebidang] = explode(',', $request->kodebarang);
        $request->nilai = convertStringToNumber($request->nilai);
        DB::beginTransaction();
        try {
            DB::table('masterkapitalisasi')->insert($request->except('kodebarang'));
            DB::commit();
            $statuscode = 200;
            $response = ['message' => 'master kapitalisasi berhasil di tambahkan'];
        } catch (\Throwable $th) {
            $statuscode = 422;
            $response = ['message' => 'master kapitalisasi berhasil di tambahkan'];
        }

        return response()->json($response, $statuscode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('masterkapitalisasi')->where('kodekapitalisasi', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master kapitalisasi berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master kapitalisasi gagal di temukan', 'data' => $data];
        }

        return response()->json($message, $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        $request->nilai = convertStringToNumber($request->nilai);
        try {
            DB::table('masterkapitalisasi')->where('kodekapitalisasi', $id)->update($request->except('_token'));
            $statuscode = 200;
            $response = ['message' => 'master kapitalisasi berhasil di ubah'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $statuscode = 422;
            $response = ['message' => 'master kapitalisasi gagal di ubah'];
        }

        return response()->json($response, $statuscode);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('masterkapitalisasi')
                ->where('kodekapitalisasi', $id)->delete();
            $status = 200;
            $message = ['message' => 'data master kapitalisasi berhasil di hapus'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 404;
            $message = ['message' => 'data master kapitalisasi gagal di hapus'];
        }

        return response()->json($message, $status);
    }
}

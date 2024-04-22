<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RuanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.ruangan.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterruang')
            ->orderBy('kodelokasi', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterruang')
                ->select('*');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('ruang '.$request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('masterruang')->select('*')
                ->where('ruang', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('ruang '.$request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('masterruang')
                ->select('*')
                ->where('ruang', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('ruang '.$request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = ''.$item->ruang;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->koderuang;
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

    public function lastRoomNumber($organisasi)
    {
        [
            $kodeurusan,
            $kodesuburusan,
            $kodesubsuburusan,
            $kodeorganisasi,
            $kodesuborganisasi,
            $kodeunit,
            $kodesubunit,
            $kodesubsubunit
        ] = explode('.', $organisasi);
        $data = DB::table('masterruang')->select('noruang', 'uraiorganisasi')->where([
            'kodeurusan' => $kodeurusan,
            'kodesuburusan' => $kodesuburusan,
            'kodesubsuburusan' => $kodesubsuburusan,
            'kodeorganisasi' => $kodeorganisasi,
            'kodesuborganisasi' => $kodesuborganisasi,
            'kodeunit' => $kodeunit,
            'kodesubunit' => $kodesubunit,
            'kodesubsubunit' => $kodesubsubunit,
        ])->orderBy('koderuang', 'desc')->first();
        $statuscode = $data == null ? 404 : 200;
        $response = ['message' => 'nomer ruang terakhir di organisasi', 'data' => $data == null ? ['noruang' => 1] : $data];

        return response()->json($response, $statuscode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            [
                $kodeurusan,
                $kodesuburusan,
                $kodesubsuburusan,
                $kodeorganisasi,
                $kodesuborganisasi,
                $kodeunit,
                $kodesubunit,
                $kodesubsubunit
            ] = explode('.', $request->kodeorganisasi ?? '0.0.0.0.0.0.0.0');
            DB::table('masterruang')->insert([
                'kodeurusan' => $kodeurusan,
                'kodesuburusan' => $kodesuburusan,
                'kodesubsuburusan' => $kodesubsuburusan,
                'kodeorganisasi' => $kodeorganisasi,
                'kodesuborganisasi' => $kodesuborganisasi,
                'kodeunit' => $kodeunit,
                'kodesubunit' => $kodesubunit,
                'kodesubsubunit' => $kodesubsubunit,
                'noruang' => $request->noruang,
                'ruang' => $request->ruang,
                'penanggungjawab_jabatan' => $request->penanggungjawab_jabatan,
                'penanggungjawab_nama' => $request->penanggungjawab_nama,
                'penanggungjawab_nip' => $request->penanggungjawab_nip,
            ]);
            DB::commit();
            $statuscode = 200;
            $response = ['message' => 'master ruang berhasil di tambahkan'];
        } catch (\Throwable $th) {
            $statuscode = 422;
            $response = ['message' => 'master ruang gagal di tambahkan'];
            DB::rollBack();
        }

        return response()->json($response, $statuscode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('masterruang')
            ->select(
                DB::raw("CONCAT(kodeurusan, '.', kodesuburusan, '.', kodesubsuburusan, '.', kodeorganisasi, '.', kodesuborganisasi, '.', kodeunit, '.', kodesubunit, '.', kodesubsubunit) as organisasi"),
                'masterruang.*',
            )->where('koderuang', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master ruang berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master ruang gagal di temukan', 'data' => $data];
        }

        return response()->json($message, $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            [
                $kodeurusan,
                $kodesuburusan,
                $kodesubsuburusan,
                $kodeorganisasi,
                $kodesuborganisasi,
                $kodeunit,
                $kodesubunit,
                $kodesubsubunit
            ] = explode('.', $request->kodeorganisasi ?? '0.0.0.0.0.0.0.0');
            DB::table('masterruang')
                ->where('koderuang', $id)->update([
                    'kodeurusan' => $kodeurusan,
                    'kodesuburusan' => $kodesuburusan,
                    'kodesubsuburusan' => $kodesubsuburusan,
                    'kodeorganisasi' => $kodeorganisasi,
                    'kodesuborganisasi' => $kodesuborganisasi,
                    'kodeunit' => $kodeunit,
                    'kodesubunit' => $kodesubunit,
                    'kodesubsubunit' => $kodesubsubunit,
                    'noruang' => $request->noruang,
                    'ruang' => $request->ruang,
                    'penanggungjawab_jabatan' => $request->penanggungjawab_jabatan ?? null,
                    'penanggungjawab_nama' => $request->penanggungjawab_nama ?? null,
                    'penanggungjawab_nip' => $request->penanggungjawab_nip ?? null,
                ]);
            $status = 200;
            $message = ['message' => 'data master ruang berhasil di hapus'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 404;
            $message = ['message' => 'data master ruang gagal di hapus'];
        }

        return response()->json($message, $status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('masterruang')
                ->where('koderuang', $id)->delete();
            $status = 200;
            $message = ['message' => 'data master ruang berhasil di hapus'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 404;
            $message = ['message' => 'data master ruang gagal di hapus'];
        }

        return response()->json($message, $status);
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.lokasi.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterlokasi')
            ->orderBy('kodelokasi', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterlokasi')
                ->select('*');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('nama '.$request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('masterlokasi')->select('*')
                ->where('nama', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('nama '.$request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('masterlokasi')
                ->select('*')
                ->where('nama', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('nama '.$request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = ''.$item->nama;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodelokasi;
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
        $data = $request->except('_token', 'kodelokasi');
        DB::beginTransaction();
        try {
            $unique = DB::table('masterlokasi')
                ->where('nama', $request->nama)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data lokasi, terdapat duplikasi data lokasi', 422);
            }
            DB::table('masterlokasi')->insert($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master lokasi berhasil ditambahkan'];
        } catch (Exception $th) {
            $message = ['message' => 'Master lokasi gagal ditambahkan'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
            DB::rollBack();
        }

        return response()->json($message, $status);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('masterlokasi')->where('kodelokasi', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master lokasi berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master lokasi gagal di temukan', 'data' => $data];
        }

        return response()->json($message, $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');
        DB::beginTransaction();
        try {
            $unique = DB::table('masterlokasi')
                ->where('nama', $request->nama)
                ->where('kodelokasi', $id)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data lokasi, terdapat duplikasi data lokasi', 422);
            }
            DB::table('masterlokasi')->where('kodelokasi', $id)->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master warna berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Master warna gagal diubah'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
            DB::rollBack();
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
            $data = DB::table('masterlokasi')
                ->where('kodelokasi', $id)
                ->first();
            $count = DB::table('kib')
                ->where('lokasi', $data->nama)
                ->count();
            if ($count > 0) {
                throw new Exception('data sudah di gunakan di tabel lain, mohon hapus terlebih dahulu data tersebut', 422);
            }
            DB::table('masterlokasi')
                ->where('kodelokasi', $id)
                ->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data master lokasi'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master lokasi'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }

        return response()->json($message, $status);
    }
}

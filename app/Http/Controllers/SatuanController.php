<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SatuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.satuan.index');
    }
    public function dataTable(Request $request)
    {
        $totalData = DB::table('mastersatuan')
            ->orderBy('kodesatuan', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('mastersatuan')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('satuan ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('mastersatuan')->select('*')
                ->where('satuan', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('satuan ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('mastersatuan')->select('*')
                ->where('satuan', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('satuan ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $index + 1;
            $row[] = $item->satuan;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodesatuan;
            $dataFiltered[] = $row;
        }
        $response = [
            'draw' => $request['draw'],
            'recordsFiltered' => $totalFiltered,
            'recordsTotal' => count($dataFiltered),
            'aaData' => $dataFiltered
        ];

        return Response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('mastersatuan')
            ->where('kodesatuan', $id)
            ->first();
        if ($data) {
            $status = 200;
            $message = ['message' => "data master warna berhasil di temukan", 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => "data master warna gagal di temukan", 'data' => $data];
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
            $unique = DB::table('mastersatuan')
                ->where('satuan',   $request->satuan)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data satuan, terdapat duplikasi data satuan', 422);
            }
            DB::table('mastersatuan')
                ->where('kodesatuan', $id)
                ->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master satuan berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Master satuan gagal diubah'];
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
            $count = DB::table('kib')->where('kodesatuan', $id)->count();
            if ($count > 0) {
                throw new Exception('data sudah di gunakan di tabel lain, mohon hapus terlebih dahulu data tersebut', 422);
            }
            DB::table('mastersatuan')->where('kodesatuan', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data master satuan'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master satuan'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }
        return response()->json($message, $status);
    }
}

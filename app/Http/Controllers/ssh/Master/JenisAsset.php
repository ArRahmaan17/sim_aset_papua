<?php

namespace App\Http\Controllers\ssh\Master;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JenisAsset extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.ssh.jenis-asset.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('jenis')
            ->join('kib_master as km', 'jenis.id_master', '=', 'km.id')
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('jenis')
                ->join('kib_master as km', 'jenis.id_master', '=', 'km.id')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('jenis ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('jenis')
                ->join('kib_master as km', 'jenis.id_master', '=', 'km.id')->select('*')
                ->where('jenis', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('jenis ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('jenis')
                ->join('kib_master as km', 'jenis.id_master', '=', 'km.id')->select('*')
                ->where('jenis', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('jenis ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->jenis;
            $row[] = $item->kib;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->id;
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
        $data = $request->except('_token', 'id');
        DB::beginTransaction();
        try {
            $unique = DB::table('jenis')
                ->where('jenis', $request->jenis)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data jenis, terdapat duplikasi data jenis', 422);
            }
            DB::table('jenis')->insert($data);
            DB::commit();
            $data = DB::table('jenis')->get()->toArray();
            $status = 200;
            $message = ['message' => 'Master jenis berhasil ditambahkan', 'data' => $data];
        } catch (Exception $th) {
            $message = ['message' => 'Master jenis gagal ditambahkan'];
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
        $data = DB::table('jenis')->where('id', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master jenis berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master jenis gagal di temukan', 'data' => $data];
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
            $unique = DB::table('jenis')
                ->where('jenis', $request->jenis)
                ->where('id', '<>', $id)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data jenis, terdapat duplikasi data jenis', 422);
            }
            DB::table('jenis')->where('id', $id)->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master jenis berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Master jenis gagal diubah'];
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
            $count = DB::table('kib')->where('id', $id)->count();
            if ($count > 0) {
                throw new Exception('data sudah di gunakan di tabel lain, mohon hapus terlebih dahulu data tersebut', 422);
            }
            DB::table('jenis')->where('id', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data master jenis'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master jenis'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }

        return response()->json($message, $status);
    }
}

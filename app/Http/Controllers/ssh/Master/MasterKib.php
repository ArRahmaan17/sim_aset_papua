<?php

namespace App\Http\Controllers\ssh\Master;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterKib extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.ssh.master-kib.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('kib_master')
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('kib_master')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('type ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('kib_master')->select('*')
                ->where('type', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kode', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kib', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('type ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('kib_master')->select('*')
                ->where('type', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kode', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kib', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('type ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->type;
            $row[] = $item->kode;
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
            $unique = DB::table('kib_master')
                ->where('type', $request->type)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data master kib, terdapat duplikasi data master kib', 422);
            }
            DB::table('kib_master')->insert($data);
            DB::commit();
            $data = DB::table('kib_master')->get()->toArray();
            $status = 200;
            $message = ['message' => 'Master kib berhasil ditambahkan', 'data' => $data];
        } catch (Exception $th) {
            dd($th);
            $message = ['message' => 'Master kib gagal ditambahkan'];
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
        $data = DB::table('kib_master')->where('id', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master kib berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master kib gagal di temukan', 'data' => $data];
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
            $unique = DB::table('kib_master')
                ->where('type', $request->type)
                ->where('id', '<>', $id)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data master kib, terdapat duplikasi data master kib', 422);
            }
            DB::table('kib_master')->where('id', $id)->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master kib berhasil diubah'];
        } catch (Exception $th) {
            dd($th);
            $message = ['message' => 'Master kib gagal diubah'];
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
            DB::table('kib_master')->where('id', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data master kib'];
            $status = 200;
        } catch (Exception $th) {
            dd($th);
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master kib'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }

        return response()->json($message, $status);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JurnalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.jurnal.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterjurnal')
            ->orderBy('kodelokasi', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterjurnal')
                ->select('*');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('jurnal ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('masterjurnal')->select('*')
                ->where('jurnal', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('jurnal ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('masterjurnal')
                ->select('*')
                ->where('jurnal', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('jurnal ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = '' . $item->jurnal;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodejurnal;
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
            DB::table('masterjurnal')->insert($request->except('_token'));
            DB::commit();
            $statuscode = 200;
            $response = ['message' => 'master jurnal berhasil di tambahkan'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $statuscode = 422;
            $response = ['message' => 'master jurnal gagal di tambahkan'];
        }

        return response()->json($response, $statuscode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('masterjurnal')->where('kodejurnal', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master jurnal berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master jurnal gagal di temukan', 'data' => $data];
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
            DB::table('masterjurnal')->where('kodejurnal', $id)->update($request->except('_token'));
            DB::commit();
            $statuscode = 200;
            $response = ['message' => 'master jurnal berhasil di ubah'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $statuscode = 422;
            $response = ['message' => 'master jurnal gagal di ubah'];
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
            DB::table('masterjurnal')
                ->where('kodejurnal', $id)->delete();
            $status = 200;
            $message = ['message' => 'data master jurnal berhasil di hapus'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 404;
            $message = ['message' => 'data master jurnal gagal di hapus'];
        }

        return response()->json($message, $status);
    }
}

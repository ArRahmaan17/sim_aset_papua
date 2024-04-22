<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KondisiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.kondisi.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterkondisi')
            ->orderBy('kodekondisi', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterkondisi')
                ->select('*');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kondisi '.$request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('masterkondisi')->select('*')
                ->where('kondisi', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kondisi '.$request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('masterkondisi')
                ->select('*')
                ->where('kondisi', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('kondisi '.$request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = ''.$item->kondisi;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodekondisi;
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
            DB::table('masterkondisi')->insert($request->except('_token'));
            DB::commit();
            $statuscode = 200;
            $response = ['message' => 'master kondisi berhasil di tambahkan'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $statuscode = 422;
            $response = ['message' => 'master kondisi gagal di tambahkan'];
        }

        return response()->json($response, $statuscode);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('masterkondisi')->where('kodekondisi', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master kondisi berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master kondisi gagal di temukan', 'data' => $data];
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
            DB::table('masterkondisi')->where('kodekondisi', $id)->update($request->except('_token'));
            DB::commit();
            $statuscode = 200;
            $response = ['message' => 'master kondisi berhasil di ubah'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $statuscode = 422;
            $response = ['message' => 'master kondisi gagal di ubah'];
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
            DB::table('masterkondisi')
                ->where('kodekondisi', $id)->delete();
            $status = 200;
            $message = ['message' => 'data master kondisi berhasil di hapus'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 404;
            $message = ['message' => 'data master kondisi gagal di hapus'];
        }

        return response()->json($message, $status);
    }
}

<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatusTanahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.statustanah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterstatustanah')
            ->orderBy('kodestatustanah', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterstatustanah')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('statustanah '.$request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('masterstatustanah')->select('*')
                ->where('statustanah', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('statustanah '.$request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('masterstatustanah')->select('*')
                ->where('statustanah', 'like', '%'.$request['search']['value'].'%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('statustanah '.$request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->statustanah;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodestatustanah;
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
        $data = $request->except('_token', 'kodestatustanah');
        DB::beginTransaction();
        try {
            $unique = DB::table('masterstatustanah')
                ->where('statustanah', $request->statustanah)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data status tanah, terdapat duplikasi data status tanah', 422);
            }
            DB::table('masterstatustanah')->insert($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master status tanah berhasil ditambahkan'];
        } catch (Exception $th) {
            $message = ['message' => 'Master status tanah gagal ditambahkan'];
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
        $data = DB::table('masterstatustanah')
            ->where('kodestatustanah', $id)
            ->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data master status tanah berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data master status tanah gagal di temukan', 'data' => $data];
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
            $unique = DB::table('masterstatustanah')
                ->where('statustanah', $request->statustanah)
                ->where('kodestatustanah', '<>', $id)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data status tanah, terdapat duplikasi data status tanah', 422);
            }
            DB::table('masterstatustanah')
                ->where('kodestatustanah', $id)
                ->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master status tanah berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Master status tanah gagal diubah'];
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
            $count = DB::table('kib')->where('kodestatustanah', $id)->count();
            if ($count > 0) {
                throw new Exception('data sudah di gunakan di tabel lain, mohon hapus terlebih dahulu data tersebut', 422);
            }
            DB::table('masterstatustanah')->where('kodestatustanah', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data master status tanah'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master status tanah'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }

        return response()->json($message, $status);
    }
}

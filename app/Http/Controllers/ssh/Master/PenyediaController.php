<?php

namespace App\Http\Controllers\ssh\Master;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PenyediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.ssh.penyedia.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('penyedia')
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('penyedia')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('nm_penyedia ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('penyedia')->select('*')
                ->where('nm_penyedia', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('pimpinan', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('telp', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('alamat', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('email', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('nm_penyedia ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('penyedia')->select('*')
                ->where('nm_penyedia', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('pimpinan', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('telp', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('alamat', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('email', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('nm_penyedia ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->nm_penyedia;
            $row[] = $item->pimpinan;
            $row[] = $item->telp;
            $row[] = $item->alamat;
            $row[] = $item->email;
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

    public function useable()
    {
        $data = DB::table('penyedia')
            ->select(
                'id',
                'nm_penyedia as name'
            )
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'penyedia berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'penyedia berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'id');
        DB::beginTransaction();
        try {
            DB::table('penyedia')->insert($data);
            DB::commit();
            $data = DB::table('penyedia')->get()->toArray();
            $status = 200;
            $message = ['message' => 'Penyedia berhasil ditambahkan', 'data' => $data];
        } catch (Exception $th) {
            $message = ['message' => 'Penyedia gagal ditambahkan'];
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
        $data = DB::table('penyedia')->where('id', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data penyedia berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data penyedia gagal di temukan', 'data' => $data];
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
            DB::table('penyedia')->where('id', $id)->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Penyedia berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Penyedia gagal diubah'];
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
            // $count = DB::table('kib')->where('id', $id)->count();
            // if ($count > 0) {
            //     throw new Exception('data sudah di gunakan di tabel lain, mohon hapus terlebih dahulu data tersebut', 422);
            // }
            DB::table('penyedia')->where('id', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data penyedia'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data penyedia'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }

        return response()->json($message, $status);
    }
}

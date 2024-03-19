<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GolonganBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.golonganbarang.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'kodegolonganbarang');
        DB::beginTransaction();
        try {
            $unique = DB::table('mastergolonganbarang')
                ->where('golonganbarang',   $request->golonganbarang)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data golongan barang, terdapat duplikasi data golongan barang', 422);
            }
            DB::table('mastergolonganbarang')->insert($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master golongan barang berhasil ditambahkan'];
        } catch (Exception $th) {
            $message = ['message' => 'Master golongan barang gagal ditambahkan'];
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
        $data = DB::table('mastergolonganbarang')
            ->where('kodegolonganbarang', $id)
            ->first();
        if ($data) {
            $status = 200;
            $message = ['message' => "data master golongan barang berhasil di temukan", 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => "data master golongan barang gagal di temukan", 'data' => $data];
        }
        return response()->json($message, $status);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function dataTable(Request $request)
    {
        $totalData = DB::table('mastergolonganbarang')
            ->orderBy('kodegolonganbarang', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('mastergolonganbarang')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('golonganbarang ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('mastergolonganbarang')->select('*')
                ->where('golonganbarang', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('golonganbarang ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('mastergolonganbarang')->select('*')
                ->where('golonganbarang', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('golonganbarang ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $index + 1;
            $row[] = $item->golonganbarang;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodegolonganbarang;
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token');
        DB::beginTransaction();
        try {
            $unique = DB::table('mastergolonganbarang')
                ->where('golonganbarang',   $request->golonganbarang)
                ->where('kodegolonganbarang', '<>',   $id)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data golongan barang, terdapat duplikasi data golongan barang', 422);
            }
            DB::table('mastergolonganbarang')
                ->where('kodegolonganbarang', $id)
                ->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Master golongan barang berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Master golongan barang gagal diubah'];
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
            $count = DB::table('kib')->where('kodegolonganbarang', $id)->count();
            if ($count > 0) {
                throw new Exception('data sudah di gunakan di tabel lain, mohon hapus terlebih dahulu data tersebut', 422);
            }
            DB::table('mastergolonganbarang')->where('kodegolonganbarang', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data master golongan barang'];
            $status = 200;
        } catch (Exception $th) {
            dd($th);
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master golongan barang'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }
        return response()->json($message, $status);
    }
}

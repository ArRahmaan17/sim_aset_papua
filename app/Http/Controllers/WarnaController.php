<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarnaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warna = DB::table('masterwarna')->get();
        return view('layout.warna.index', compact('warna'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        DB::beginTransaction();
        try {
            $unique = DB::table('masterwarna')
                ->where('warna', 'like', "'%" . $request->warna . "%'")
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data warna, terdapat duplikasi data warna', 422);
            }
            DB::table('masterwarna')->insert($data);
            DB::commit();
            $data = DB::table('masterwarna')->get()->toArray();
            $status = 200;
            $message = ['message' => 'Master warna berhasil diubah', 'data' => $data];
        } catch (Exception $th) {
            $message = ['message' => 'Master warna gagal ditambahkan'];
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
        $data = DB::table('masterwarna')->where('kodewarna', $id)->first();
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
            $unique = DB::table('masterwarna')
                ->where('warna', 'like', "'%" . $request->warna . "%'")
                ->where('kodewarna', $id)
                ->count();
            if ($unique != 0) {
                throw new Exception('gagal melakukan simpan data warna, terdapat duplikasi data warna', 422);
            }
            DB::table('masterwarna')->where('kodewarna', $id)->update($data);
            DB::commit();
            $data = DB::table('masterwarna')->get()->toArray();
            $status = 200;
            $message = ['message' => 'Master warna berhasil diubah', 'data' => $data];
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
            $count = DB::table('kib')->where('kodewarna', $id)->count();
            if ($count > 0) {
                throw new Exception('data sudah di gunakan di tabel lain, mohon hapus terlebih dahulu data tersebut', 422);
            }
            DB::table('masterwarna')->where('kodewarna', $id)->delete();
            DB::commit();
            $data = DB::table('masterwarna')->get()->toArray();
            $message = ['message' => 'berhasil menghapus data master warna', 'data' => $data];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master warna'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }
        return response()->json($message, $status);
    }
}

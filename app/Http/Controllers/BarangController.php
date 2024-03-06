<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.barang.index');
    }

    public function all()
    {
        $data_barang = DB::table('masterbarang')
            ->select(
                DB::raw(
                    "CONCAT(kodegolongan, '', kodebidang, '', kodekelompok, '', kodesub, '', kodesubsub) as id"
                ),
                "urai",
                DB::raw(
                    "(case 
                                            when kodegolongan <> 0
                                                and kodebidang <> 0
                                                and kodekelompok = 0
                                                and kodesub = 0
                                                and kodesubsub = 0 
                                        then CONCAT(kodegolongan, '0', '0', '0', '0')
                                            when kodegolongan <> 0
                                                and kodebidang <> 0
                                                and kodekelompok <> 0
                                                and kodesub = 0
                                                and kodesubsub = 0 
                                        then CONCAT(kodegolongan, kodebidang, '0', '0', '0')
                                            when kodegolongan <> 0
                                                and kodebidang <> 0
                                                and kodekelompok <> 0
                                                and kodesub <> 0
                                                and kodesubsub = 0 
                                        then '0'
                                            when kodegolongan <> 0
                                                and kodebidang <> 0
                                                and kodekelompok <> 0
                                                and kodesub <> 0
                                                and kodesubsub <> 0 
                                        then CONCAT(kodegolongan, kodebidang, kodekelompok, kodesub, '0')
                                    else '0'
                                    end) as parent"
                )
            )
            // ->limit(2)
            ->where('kodebidang', '<>', 0)
            ->orderByRaw(" kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub")
            ->get()
            ->toArray();
        $data = buildTreeMenu($data_barang);
        if (count($data) == 0) {
            $message = ['message' => 'master barang gagal dibuat', 'data' => $data];
            $status = 404;
        } else {
            $status = 200;
            $message = ['message' => 'master barang berhasil dibuat', 'data' => $data];
        }
        return response()->json($message, $status);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

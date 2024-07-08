<?php

namespace App\Http\Controllers;

use Exception;
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
                    "CONCAT(explode(kodegolongan::text, '', 1), '.', explode(kodegolongan::text, '', 2), '.', explode(kodegolongan::text, '', 3), '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id"
                ),
                DB::raw("CONCAT(explode(kodegolongan::text, '', 1), '.', explode(kodegolongan::text, '', 2), '.', explode(kodegolongan::text, '', 3), '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' ', urai) as text"),
                DB::raw(
                    "(case
                                        when kodegolongan <> 0
                                        and kodebidang <> 0
                                        and kodekelompok = 0
                                        and kodesub = 0
                                        and kodesubsub = 0 
                                    then CONCAT(explode(kodegolongan::text, '', 1), '.', explode(kodegolongan::text, '', 2), '.', explode(kodegolongan::text, '', 3),
                                        '.0',
                                        '.0',
                                        '.0',
                                        '.0')
                                        when kodegolongan <> 0
                                        and kodebidang <> 0
                                        and kodekelompok <> 0
                                        and kodesub = 0
                                        and kodesubsub = 0 
                                    then CONCAT(explode(kodegolongan::text, '', 1), '.', explode(kodegolongan::text, '', 2), '.', explode(kodegolongan::text, '', 3),
                                        '.',
                                        kodebidang,
                                        '.0',
                                        '.0',
                                        '.0')
                                        when kodegolongan <> 0
                                        and kodebidang <> 0
                                        and kodekelompok <> 0
                                        and kodesub <> 0
                                        and kodesubsub = 0 
                                    then CONCAT(explode(kodegolongan::text, '', 1), '.', explode(kodegolongan::text, '', 2), '.', explode(kodegolongan::text, '', 3),
                                        '.',
                                        kodebidang,
                                        '.',
                                        kodekelompok,
                                        '.0',
                                        '.0')
                                        when kodegolongan <> 0
                                        and kodebidang <> 0
                                        and kodekelompok <> 0
                                        and kodesub <> 0
                                        and kodesubsub <> 0 
                                    then CONCAT(explode(kodegolongan::text, '', 1), '.', explode(kodegolongan::text, '', 2), '.', explode(kodegolongan::text, '', 3),
                                        '.',
                                        kodebidang,
                                        '.',
                                        kodekelompok,
                                        '.',
                                        kodesub,
                                        '.0')
                                        when explode(kodegolongan::text,
                                        '',
                                        2) <> '0'
                                        and explode(kodegolongan::text,
                                        '',
                                        3) <> '0' then CONCAT(explode(kodegolongan::text,
                                        '',
                                        1),
                                        '.',
                                        explode(kodegolongan::text,
                                        '',
                                        2),
                                        '.',
                                        '0',
                                        '.',
                                        kodebidang,
                                        '.',
                                        kodekelompok,
                                        '.',
                                        kodesub,
                                        '.',
                                        kodesubsub)
                                        when explode(kodegolongan::text,
                                        '',
                                        2) <> '0'
                                        and explode(kodegolongan::text,
                                        '',
                                        3) = '0'
                                        then CONCAT(explode(kodegolongan::text,
                                        '',
                                        1),
                                        '.',
                                        '0',
                                        '.',
                                        '0',
                                        '.',
                                        kodebidang,
                                        '.',
                                        kodekelompok,
                                        '.',
                                        kodesub,
                                        '.',
                                        kodesubsub)
                                        else '0'
                                    end) as parent"
                )
            )
            ->orderByRaw(' kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub')
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $kodebarang = explode('.', $request->kodebarang);
            DB::table('masterbarang')->insert([
                'kodegolongan' => $kodebarang[0],
                'kodebidang' => $kodebarang[1],
                'kodekelompok' => $kodebarang[2],
                'kodesub' => $kodebarang[3],
                'kodesubsub' => $kodebarang[4],
                'urai' => $request->urai,
            ]);
            DB::commit();

            return response()->json(['message' => 'Input master barang berhasil'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message' => 'Input master barang gagal'], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kodebarang = explode('.', $id);

        $data = DB::table('masterbarang')->select(
            DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as kodebarang"),
            'urai'
        )->where([
            'kodegolongan' => $kodebarang[0] . $kodebarang[1] . $kodebarang[2],
            'kodebidang' => $kodebarang[3],
            'kodekelompok' => $kodebarang[4],
            'kodesub' => $kodebarang[5],
            'kodesubsub' => $kodebarang[6],
        ])->first();
        if ($data) {
            $message = ['message' => 'detail data master barang ditemukan', 'data' => $data];
            $status = 200;
        } else {
            $status = 404;
            $message = ['message' => 'detail data master barang tidak ditemukan', 'data' => $data];
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
            $kodebarang = explode('.', $id);
            DB::table('masterbarang')->where([
                'kodegolongan' => $kodebarang[0] . $kodebarang[1] . $kodebarang[2],
                'kodebidang' => $kodebarang[3],
                'kodekelompok' => $kodebarang[4],
                'kodesub' => $kodebarang[5],
                'kodesubsub' => $kodebarang[6],
            ])->update([
                'urai' => $request->urai,
            ]);
            DB::commit();

            return response()->json(['message' => 'Ubah master barang berhasil'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json(['message' => 'Ubah master barang gagal'], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $kodebarang = explode('.', $id);
            $count_already_use = DB::table('kib')->where([
                'kodegolongan' => $kodebarang[0],
                'kodebidang' => $kodebarang[1],
                'kodekelompok' => $kodebarang[2],
                'kodesub' => $kodebarang[3],
                'kodesubsub' => $kodebarang[4],
            ])->count();
            if ($count_already_use != 0) {
                throw new Exception('master barang telah di gunakan pada perolehan', 422);
            }
            DB::table('masterbarang')
                ->where([
                    'kodegolongan' => $kodebarang[0],
                    'kodebidang' => $kodebarang[1],
                    'kodekelompok' => $kodebarang[2],
                    'kodesub' => $kodebarang[3],
                    'kodesubsub' => $kodebarang[4],
                ])->delete();

            return response()->json(['message' => 'Hapus master barang berhasil'], 200);
        } catch (Exception $th) {
            DB::rollBack();
            if ($th->getCode() == 422) {
                return response()->json(['message' => $th->getMessage()], 422);
            }

            return response()->json(['message' => 'Hapus master barang gagal'], 422);
        }
    }
}

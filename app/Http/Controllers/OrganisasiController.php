<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class OrganisasiController extends Controller
{
    public function index()
    {
        return view('layout.organisasi.index');
    }

    public function all()
    {
        $data = DB::table('masterorganisasi')->select(
            DB::raw("CONCAT(kodeurusan, '.', kodesuburusan, '.', kodesubsuburusan, '.', kodeorganisasi, '.', kodesuborganisasi, '.', kodeunit, '.', kodesubunit, '.', kodesubsubunit) as id"),
            DB::raw("CONCAT(kodeurusan, '.', kodesuburusan, '.', kodesubsuburusan, '.', kodeorganisasi, '.', kodesuborganisasi, '.', kodeunit, '.', kodesubunit, '.', kodesubsubunit, ' ', organisasi) as text"),
            DB::raw("(case
                    when kodeurusan <> 0
                    and kodesuburusan = 0
                    and kodesubsuburusan = 0
                    and kodeorganisasi = 0
                    and kodesuborganisasi = 0
                    and kodeunit = 0
                    and kodesubunit = 0
                    and kodesubsubunit = 0 then '0'
                    when kodeurusan <> 0
                    and kodesuburusan <> 0
                    and kodesubsuburusan = 0
                    and kodeorganisasi = 0
                    and kodesuborganisasi = 0
                    and kodeunit = 0
                    and kodesubunit = 0
                    and kodesubsubunit = 0 then CONCAT(kodeurusan,'.', 0,'.', 0,'.', 0,'.', 0,'.', 0,'.', 0,'.', 0)
                    when kodeurusan <> 0
                    and kodesuburusan <> 0
                    and kodesubsuburusan <> 0
                    and kodeorganisasi <> 0
                    and kodesuborganisasi = 0
                    and kodeunit = 0
                    and kodesubunit <> 0
                    and kodesubsubunit = 0 then CONCAT(kodeurusan,'.', kodesuburusan ,'.', 0,'.', 0,'.', 0,'.', 0,'.', 0,'.', 0)
                    when kodeurusan <> 0
                    and kodesuburusan <> 0
                    and kodesubsuburusan = 0
                    and kodeorganisasi = 0
                    and kodesuborganisasi = 0
                    and kodeunit = 0
                    and kodesubunit <> 0
                    and kodesubsubunit = 0 then CONCAT(kodeurusan,'.', kodesuburusan ,'.', 0,'.', 0,'.', 0,'.', 0, '.',0,'.', 0)
                    when kodeurusan <> 0
                    and kodesuburusan <> 0
                    and kodesubsuburusan <> 0
                    and kodeorganisasi <> 0
                    and kodesuborganisasi <> 0
                    and kodeunit <> 0
                    and kodesubunit <> 0
                    and kodesubsubunit = 0 then CONCAT(kodeurusan,'.', kodesuburusan ,'.', 0,'.', 0,'.', 0,'.', 0,'.', 0,'.', 0)
                    else CONCAT(kodeurusan, '.', kodesuburusan, '.', kodesubsuburusan, '.', kodeorganisasi, '.', kodesuborganisasi, '.', kodeunit, '.', kodesubunit, '.', kodesubsubunit)
                end) as parent")
        )->get()->toArray();
        if (count($data) == 0) {
            $message = ['message' => 'Master Organisasi tidak ditemukan', 'data' => $data];
            $status = 404;
        } else {
            $status = 200;
            $message = ['message' => 'Master Organisasi ditemukan', 'data' => buildTreeOrganisasi($data)];
        }

        return response()->json($message, $status);
    }

    public function useable()
    {
        $data = DB::table('masterorganisasi')->select(
            DB::raw("CONCAT(kodeurusan, '.', kodesuburusan, '.', kodesubsuburusan, '.', kodeorganisasi, '.', kodesuborganisasi, '.', kodeunit, '.', kodesubunit, '.', kodesubsubunit) as id"),
            DB::raw("CONCAT(kodeurusan, '.', kodesuburusan, '.', kodesubsuburusan, '.', kodeorganisasi, '.', kodesuborganisasi, '.', kodeunit, '.', kodesubunit, '.', kodesubsubunit, ' ', organisasi) as name"),
        )->where('kodeorganisasi', '<>', 0)->get()->toArray();
        if (count($data) == 0) {
            $message = ['message' => 'Master Organisasi tidak ditemukan', 'data' => $data];
            $status = 404;
        } else {
            $status = 200;
            $message = ['message' => 'Master Organisasi ditemukan', 'data' => dataToOption($data)];
        }

        return response()->json($message, $status);
    }
}

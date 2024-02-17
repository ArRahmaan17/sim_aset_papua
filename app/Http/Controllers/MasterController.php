<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function masterAsalUsul()
    {
        return response()->json([
            'html_kategori' => dataToOption(DB::table('masterasalusul')->select(DB::raw('distinct(kategori) as name'))->orderBy('kategori')->get()),
            'html_asal_usul' => dataToOption(DB::table('masterasalusul')->select(['kategori as attribute', 'kodeasalusul as id', 'asalusul as name'])->orderByRaw('kategori, asalusul ASC')->get(), true)
        ]);
    }
    public function masterKondisi()
    {
        return response()->json([
            'html_kondisi' => dataToOption(DB::table('masterkondisi')->select(DB::raw('kodekondisi as id, kondisi as name'))->orderBy('kodekondisi')->get()),
        ]);
    }
}

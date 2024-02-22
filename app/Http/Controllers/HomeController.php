<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //

    public function index()
    {
        $organisasi = DB::table('masterorganisasi')->select(
            'kodeurusan',
            'kodesuburusan',
            'kodesubsuburusan',
            'kodeorganisasi',
            'kodesuborganisasi',
            'kodeunit',
            'kodesubunit',
            'kodesubsubunit',
            'organisasi'
        )->where('kodesuburusan', 0)->get()->toArray();
        return view('layout.home', compact('organisasi'));
    }
}

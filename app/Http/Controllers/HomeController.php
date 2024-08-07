<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        if (session('app') == 'aset') {
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
            if (session('organisasi')) {
                $copied = clone session('organisasi');
                unset($copied->wajibsusut, $copied->organisasi, $copied->tahunorganisasi);
                $copied->tahunorganisasi = env('TAHUN_APLIKASI');
                $countBaNow = DB::table('bap')
                    ->where((array) $copied)->groupByRAW("date_part('month', tanggalbap)")->count();
                $copied->tahunorganisasi = intval(env('TAHUN_APLIKASI')) - 1;
                $countBaPast = DB::table('bap')
                    ->where((array) $copied)->groupByRAW("date_part('month', tanggalbap)")->count();
            } else {
                $countBaNow = 0;
                $countBaPast = 0;
            }

            return view('layout.home', compact('organisasi', 'countBaNow', 'countBaPast'));
        } elseif (session('app') == 'ssh') {
            $kelompok = DB::table('_kelompok_ssh')->selectRaw('kelompok as name, json_build_array(1) as data')->get();

            return view('layout.ssh.home', compact('kelompok'));
        } else {
            return redirect()->route('select-application');
        }
    }

    public function selectApplication()
    {
        return view('layout.app-selection');
    }

    public function chooseApplication(Request $request)
    {
        $request->session()->put('app', $request->app);

        return redirect()->route('home');
    }
}

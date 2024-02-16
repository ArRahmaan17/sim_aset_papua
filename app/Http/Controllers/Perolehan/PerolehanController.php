<?php

namespace App\Http\Controllers\Perolehan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerolehanController extends Controller
{
    public function index()
    {
        $dataMaster = DB::table('masterbarang')->where('kodesubsub', '<>', 0)->get();
        return view('layout.perolehan.index', compact('dataMaster'));
    }
}

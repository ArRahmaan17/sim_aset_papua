<?php

namespace App\Http\Controllers\Perolehan;

use App\Http\Controllers\Controller;
use App\Models\Bap;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerolehanSP2DController extends Controller
{
    public function index()
    {
        $dataMaster = DB::table('masterbarang')->where('kodesubsub', '<>', 0)->get();
        $dataPerogramSP2D = DB::table('sp2d')->selectRaw('nuprgrm as id, nmprgrm as name')
            ->where('nuprgrm', '<>', null)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nuprgrm',
                'nmprgrm'
            )
            ->get();
        $dataBap = Bap::getAllOrganizationBaps();
        return view('layout.perolehansp2d.index', compact('dataMaster', 'dataBap', 'dataPerogramSP2D'));
    }
    public function getKegiatan($idProgram)
    {
        $dataPerogramSP2D = DB::table('sp2d')->selectRaw('nukegunit as id, concat(nukegunit," - ",nmkegunit) as name')
            ->where('nuprgrm', $idProgram)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nukegunit',
                'nmkegunit'
            )
            ->get();
        $dataPerogramSP2D = dataToOption($dataPerogramSP2D);
        return response()->json(['message' => 'Semua Data Kegiatan', 'data' => $dataPerogramSP2D]);
    }
    public function getRekening($idProgram)
    {
        $dataRekeningSP2D = DB::table('sp2d')->select(
            'nosp2d',
            'tglsp2d',
            'kdper',
            'nmper',
            'nilai',
            'keperluan'
        )
            ->where('nukegunit', $idProgram)
            ->where('nmunit', session('organisasi')->organisasi)
            ->groupBy(
                'nosp2d',
                'tglsp2d',
                'kdper',
                'nmper',
                'nilai',
                'keperluan'
            )
            ->get();
        return response()->json(['message' => 'Semua Data Rekening', 'data' => $dataRekeningSP2D]);
    }
}

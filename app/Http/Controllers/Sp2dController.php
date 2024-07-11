<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Sp2dController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.sp2d.index');
    }

    public function dataTable(Request $request)
    {
        $totalFiltered = DB::table('anggaran.sp2d as p')
            ->selectRaw(session('app') == 'aset' ? 'p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun' : 'p.kdper, p.nmper')
            ->groupByRaw(session('app') == 'aset' ? 'nukegunit, nosp2d, tglsp2d, kdunit, nmunit, keperluan, nilai, tahun, nmkegunit, nuprgrm, nmunit, kdper' : 'p.kdper, p.nmper')
            ->get();
        $totalFiltered = count($totalFiltered);
        if (empty($request['search']['value'])) {
            $assets = DB::table('anggaran.sp2d as p')
                ->selectRaw(session('app') == 'aset' ? 'p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun' : 'p.kdper, p.nmper');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw(
                    session('app') == 'aset' ? 'nukegunit,
                    nmkegunit,
                    nuprgrm,
                    nmunit ' : 'kdper, nmper '.$request['order'][0]['dir']
                );
            }
            $assets = $assets->groupByRaw(session('app') == 'aset' ? 'nukegunit, nosp2d, tglsp2d, kdunit, nmunit, keperluan, nilai, tahun, nmkegunit, nuprgrm, nmunit, kdper' : 'p.kdper, p.nmper')->get();
        } else {
            $assets = DB::table('anggaran.sp2d as p')
                ->selectRaw((session('app') == 'aset') ? 'p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun' : 'p.kdper, p.nmper');
            if (preg_match_all('/[0-9]+$/', $request['search']['value'])) {
                $assets->where('nilai', 'like', '%'.$request['search']['value'].'%');
            } else {
                $assets->where('nosp2d', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('tglsp2d', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('kdunit', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('nmunit', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('tahun', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('keperluan', 'like', '%'.$request['search']['value'].'%');
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw(
                    session('app') == 'aset' ? 'nukegunit,
                    nmkegunit,
                    nuprgrm,
                    nmunit ' : 'kdper, nmper '.$request['order'][0]['dir']
                );
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->groupByRaw((session('app') == 'aset') ? 'nukegunit, nosp2d, tglsp2d, kdunit, nmunit, keperluan, nilai, tahun, nmkegunit, nuprgrm, nmunit, kdper' : 'p.kdper, p.nmper')->get();

            $totalFiltered = DB::table('anggaran.sp2d as p')
                ->selectRaw((session('app') == 'aset') ? 'p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun' : 'p.kdper, p.nmper');
            if (preg_match_all('/[0-9]+$/', $request['search']['value'])) {
                $totalFiltered->where('nilai', 'like', '%'.$request['search']['value'].'%');
            } else {
                $totalFiltered->where('nosp2d', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('tglsp2d', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('kdunit', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('nmunit', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('tahun', 'like', '%'.$request['search']['value'].'%')
                    ->orWhere('keperluan', 'like', '%'.$request['search']['value'].'%');
            }

            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw(
                    session('app') == 'aset' ? 'nukegunit,
                    nmkegunit,
                    nuprgrm,
                    nmunit ' : 'kdper, nmper '.$request['order'][0]['dir']
                );
            }
            $totalFiltered = $totalFiltered->groupByRaw((session('app') == 'aset') ? 'nukegunit, nosp2d, tglsp2d, kdunit, nmunit, keperluan, nilai, tahun, nmkegunit, nuprgrm, nmunit' : 'kdper, nmper')->get();
            $totalFiltered = count($totalFiltered);
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            if (session('app') == 'aset') {
                $row = [];
                $row[] = intval($request['start']) + ($index + 1);
                $row[] = ''.$item->nosp2d;
                $row[] = ''.$item->tglsp2d;
                $row[] = ''.$item->kdunit;
                $row[] = ''.$item->nmunit;
                $row[] = ''.$item->keperluan;
                $row[] = 'Rp. '.number_format($item->nilaisp2d);
                $row[] = ''.$item->tahun;
                $row[] = $item->nosp2d.'+'.$item->tglsp2d.'+'.$item->kdunit.'+'.$item->nmunit.'+'.$item->keperluan.'+'.$item->nilaisp2d.'+'.$item->tahun;
                $dataFiltered[] = $row;
            } else {
                $row = [];
                $row[] = intval($request['start']) + ($index + 1);
                $row[] = ''.$item->kdper;
                $row[] = ''.$item->nmper;
                $row[] = '<button class="btn btn-warning edit"><i class="bx bx-pencil" ></i>Edit</button><button class="btn btn-danger delete"><i class="bx bxs-trash-alt"></i>Hapus</button>';
                $row[] = $item->kdper.'+'.$item->nmper;
                $dataFiltered[] = $row;
            }
        }
        $response = [
            'draw' => $request['draw'],
            'recordsFiltered' => $totalFiltered,
            'recordsTotal' => count($dataFiltered),
            'aaData' => $dataFiltered,
        ];

        return Response()->json($response, 200);
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

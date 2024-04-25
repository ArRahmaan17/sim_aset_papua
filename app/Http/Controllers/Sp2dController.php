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
        $totalFiltered = DB::table('sp2d as p')
            ->selectRaw('p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun')
            ->groupBy(
                'nukegunit',
                'nosp2d',
                'tglsp2d',
                'kdunit',
                'nmunit',
                'keperluan',
                'nilai',
                'tahun',
                'nmkegunit',
                'nuprgrm',
                'nmunit'
            )
            ->get();
        $totalFiltered = count($totalFiltered);
        if (empty($request['search']['value'])) {
            $assets = DB::table('sp2d as p')
                ->selectRaw('p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw(
                    'nukegunit,
                    nmkegunit,
                    nuprgrm,
                    nmunit ' . $request['order'][0]['dir']
                );
            }
            $assets = $assets->groupBy(
                'nukegunit',
                'nosp2d',
                'tglsp2d',
                'kdunit',
                'nmunit',
                'keperluan',
                'nilai',
                'tahun',
                'nmkegunit',
                'nuprgrm',
                'nmunit'
            )->get();
        } else {
            $assets = DB::table('sp2d as p')
                ->selectRaw('p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun')
                ->where('nosp2d', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('tglsp2d', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kdunit', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('nmunit', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('tahun', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('keperluan', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw(
                    'nukegunit,nmkegunit,nuprgrm,nmunit ' . $request['order'][0]['dir']
                );
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->groupByRaw("nukegunit, nosp2d, tglsp2d, kdunit, nmunit, keperluan, nilai, tahun, nmkegunit, nuprgrm, nmunit HAVING (CASE WHEN '" . $request['search']['value'] . "' REGEXP '^[0-9]+$' THEN SUM(nilai) like '%" . $request['search']['value'] . "%' else true = true END)")->get();

            $totalFiltered = DB::table('sp2d as p')
                ->selectRaw('p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun')
                ->selectRaw('p.nosp2d ,tglsp2d, kdunit, nmunit, keperluan, SUM(nilai) as nilaisp2d, tahun')
                ->where('nosp2d', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('tglsp2d', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kdunit', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('nmunit', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('tahun', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('keperluan', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw(
                    'nukegunit,nmkegunit,nuprgrm,nmunit ' . $request['order'][0]['dir']
                );
            }
            $totalFiltered = $totalFiltered->groupByRaw("nukegunit, nosp2d, tglsp2d, kdunit, nmunit, keperluan, nilai, tahun, nmkegunit, nuprgrm, nmunit HAVING (CASE WHEN '" . $request['search']['value'] . "' REGEXP '^[0-9]+$' THEN SUM(nilai) like '%" . $request['search']['value'] . "%' else true = true END)")->get();
            $totalFiltered = count($totalFiltered);
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = intval($request['start']) + ($index + 1);
            $row[] = '' . $item->nosp2d;
            $row[] = '' . $item->tglsp2d;
            $row[] = '' . $item->kdunit;
            $row[] = '' . $item->nmunit;
            $row[] = '' . $item->keperluan;
            $row[] = 'Rp. ' . number_format($item->nilaisp2d);
            $row[] = '' . $item->tahun;
            $row[] = $item->nosp2d . '+' . $item->tglsp2d . '+' . $item->kdunit . '+' . $item->nmunit . '+' . $item->keperluan . '+' . $item->nilaisp2d . '+' . $item->tahun;
            $dataFiltered[] = $row;
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

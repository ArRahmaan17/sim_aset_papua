<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LokasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.lokasi.index');
    }


    public function dataTable(Request $request)
    {
        $totalData = DB::table('masterlokasi')
            ->orderBy('kodelokasi', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('masterlokasi')
                ->select('*');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('nama ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('masterlokasi')->select('*')
                ->where('nama', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('nama ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('masterlokasi')
                ->select('*')
                ->where('nama', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('nama ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $index + 1;
            $row[] = "" . $item->nama;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodelokasi;
            $dataFiltered[] = $row;
        }
        $response = [
            'draw' => $request['draw'],
            'recordsFiltered' => $totalFiltered,
            'recordsTotal' => count($dataFiltered),
            'aaData' => $dataFiltered
        ];

        return Response()->json($response, 200);
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

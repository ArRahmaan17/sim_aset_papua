<?php

namespace App\Http\Controllers\ssh\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsulanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.ssh.usulan.index');
    }
    public function dataTable(Request $request)
    {
        $totalData = DB::table('usulan_ssh')
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('usulan_ssh')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('tahun ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('usulan_ssh')->select('*')
                ->where('tahun', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('tahun ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('usulan_ssh')->select('*')
                ->where('tahun', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('tahun ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = null;
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->tahun;
            $row[] = $item->induk_perubahan == '1' ? 'Induk' : 'Perubahan';
            $row[] = empty($item->ssd_dokumen) ? "<small class='text-sm'>Pakta Tidak Tersedia</small><br><small class='pb-1'><u>edit</u> untuk menambahkan pakta</small>" : "<button class='btn btn-icon btn-success print'><i class='bx bxs-printer' ></i></button>";
            $row[] = "<button class='btn btn-icon btn-outline-warning mx-1 edit' ><i class='bx bxs-pencil'></i></button><button class='btn btn-icon btn-outline-danger mx-1 delete'><i class='bx bxs-trash-alt' ></i></button><button class='btn btn-icon btn-outline-info mx-1 send'><i class='bx bxs-paper-plane'></i></button>";
            $row[] = DB::table('_data_ssh')->where('id_usulan', $item->id)->get();
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

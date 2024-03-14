<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MasaManfaatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = DB::table('mastermasamanfaat')
            ->select(DB::raw('count(kodemasamanfaat) as jumlah_masa'), DB::raw("(select count(kodemasterbarang) from masterbarang where kodesubsub <> 0) as jumlah_barang"))->where('kodesubsub', '<>', 0)->first();
        return view('layout.masamanfaat.index', compact('data'));
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('mastermasamanfaat')
            ->where('masamanfaat', '<>', NULL)
            ->orderBy('kodemasamanfaat', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('mastermasamanfaat')->select('*')
                ->limit($request['length'])
                ->offset($request['start'])
                ->where('masamanfaat', '<>', NULL);
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('mastermasamanfaat')->select('*')
                ->where('urai', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kodegolongan', 'like', '%' . $request['search']['value'] . '%')
                ->where('masamanfaat', '<>', NULL);
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub ' . $request['order'][0]['dir']);
            }
            $assets = $assets->limit($request['length'])
                ->offset($request['start'])
                ->get();

            $totalFiltered = DB::table('mastermasamanfaat')->select('*')
                ->where('urai', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere(
                    'kodegolongan',
                    'like',
                    '%' . $request['search']['value'] . '%'
                )
                ->where('masamanfaat', '<>', NULL);
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $index + 1;
            $row[] = "" . $item->kodegolongan . "." . $item->kodebidang . "." . $item->kodekelompok . "." . $item->kodesub . "." . $item->kodesubsub . " " . $item->urai;
            $row[] = $item->masamanfaat;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->kodemasamanfaat;
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


    public function belumMasaManfaat(Request $request)
    {
        $totalData = DB::table('mastermasamanfaat')
            ->whereRaw("not exists (select kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub from masterbarang where kodesubsub <> 0)")
            ->orderBy('kodemasamanfaat', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('mastermasamanfaat')->select('*')
                ->limit($request['length'])
                ->offset($request['start'])
                ->whereRaw("not exists (select kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub from masterbarang where kodesubsub <> 0)");
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('mastermasamanfaat')->select('*')
                ->where('urai', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('kodegolongan', 'like', '%' . $request['search']['value'] . '%')
                ->whereRaw("not exists (select kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub from masterbarang where kodesubsub <> 0)");
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub ' . $request['order'][0]['dir']);
            }
            $assets = $assets->limit($request['length'])
                ->offset($request['start'])
                ->get();

            $totalFiltered = DB::table('mastermasamanfaat')->select('*')
                ->whereRaw("not exists (select kodegolongan, kodebidang, kodekelompok, kodesub, kodesubsub from masterbarang where kodesubsub <> 0)")
                ->orWhere(function (Builder $query) use ($request) {
                    $query->where('urai', 'like', '%' . $request['search']['value'] . '%')
                        ->where('kodegolongan', 'like', '%' . $request['search']['value'] . '%');
                });
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $index + 1;
            $row[] = "" . $item->kodegolongan . "." . $item->kodebidang . "." . $item->kodekelompok . "." . $item->kodesub . "." . $item->kodesubsub . " " . $item->urai;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate(['kode' => 'required', 'masamanfaat' => 'required']);
            $kode = explode(" ", $request->kode);
            $kode = explode('.', $kode[0]);
            $count = DB::table('mastermasamanfaat')->where([
                'kodegolongan' => $kode[0],
                'kodebidang' => $kode[1],
                'kodekelompok' => $kode[2],
                'kodesub' => $kode[3],
                'kodesubsub' => $kode[4],
            ])->count();
            if ($count != 0) {
                throw new Exception("Masa Manfaat Barang tersebut telah di tambahkan", 422);
            }
            $barang = DB::table('masterbarang')->where([
                'kodegolongan' => $kode[0],
                'kodebidang' => $kode[1],
                'kodekelompok' => $kode[2],
                'kodesub' => $kode[3],
                'kodesubsub' => $kode[4],
            ])->first();
            DB::table('mastermasamanfaat')->insert([
                'kodegolongan' => $kode[0],
                'kodebidang' => $kode[1],
                'kodekelompok' => $kode[2],
                'kodesub' => $kode[3],
                'kodesubsub' => $kode[4],
                'urai' => $barang->urai,
                'masamanfaaat' => $request->masamanfaat,
            ]);
            DB::commit();
            $status = 200;
            $response = ['message' => 'masa manfaat barang berhasil di tambahkan'];
        } catch (Exception $th) {
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'masa manfaat barang gagal di tambahkan'];
            if ($th->getCode() == 422) {
                $response = ['message' => $th->getMessage()];
            }
        }
        return response()->json($response, $status);
    }
    public function update($id, Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate(['masamanfaat' => 'required']);
            $count = DB::table('mastermasamanfaat')->where('kodemasamanfaat', $id)->count();
            if ($count == 0) {
                throw new Exception("Masa Manfaat Barang tidak di temukan", 422);
            }
            DB::table('mastermasamanfaat')
                ->where('kodemasamanfaat', $id)
                ->update([
                    'masamanfaat' => $request->masamanfaaat
                ]);
            $status = 200;
            $response = ['message' => 'masa manfaat barang berhasil di perbarui'];
            DB::rollBack();
        } catch (Exception $th) {
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'masa manfaat barang gagal di perbarui'];
            if ($th->getCode() == 422) {
                $response = ['message' => $th->getMessage()];
            }
        }
        return response()->json($response, $status);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('mastermasamanfaat')
            ->where('masamanfaat', '<>', NULL)
            ->where('kodemasamanfaat', $id)
            ->first();
        if ($data) {
            $status = 200;
            $message = ['message' => "data master masa manfaat berhasil di temukan", 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => "data master masa manfaat gagal di temukan", 'data' => $data];
        }
        return response()->json($message, $status);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('mastermasamanfaat')->where('kodemasamanfaat', $id)->delete();
            // DB::commit();
            $data = DB::table('mastermasamanfaat')->get()->toArray();
            $message = ['message' => 'berhasil menghapus data master masa manfaat', 'data' => $data];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data master masa manfaat'];
            $status = 422;
        }
        return response()->json($message, $status);
    }
}

<?php

namespace App\Http\Controllers\ssh\Main;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KontrakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('layout.ssh.kontrak.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('kontrak')
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('kontrak')
                ->select('*');

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('no_kontrak ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('kontrak')->select('*')
                ->where('no_kontrak', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('nm_kontrak', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('tahun', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('t_kontrak', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('no_kontrak ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('kontrak')->select('*')
                ->where('no_kontrak', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('nm_kontrak', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('tahun', 'like', '%' . $request['search']['value'] . '%')
                ->orWhere('t_kontrak', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('no_kontrak ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->no_kontrak;
            $row[] = $item->nm_kontrak;
            $row[] = $item->penyedia_id;
            $row[] = $item->tahun;
            $row[] = convertNumericDateToAlphabetical($item->t_kontrak);
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->id;
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

    public function dataTableRincian(Request $request)
    {
        $totalData = DB::table('kontrak_detail AS kd')
            ->orderBy('id', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('kontrak_detail')
                ->where('id_kontrak', $request['id_kontrak'])
                ->select(
                    '*',
                    DB::raw("(select urai
                        from masterbarang 
                        where split_part(kontrak_detail.kode, '.', 1)::int = kodegolongan
                        and split_part(kontrak_detail.kode, '.', 2)::int = kodebidang
                        and split_part(kontrak_detail.kode, '.', 3)::int = kodekelompok
                        and split_part(kontrak_detail.kode, '.', 4)::int = kodesub
                        and split_part(kontrak_detail.kode, '.', 5)::int = kodesubsub
                        ) AS jenis_aset"),
                    DB::raw("(case
                        when split_part(kontrak_detail.kode, '.', 1)::int = 131 then 'A'
                        when split_part(kontrak_detail.kode, '.', 1)::int = 132 then 'B'
                        when split_part(kontrak_detail.kode, '.', 1)::int = 133 then 'C'
                        when split_part(kontrak_detail.kode, '.', 1)::int = 134 then 'D'
                        when split_part(kontrak_detail.kode, '.', 1)::int = 135 then 'E'
                        when split_part(kontrak_detail.kode, '.', 1)::int = 136 then 'F'
                        else ''
                        end
                    ) AS kib")
                );

            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kode ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('kontrak_detail')->select(
                '*',
                DB::raw("(select urai
                    from masterbarang 
                    where split_part(kontrak_detail.kode, '.', 1)::int = kodegolongan
                    and split_part(kontrak_detail.kode, '.', 2)::int = kodebidang
                    and split_part(kontrak_detail.kode, '.', 3)::int = kodekelompok
                    and split_part(kontrak_detail.kode, '.', 4)::int = kodesub
                    and split_part(kontrak_detail.kode, '.', 5)::int = kodesubsub
                    ) AS jenis_aset"),
                DB::raw("(case
                    when split_part(kontrak_detail.kode, '.', 1)::int = 131 then 'A'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 132 then 'B'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 133 then 'C'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 134 then 'D'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 135 then 'E'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 136 then 'F'
                    else ''
                    end
                ) AS kib")
            )
                ->where('id_kontrak', $request['id_kontrak'])
                ->where(function ($q) use ($request) {
                    $q->where('jenis_aset', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('kode', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('register', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('asal', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('harga', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('kib', 'like', '%' . $request['search']['value'] . '%');
                });
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('kode ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('kontrak_detail')->select(
                '*',
                DB::raw("(select urai
                    from masterbarang 
                    where split_part(kontrak_detail.kode, '.', 1)::int = kodegolongan
                    and split_part(kontrak_detail.kode, '.', 2)::int = kodebidang
                    and split_part(kontrak_detail.kode, '.', 3)::int = kodekelompok
                    and split_part(kontrak_detail.kode, '.', 4)::int = kodesub
                    and split_part(kontrak_detail.kode, '.', 5)::int = kodesubsub
                    ) AS jenis_aset"),
                DB::raw("(case
                    when split_part(kontrak_detail.kode, '.', 1)::int = 131 then 'A'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 132 then 'B'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 133 then 'C'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 134 then 'D'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 135 then 'E'
                    when split_part(kontrak_detail.kode, '.', 1)::int = 136 then 'F'
                    else ''
                    end
                ) AS kib")
            )
                ->where('id_kontrak', $request['id_kontrak'])
                ->where(function ($q) use ($request) {
                    $q->where('jenis_aset', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('kode', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('register', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('asal', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('harga', 'like', '%' . $request['search']['value'] . '%')
                        ->orWhere('kib', 'like', '%' . $request['search']['value'] . '%');
                });
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('kode ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = $item->jenis_aset;
            $row[] = $item->kode;
            $row[] = $item->register;
            $row[] = $item->asal;
            $row[] = $item->harga;
            $row[] = $item->kib;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->id;
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

    public function kelompok()
    {
        $data = DB::table('masterbarang')
            ->select(
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id"),
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' ', urai) as name"),
            )
            ->whereNot('kodegolongan', 0)
            ->whereRaw('kodegolongan % 10 = 0')
            ->whereRaw('kodegolongan % 100 <> 0')
            ->where('kodebidang', 0)
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    public function jenis(Request $request)
    {
        $prev = explode('.', $request->prev)[0];
        $kelompok = substr($prev, 0, 2);
        $data = DB::table('masterbarang')
            ->select(
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id"),
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' ', urai) as name"),
            )
            ->whereNot('kodegolongan', 0)
            ->whereRaw('kodegolongan % 10 <> 0')
            ->where('kodebidang', 0)
            ->whereRaw("LEFT(CAST(kodegolongan AS varchar(3)), 2) = '$kelompok'")
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    public function objek(Request $request)
    {
        $prev = explode('.', $request->prev);
        $kelompok = (int) $prev[0];
        $data = DB::table('masterbarang')
            ->select(
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id"),
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' ', urai) as name"),
            )
            ->whereNot('kodebidang', 0)
            ->where('kodekelompok', 0)
            ->where('kodegolongan', $kelompok)
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    public function rincian(Request $request)
    {
        $prev = explode('.', $request->prev);
        $kelompok = (int) $prev[0];
        $jenis = (int) $prev[1];
        $data = DB::table('masterbarang')
            ->select(
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id"),
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' ', urai) as name"),
            )
            ->whereNot('kodekelompok', 0)
            ->where('kodesub', 0)
            ->where('kodegolongan', $kelompok)
            ->where('kodebidang', $jenis)
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    public function subrincian(Request $request)
    {
        $prev = explode('.', $request->prev);
        $kelompok = (int) $prev[0];
        $jenis = (int) $prev[1];
        $objek = (int) $prev[2];
        $data = DB::table('masterbarang')
            ->select(
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id"),
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' ', urai) as name"),
            )
            ->whereNot('kodesub', 0)
            ->where('kodesubsub', 0)
            ->where('kodegolongan', $kelompok)
            ->where('kodebidang', $jenis)
            ->where('kodekelompok', $objek)
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    public function uraian(Request $request)
    {
        $prev = explode('.', $request->prev);
        $kelompok = (int) $prev[0];
        $jenis = (int) $prev[1];
        $objek = (int) $prev[2];
        $rincian = (int) $prev[3];
        $data = DB::table('masterbarang')
            ->select(
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub) as id"),
                DB::raw("CONCAT(kodegolongan, '.', kodebidang, '.', kodekelompok, '.', kodesub, '.', kodesubsub, ' ', urai) as name"),
            )
            ->whereNot('kodesubsub', 0)
            ->where('kodegolongan', $kelompok)
            ->where('kodebidang', $jenis)
            ->where('kodekelompok', $objek)
            ->where('kodesub', $rincian)
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'master barang berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->except('_token', 'id');
        $data['opd'] = 0;
        if (array_key_exists('t_kontrak', $data)) $data['t_kontrak'] = convertAlphabeticalToNumberDate($data['t_kontrak']);
        DB::beginTransaction();
        try {
            DB::table('kontrak')->insert($data);
            DB::commit();
            $data = DB::table('kontrak')->get()->toArray();
            $status = 200;
            $message = ['message' => 'Kontrak berhasil ditambahkan', 'data' => $data];
        } catch (Exception $th) {
            dd($th->getMessage());
            $message = ['message' => 'Kontrak gagal ditambahkan'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
            DB::rollBack();
        }

        return response()->json($message, $status);
    }

    public function storeRincian(Request $request)
    {
        $data = $request->except('_token', 'id');
        $data = $data['detail'];
        $data['id_kontrak'] = $request['id'];
        if (array_key_exists('tgl_sertifikat', $data)) $data['tgl_sertifikat'] = convertAlphabeticalToNumberDate($data['tgl_sertifikat']);
        if (array_key_exists('tgl_dokumen', $data)) $data['tgl_dokumen'] = convertAlphabeticalToNumberDate($data['tgl_dokumen']);
        unset($data['jumlahbarang']);

        DB::beginTransaction();
        try {
            for ($i = 0; $i < $request['detail']['jumlahbarang']; $i++) {
                $data['register'] = $this->generateRegister($data['id_kontrak'], $data['kode']);
                DB::table('kontrak_detail')->insert($data);
                DB::commit();
            }
            $data = DB::table('kontrak_detail')->get()->toArray();
            $status = 200;
            $message = ['message' => 'Kontrak berhasil ditambahkan', 'data' => $data];
        } catch (Exception $th) {
            dd($th->getMessage());
            $message = ['message' => 'Kontrak gagal ditambahkan'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
            DB::rollBack();
        }

        return response()->json($message, $status);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('kontrak')->where('id', $id)->first();
        if (property_exists($data, 't_kontrak')) $data->t_kontrak = convertNumericDateToAlphabetical($data->t_kontrak);
        if ($data) {
            $status = 200;
            $message = ['message' => 'data kontrak berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data kontrak gagal di temukan', 'data' => $data];
        }

        return response()->json($message, $status);
    }

    public function showRincian(string $id)
    {
        $data = DB::table('kontrak_detail')->where('id', $id)->first();
        if (property_exists($data, 'tgl_sertifikat')) $data->tgl_sertifikat = convertNumericDateToAlphabetical($data->tgl_sertifikat);
        if (property_exists($data, 'tgl_dokumen')) $data->tgl_dokumen = convertNumericDateToAlphabetical($data->tgl_dokumen);

        if ($data) {
            $status = 200;
            $message = ['message' => 'data kontrak berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data kontrak gagal di temukan', 'data' => $data];
        }

        return response()->json($message, $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->except('_token', 'id');
        $data['opd'] = 0;
        if (array_key_exists('t_kontrak', $data)) $data['t_kontrak'] = convertAlphabeticalToNumberDate($data['t_kontrak']);

        DB::beginTransaction();
        try {
            DB::table('kontrak')->where('id', $id)->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Kontrak berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Kontrak gagal diubah'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
            DB::rollBack();
        }

        return response()->json($message, $status);
    }

    public function updateRincian(Request $request, string $id)
    {
        $data = $request->except('_token', 'id');
        $data = $data['detail'];
        unset($data['id_rincian']);
        if (array_key_exists('tgl_sertifikat', $data)) $data['tgl_sertifikat'] = convertAlphabeticalToNumberDate($data['tgl_sertifikat']);
        if (array_key_exists('tgl_dokumen', $data)) $data['tgl_dokumen'] = convertAlphabeticalToNumberDate($data['tgl_dokumen']);
        unset($data['jumlahbarang']);

        DB::beginTransaction();
        try {
            DB::table('kontrak_detail')->where('id', $id)->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Kontrak berhasil diubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Kontrak gagal diubah'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
            DB::rollBack();
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
            DB::table('kontrak')->where('id', $id)->delete();
            DB::table('kontrak_detail')->where('id_kontrak', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data kontrak'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data kontrak'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }

        return response()->json($message, $status);
    }

    public function destroyRincian(string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('kontrak_detail')->where('id', $id)->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus data kontrak'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus data kontrak'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }

        return response()->json($message, $status);
    }

    public function generateRegister($id_kontrak, $kode)
    {
        $register = DB::table('kontrak_detail')
            ->select('register')
            ->where('id_kontrak', $id_kontrak)
            ->where('kode', $kode)
            ->get();

        if ($register->count() == 0) {
            $reg = '000000';
        } else {
            $reg = $register->max('register');
        }

        $urut = (int) substr($reg, 1, 6);
        $urut++;
        $regis = sprintf("%06s", $urut);

        return $regis;
    }

    public function hak()
    {
        $data = DB::table('jns_hak')
            ->select(
                'id',
                'hak AS name'
            )
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'hak berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'hak berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }

    public function statusTanah()
    {
        $data = DB::table('status_tanah')
            ->select(
                'id',
                'status AS name'
            )
            ->get();
        if (count($data) != 0) {
            $statuscode = 200;
            $response = ['message' => 'status tanah berhasil di temukan', 'data' => dataToOption($data)];
        } else {
            $statuscode = 422;
            $response = ['message' => 'status tanah berhasil di temukan', 'data' => dataToOption($data)];
        }

        return response()->json($response, $statuscode);
    }
}

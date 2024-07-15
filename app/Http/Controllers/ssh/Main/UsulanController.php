<?php

namespace App\Http\Controllers\ssh\Main;

ob_start();

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

    public function previewPakta($file_path)
    {
        return response()->file(
            storage_path('app/public/pakta/' . $file_path)
        );
    }

    public function downloadPakta()
    {
        return response()->download(
            public_path('ssh/pakta/SURAT-PERNYATAAN-USULAN.docx')
        );
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

            $row[] = empty($item->ssd_dokumen) ? "<small class='text-sm'>Pakta Tidak Tersedia</small><br><small class='pb-1'><u>edit</u> untuk menambahkan pakta</small>" : "<a class='btn btn-icon btn-success text-white' href='" . route('usulan.preview', $item->ssd_dokumen) . "' target='_blank'><i class='bx bxs-printer' ></i></a>";
            if ($item->status == '0') {
                $row[] = "<button class='btn btn-icon btn-warning mx-1 edit' ><i class='bx bxs-pencil'></i></button><button class='btn btn-icon btn-danger mx-1 delete'><i class='bx bxs-trash-alt' ></i></button><button class='btn btn-icon btn-info mx-1 send'><i class='bx bxs-paper-plane'></i></button>";
            } elseif ($item->status == '1') {
                if (getRole() == 'Developer' || getRole() == 'User Aset') {
                    $row[] = 'Butuh Validasi';
                } else {
                    $row[] = 'Terkirim';
                }
            } elseif ($item->status == '2') {
                $row[] = 'Diterima';
            } elseif ($item->status == '3') {
                $row[] = "<button class='btn btn-outline-warning btn-sm edit'>Perbarui Usulan</button><button class='btn btn-outline-danger btn-sm delete'>Hapus Usulan</button><button class='btn btn-outline-info btn-sm send'>Kirim Ulang</button>";
            }
            $row[] = DB::table('_data_ssh as ds')->select('ds.*', 'ms.satuan', 'mb.urai', DB::raw('(select
                        json_agg(json_build_array(nmper)) as rekening
                    from
                        anggaran.sp2d sd
                    where
                        sd.kdper in (
                        select
                            jsonb_array_elements_text(ds.rekening)
                        from
                            "_data_ssh" ds
                    )) as rekening'))
                ->join('mastersatuan as ms', 'ds.id_satuan', '=', 'ms.kodesatuan')
                ->join('masterbarang as mb', 'ds.id_kode', '=', DB::raw("concat(mb.kodegolongan,'.',mb.kodebidang,'.',mb.kodekelompok,'.',mb.kodesub,'.',mb.kodesubsub)"))
                ->where('id_usulan', $item->id)->get();
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if ($request->has('ssd_dokumen')) {
                $ssd_dokumen = 'pakta_' . rand(0, 1000) . '_' . date('y-m-d') . '.pdf';
                file_put_contents(storage_path('app/public/pakta/' . $ssd_dokumen), base64_decode($request->ssd_dokumen));
                $id_usulan = DB::table('usulan_ssh')->insertGetId(
                    array_merge($request->except('detail', '_token', 'ssd_dokumen'), ['ssd_dokumen' => $ssd_dokumen, 'status' => '0', 'id_opd' => '0']),
                    'id'
                );
            } else {
                $ssd_dokumen = null;
            }
            $detail = $request->detail;
            foreach ($detail as $key => $value) {
                $detail[$key]['id_usulan'] = $id_usulan;
                $detail[$key]['id_kelompok'] = 1;
                $detail[$key]['status'] = '0';
                $detail[$key]['rekening'] = json_encode($detail[$key]['rekening']);
            }
            DB::table('_data_ssh')->insert($detail);
            DB::commit();
            $status = 200;
            $response = ['message' => 'usulan berhasil ditambahkan'];
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            $status = 502;
            $response = ['message' => 'usulan gagal ditambahkan'];
        }

        return response()->json($response, $status);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = DB::table('usulan_ssh as us')
            ->select('us.*', DB::raw("(jsonb_agg(json_build_array((
                        select
                            jsonb_agg(jsonb_build_object('id_detail',id,'spesifikasi',
                            spesifikasi,
                            'id_satuan',
                            id_satuan,
                            'id_kode',
                            id_kode,
                            'harga',
                            harga,
                            'uraian',
                            uraian, 'tkdn', tkdn, 'rekening', 		(
                            select
                                json_agg(json_build_array(kdper))
                            from
                                anggaran.sp2d sd
                            where
                                sd.kdper in (
                                select
                                    jsonb_array_elements_text(ds.rekening)
                                from
                                    _data_ssh ds where id_usulan = " . $id . '
                        ))))
                        from
                            _data_ssh where id_usulan = ' . $id . 'group by id_usulan ))) ) as detail'))
            ->join('_data_ssh as ds', 'ds.id_usulan', '=', 'us.id')
            ->where('us.id', $id)->groupBy('us.id')->first();
        $data->detail = collect(json_decode($data->detail))
            ->flatten()
            ->toArray();
        $data->detail = removeDuplicate((array) $data->detail);
        foreach ($data->detail as $key => $data_usulan) {
            $data->detail[$key]->rekening = collect($data->detail[$key]->rekening)->flatten()->toArray();
            $data->detail[$key]->rekening = removeDuplicate((array) $data->detail[$key]->rekening);
        }
        if ($data) {
            $status = 200;
            $response = ['message' => 'data usulan di temukan', 'data' => $data];
        } else {
            $status = 404;
            $response = ['message' => 'data usulan tidak di temukan', 'data' => $data];
        }

        return response()->json($response, $status);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $usulan = $request->except('detail', '_token');
            $except = $request->has('ssd_dokumen') ? ['id', 'tahun', '_token', 'induk_perubahan', 'detail.id_detail',  'ssd_dokumen'] : ['id', 'tahun', '_token', 'induk_perubahan', 'detail.id_detail'];
            $details = $request->except($except);
            $details = $details['detail'];
            if ($request->has('ssd_dokumen')) {
                $ssd_dokumen = 'pakta_' . rand(0, 1000) . '_' . date('y-m-d') . '.pdf';
                file_put_contents(storage_path('app/public/pakta/' . $ssd_dokumen), base64_decode($request->ssd_dokumen));
                $usulan['ssd_dokumen'] = $ssd_dokumen;
            }
            DB::table('usulan_ssh')->where('id', $id)->update($usulan);
            $requestdatakib = array_map(function ($detailUsulan) {
                return intval($detailUsulan['id_detail'] ?? null);
            }, $details);
            $allDetailUsulan = DB::table('_data_ssh')->where('id_usulan', $id)->get()->map(function ($detailUsulan) {
                return $detailUsulan->id;
            })->toArray();
            $removedDetailUsulan = array_merge(array_diff($allDetailUsulan, $requestdatakib), array_diff($requestdatakib, $allDetailUsulan));
            $removedDetailUsulan = array_filter($removedDetailUsulan, function ($kodekib) {
                return $kodekib !== 0;
            });
            if ($removedDetailUsulan !== []) {
                DB::table('_data_ssh')->whereIn('id', $removedDetailUsulan)->delete();
            }
            foreach ($details as $index => $detail) {
                if (isset($detail['id_detail'])) {
                    $data = [
                        'id' => $detail['id_detail'],
                        'tkdn' => $detail['tkdn'],
                        'harga' => $detail['harga'],
                        'uraian' => $detail['uraian'],
                        'id_kode' => $detail['id_kode'],
                        'id_satuan' => $detail['id_satuan'],
                        'spesifikasi' => $detail['spesifikasi'],
                        'spesifikasi' => $detail['spesifikasi'],
                        'rekening' => json_encode($detail['rekening']),
                    ];
                    DB::table('_data_ssh')->where('id', $data['id'])->update($data);
                } else {
                    $data = [
                        'tkdn' => $detail['tkdn'],
                        'id_usulan' => $id,
                        'harga' => $detail['harga'],
                        'uraian' => $detail['uraian'],
                        'id_kode' => $detail['id_kode'],
                        'id_satuan' => $detail['id_satuan'],
                        'spesifikasi' => $detail['spesifikasi'],
                        'spesifikasi' => $detail['spesifikasi'],
                        'status' => 0,
                        'rekening' => json_encode($detail['rekening']),
                    ];
                    DB::table('_data_ssh')->insert($data);
                }
            }
            DB::commit();
            $status = 200;
            $response = ['message' => 'data usulan berhasil di update'];
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'data usulan gagal di update'];
        }

        return response()->json($response, $status);
    }

    public function accept(string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('_data_ssh')->where('id', $id)->update(['status' => '2']);
            $data = DB::table('_data_ssh')->where('id', $id)->first();
            $diterima = DB::table('_data_ssh')->where([
                'status' => '2',
                'id_usulan' => $data->id_usulan,
            ])->count();
            $semua = DB::table('_data_ssh')->where([
                'id_usulan' => $data->id_usulan,
            ])->count();
            if ($semua == $diterima) {
                DB::table('usulan_ssh')->where('id', $data->id_usulan)->update(['status' => $data->status]);
            }
            DB::commit();
            $status = 200;
            $response = ['message' => 'data usulan berhasil di terima'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'data usulan gagal di terima'];
        }

        return response()->json($response, $status);
    }

    public function reject(Request $reqest, string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('_data_ssh')->where('id', $id)->update(['status' => '3', 'keterangan' => $reqest->keterangan]);
            $data = DB::table('_data_ssh')->where('id', $id)->first();
            $semua = DB::table('_data_ssh')->where([
                'id_usulan' => $data->id_usulan,
            ])->count();
            $ditolak = DB::table('_data_ssh')->where([
                'status' => '3',
                'id_usulan' => $data->id_usulan,
            ])->count();
            if ($ditolak == $semua) {
                DB::table('usulan_ssh')->where('id', $data->id_usulan)->update(['status' => $data->status]);
            }
            DB::commit();
            $status = 200;
            $response = ['message' => 'data usulan berhasil di tolak'];
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'data usulan gagal di tolak'];
        }

        return response()->json($response, $status);
    }

    public function send(string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('usulan_ssh')->where('id', $id)->update(['status' => '1']);
            DB::table('_data_ssh')->where('id_usulan', $id)->update(['status' => '1']);
            DB::commit();
            $status = 200;
            $response = ['message' => 'data usulan berhasil di kirim'];
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'data usulan gagal di kirim'];
        }

        return response()->json($response, $status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            if (DB::table('usulan_ssh')->where('id', $id)->where('status', '0')->count() == 1) {
                DB::table('usulan_ssh')->where('id', $id)->where('status', '0')->delete();
                DB::table('_data_ssh')->where('id_usulan', $id)->delete();
            }
            $status = 200;
            $response = ['message' => 'data usulan berhasil di hapus'];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'data usulan gagal di hapus'];
        }

        return response()->json($response, $status);
    }
}

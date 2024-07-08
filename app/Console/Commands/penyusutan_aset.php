<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class penyusutan_aset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:penyusutan-aset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Background for penyusutan';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::beginTransaction();
        try {
            $data = DB::table('kibtransaksi as k')
                ->select('k.kodekib')
                ->whereRaw("date_part('month', tanggalpenyusutan) = date_part('month', CURRENT_TIMESTAMP) and k.tahunorganisasi = (date_part('year', CURRENT_TIMESTAMP)-1) and k.tahunperolehan =' . env('TAHUN_APLIKASI')")
                ->get()
                ->toArray();
            $kodekib = array_column($data, 'kodekib');
            $dataKibAkanSusut = DB::table('kib as k')
                ->select(
                    'k.kodeurusan',
                    'k.kodesuburusan',
                    'k.kodekib',
                    'k.kodeklasifikasi',
                    'k.kodeorganisasi',
                    'k.kodeunit',
                    'k.kodesubunit',
                    'k.tahunorganisasi',
                    'k.uraiorganisasi',
                    'k.kodegolongan',
                    'k.kodebidang',
                    'k.kodekelompok',
                    'k.kodesub',
                    'k.kodesubsub',
                    'k.koderegister',
                    'k.uraibarang',
                    'k.tahunperolehan',
                    'k.nilaiakumulasibarang',
                    'm.masamanfaat',
                    'p.manfaat',
                    'p.tahun',
                )->join(
                    'mastermasamanfaat as m',
                    [
                        ['m.kodegolongan', 'k.kodegolongan'],
                        ['m.kodebidang', 'k.kodebidang'],
                        ['m.kodekelompok', 'k.kodekelompok'],
                        ['m.kodesub', 'k.kodesub'],
                        ['m.kodesubsub', 'k.kodesubsub'],
                    ]
                )->leftJoin('penyusutan as p', 'k.kodekib', '=', 'p.kodekib')
                ->whereIn('k.kodekib', $kodekib)
                ->get()
                ->toArray();
            $dataKibTelahSusut = array_map(function ($data) {
                $data = (array) $data;
                if ($data['tahun'] < intval(env('TAHUN_APLIKASI')) || $data['tahun'] == null) {
                    $data['akumulasi'] = $data['nilaiakumulasibarang'] - ($data['nilaiakumulasibarang'] / $data['masamanfaat']);
                    if ($data['manfaat'] != null) {
                        $data['manfaat'] = $data['manfaat'] - 1;
                    } else {
                        $data['manfaat'] = $data['masamanfaat'] - 1;
                    }
                    if ($data['manfaat'] != 0) {
                        $data['akhir'] = 0;
                    } else {
                        $data['akhir'] = 1;
                    }
                    $data['susut'] = $data['nilaiakumulasibarang'] / $data['masamanfaat'];
                    $data['tahun'] = intval(env('TAHUN_APLIKASI'));
                    $data['nilai'] = $data['nilaiakumulasibarang'] / $data['masamanfaat'];
                    $data['ket'] = 'penyusutan tahun '.env('TAHUN_APLIKASI');
                    $data['bulan'] = now('Asia/Jakarta')->month;
                    $data['tgl_penyusutan'] = now('Asia/Jakarta');
                    unset($data['nilaiakumulasibarang'], $data['masamanfaat']);

                    return $data;
                }
            }, $dataKibAkanSusut);
            if ($dataKibTelahSusut[0] != null) {
                DB::table('penyusutan')->insert($dataKibTelahSusut);
                foreach ($dataKibTelahSusut as $index => $data) {
                    DB::table('kib')
                        ->where('kodekib', $data['kodekib'])
                        ->update(['nilaiakumulasibarang' => $data['akumulasi']]);
                }
                DB::commit();
            }
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}

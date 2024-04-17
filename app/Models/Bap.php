<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bap extends Model
{
    use HasFactory;
    protected $table = 'bap';

    static function getAllOrganizationBaps()
    {
        $copied = clone (session('organisasi'));
        unset($copied->organisasi, $copied->wajibsusut);
        return self::where((array)$copied)->where(['kodejenistransaksi' => '101', 'tahunorganisasi' => env('APP_YEAR')])->orderBy('idbap', 'ASC')->get();
    }
    static function getAllOrganizationBapsSp2d()
    {
        $copied = clone (session('organisasi'));
        unset($copied->organisasi, $copied->wajibsusut);
        return self::select('bap.*')
            ->join('kibtransaksi as kt', 'kt.kodebap', '=', 'bap.idbap')
            ->join('kib as k', 'kt.kodekib', '=', 'k.kodekib')
            ->join('kibsp2d as kd', 'k.kodekib', '=', 'kd.kodekib')
            ->where([
                'bap.kodejenistransaksi' => '101',
                'bap.tahunorganisasi' => env('APP_YEAR'),
                'bap.kodeurusan' => $copied->kodeurusan,
                'bap.kodesuburusan' => $copied->kodesuburusan,
                'bap.kodesubsuburusan' => $copied->kodesubsuburusan,
                'bap.kodeorganisasi' => $copied->kodeorganisasi,
                'bap.kodesuborganisasi' => $copied->kodesuborganisasi,
                'bap.kodeunit' => $copied->kodeunit,
                'bap.kodesubunit' => $copied->kodesubunit,
                'bap.kodesubsubunit' => $copied->kodesubsubunit,
            ])
            ->orderBy('idbap', 'ASC')->groupBy('kodebap')->get();
    }

    static function getDetailBap($kodebap)
    {
        $dataKibTransaksi = DB::table('kibtransaksi')->where('kodebap', $kodebap)->get()->toArray();
        $kodekib = array_map(function ($obj) {
            return $obj->kodekib;
        }, $dataKibTransaksi);
        $dataKib = DB::table('kib')
            ->selectRaw('kib.*, kodekib as iddetail, uraibarang as urai, (select kategori from masterasalusul where kodeasalusul = kib.kodeasalusul) as "select-asal-usul-barang-perolehan-aset", (select count(kodekib) from kibtransaksi where kodebap = ' . $kodebap . ' and uraibarang = kib.uraibarang group by uraibarang) as jumlah')
            ->whereIn('kodekib', $kodekib)
            ->get()
            ->unique('uraibarang')
            ->toArray();
        return ['dataKibTransaksi' => $dataKibTransaksi, 'dataKib' => $dataKib];
    }
    static function getDetailBapSp2d($kodebap)
    {
        $dataKibTransaksi = DB::table('kibtransaksi')->where('kodebap', $kodebap)->get()->toArray();
        $kodekib = array_map(function ($obj) {
            return $obj->kodekib;
        }, $dataKibTransaksi);
        $dataKib = DB::table('kib')
            ->selectRaw(
                "kib.*, kodekib as iddetail, uraibarang as urai, (select kategori from masterasalusul where kodeasalusul = kib.kodeasalusul) as `select-asal-usul-barang-perolehan-aset`, (select count(kodekib) from kibtransaksi where kodebap = $kodebap and uraibarang = kib.uraibarang group by uraibarang) as jumlah, (SELECT JSON_ARRAYAGG(JSON_OBJECT('id', concat(kd.nosp2d,'_',kd.tglsp2d), 'nilai', kd.nilai, 'keperluan', sp.keperluan, 'kdper', kd.kdper, 'persentase', persentase)) from kibsp2d kd join sp2d sp on kd.kdper = sp.kdper and kd.nuprgrm = sp.nuprgrm and kd.nosp2d = sp.nosp2d and kd.tglsp2d = sp.tglsp2d and kd.kdkegunit = sp.nukegunit  where kodekib = kib.kodekib) as sp2d"
            )
            ->whereIn('kodekib', $kodekib)
            ->get()
            ->unique('uraibarang')
            ->toArray();
        $sp2d = DB::table('kibsp2d')->selectRaw('nuprgrm as program, kdkegunit as kegiatan')->whereIn('kodekib', $kodekib)->first();
        return ['dataKibTransaksi' => $dataKibTransaksi, 'dataKib' => $dataKib, 'sp2d' => $sp2d];
    }
}

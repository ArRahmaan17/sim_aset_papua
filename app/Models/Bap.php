<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Bap extends Model
{
    use HasFactory;

    protected $table = 'bap';

    public static function getAllOrganizationBaps()
    {
        $copied = clone session('organisasi');
        unset($copied->organisasi, $copied->wajibsusut);

        return self::select('bap.*')->join('kibtransaksi as kt', 'kt.kodebap', '=', 'bap.kodebap')
            ->join('kib as k', 'kt.kodekib', '=', 'k.kodekib')
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
            ])->whereRaw('NOT EXISTS (select kodekib from kibsp2d kd)')->groupBy(
                'bap.idbap',
                'bap.kodebap',
                'bap.tanggalbap',
                'bap.nobaterima',
                'bap.tanggalbaterima',
                'bap.keterangan',
                'bap.nosp2d',
                'bap.tanggalsp2d',
                'bap.nokuitansi',
                'bap.tanggalkuitansi',
                'bap.nokontrak',
                'bap.nilaikontrak',
                'bap.kodejenistransaksi',
                'bap.tanggalkontrak',
                'bap.kodeurusan',
                'bap.kodesuburusan',
                'bap.kodesubsuburusan',
                'bap.kodeorganisasi',
                'bap.kodesuborganisasi',
                'bap.kodeunit',
                'bap.kodesubunit',
                'bap.kodesubsubunit',
                'bap.tahunorganisasi',
                'bap.nama_penyedia',
                'bap.npwp',
                'bap.idkontrak',
                'bap.judulkontrak',
                'bap.unitkey',
                'bap.isbap',
                'bap.nodokumenpendukung',
                'bap.tanggaldokumenpendukung',
                'bap.pihakpemberi',
                'bap.namaperjanjian',
                'bap.nomorperjanjian',
                'bap.tanggalperjanjian',
                'bap.author',
                'bap.created_at',
                'bap.updated_at',
                'bap.pattern_kodebaptahun',
                'bap.pattern_kodebap',
                'bap.pattern_kodebapopd',
                'bap.pattern_nobaterimatahun',
                'bap.pattern_nobaterima',
                'bap.pattern_nobaterimaopd',
                'bap.tanggalmulaipemanfaatan',
                'bap.tanggalselesaipemanfaatan'
            )->orderBy('bap.idbap', 'ASC')
            ->get();
    }

    public static function getAllOrganizationBapsSp2d()
    {
        $copied = clone session('organisasi');
        unset($copied->organisasi, $copied->wajibsusut);

        return self::select('bap.*')
            ->join('kibtransaksi as kt', 'kt.kodebap', '=', 'bap.kodebap')
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
            ->orderBy('idbap', 'ASC')->get();
    }

    public static function getDetailBap($kodebap)
    {
        $dataKibTransaksi = DB::table('kibtransaksi')->where('kodebap', $kodebap)->get()->toArray();
        $kodekib = array_map(function ($obj) {
            return $obj->kodekib;
        }, $dataKibTransaksi);
        $dataKib = DB::table('kib')
            ->selectRaw(
                "kib.*, kodekib as iddetail, uraibarang as urai, (select kategori from masterasalusul where kodeasalusul = kib.kodeasalusul) as 'select-asal-usul-barang-perolehan-aset', (select count(kodekib) from kibtransaksi where kodebap = quote_literal('" . $kodebap . "') and uraibarang = kib.uraibarang group by uraibarang) as jumlah'
            )
            ->whereIn('kodekib', $kodekib)
            ->get()
            ->unique('uraibarang')
            ->toArray();

        return ['dataKibTransaksi' => $dataKibTransaksi, 'dataKib' => $dataKib];
    }

    public static function getDetailBapSp2d($kodebap)
    {
        $dataKibTransaksi = DB::table('kibtransaksi')->where('kodebap', $kodebap)->get()->toArray();
        $kodekib = array_map(function ($obj) {
            return $obj->kodekib;
        }, $dataKibTransaksi);
        $dataKib = DB::table('kib')
            ->selectRaw(DB::raw(
                'kib.*, kodekib as iddetail, uraibarang as urai, (select kategori from masterasalusul where kodeasalusul = kib.kodeasalusul) as "select-asal-usul-barang-perolehan-aset", (select count(kodekib) from kibtransaksi where kodebap = ' . $kodebap . ' and uraibarang = kib.uraibarang group by uraibarang) as jumlah,' . " (SELECT json_array_elements(json_build_object('id', concat(kd.nosp2d,'_',kd.tglsp2d), 'nilai', kd.nilai, 'keperluan', sp.keperluan, 'kdper', kd.kdper, 'persentase', persentase)) from kibsp2d kd join sp2d sp on kd.kdper = sp.kdper and kd.nuprgrm = sp.nuprgrm and kd.nosp2d = sp.nosp2d and kd.tglsp2d = sp.tglsp2d and kd.kdkegunit = sp.nukegunit  where kodekib = kib.kodekib) as sp2d"
            ))
            ->whereIn('kodekib', $kodekib)
            ->get()
            ->unique('uraibarang')
            ->toArray();
        $sp2d = DB::table('kibsp2d')->selectRaw('nuprgrm as program, kdkegunit as kegiatan')->whereIn('kodekib', $kodekib)->first();

        return ['dataKibTransaksi' => $dataKibTransaksi, 'dataKib' => $dataKib, 'sp2d' => $sp2d];
    }
}

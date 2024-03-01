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
}

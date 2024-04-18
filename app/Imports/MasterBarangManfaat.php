<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class MasterBarangManfaat implements ToCollection
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            if ($index !== 0) {
                $code = explode('.', $row[0]);
                $kodegolongan = ''.$code[0];
                if (! isset($code[1])) {
                    $kodegolongan .= '0';
                } else {
                    $kodegolongan .= $code[1];
                }
                if (! isset($code[2])) {
                    $kodegolongan .= '0';
                } else {
                    $kodegolongan .= $code[2];
                }
                if ($collection[$index - 1][0] !== $row[0] && $collection[$index - 1][1] != $row[1]) {
                    DB::insert('INSERT INTO masterbarang (kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub,urai) values(?,?,?,?,?,?)', [
                        (int) $kodegolongan,
                        isset($code[3]) ? $code[3] : 0,
                        isset($code[4]) ? $code[4] : 0,
                        isset($code[5]) ? $code[5] : 0,
                        isset($code[6]) ? $code[6] : 0,
                        ''.$row[1],
                    ]);
                }
                DB::insert('INSERT INTO mastermasamanfaat (kodegolongan,kodebidang,kodekelompok,kodesub,kodesubsub,urai,masamanfaat) values(?,?,?,?,?,?,?)', [
                    (int) $kodegolongan,
                    isset($code[3]) ? $code[3] : 0,
                    isset($code[4]) ? $code[4] : 0,
                    isset($code[5]) ? $code[5] : 0,
                    isset($code[6]) ? $code[6] : 0,
                    ''.$row[1],
                    $row[2],
                ]);
            }
        }
    }
}

<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class MasterLokasi implements ToCollection
{
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            if ($index !== 0) {
                $code = explode('.', $row[0]);
                DB::insert('INSERT INTO masterlokasi values(?,?)', [
                    $row[0],
                    ''.$row[1],
                ]);
            }
        }
    }
}

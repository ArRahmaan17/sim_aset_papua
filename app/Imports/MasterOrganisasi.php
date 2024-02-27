<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;

class MasterOrganisasi implements ToCollection
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $collection)
    {
        foreach ($collection as $index => $row) {
            if ($index !== 0) {
                $code = explode('.', $row[0]);
                DB::insert('INSERT INTO masterorganisasi ', [
                    $code[0],
                    isset($code[1]) ? $code[1] : 0,
                    isset($code[2]) ? $code[2] : 0,
                    isset($code[3]) ? $code[3] : 0,
                    isset($code[4]) ? $code[4] : 0,
                    isset($code[5]) ? $code[5] : 0,
                    isset($code[6]) ? $code[6] : 0,
                    isset($code[7]) ? $code[7] : 0,
                    2024,
                    "" . $row[1],
                    0,
                ]);
            }
        }
    }
}

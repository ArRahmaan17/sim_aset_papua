<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MasterImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            0 => new MasterOrganisasi(),
            1 => new MasterLokasi(),
            2 => new MasterBarangManfaat(),
            3 => new MasterRehab(),
        ];
    }
}

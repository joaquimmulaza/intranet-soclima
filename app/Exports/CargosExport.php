<?php

namespace App\Exports;

use App\Cargo;
use Maatwebsite\Excel\Concerns\FromCollection;

class CargosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Cargo::all();
    }
}

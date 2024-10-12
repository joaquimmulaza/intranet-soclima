<?php

namespace App\Exports;

use App\Unidade;
use Maatwebsite\Excel\Concerns\FromCollection;

class UnidadesExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Unidade::all();
    }
}

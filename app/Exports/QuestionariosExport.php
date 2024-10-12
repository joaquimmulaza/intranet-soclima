<?php

namespace App\Exports;

use App\Questionaire;
use Maatwebsite\Excel\Concerns\FromCollection;

class QuestionariosExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Questionaire::all();
    }
}

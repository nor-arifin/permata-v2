<?php

namespace App\Exports;

use App\Models\Loinc;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportLoinc implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Loinc::all();
    }
}

<?php

namespace App\Exports;

use App\Models\Loincanswer;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportLoincanswer implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Loincanswer::all();
    }
}
<?php

namespace App\Exports;

use App\Models\Parameter;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportParameter implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Parameter::all();
    }
}
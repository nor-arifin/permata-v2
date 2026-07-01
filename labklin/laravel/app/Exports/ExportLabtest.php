<?php

namespace App\Exports;

use App\Models\Laboratory;
use Maatwebsite\Excel\Concerns\FromCollection;

class ExportLabtest implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Laboratory::all();
    }
}
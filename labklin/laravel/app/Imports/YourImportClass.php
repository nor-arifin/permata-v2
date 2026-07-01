<?php

namespace App\Imports;

use App\Models\Loinc;
use Maatwebsite\Excel\Concerns\ToModel;

class YourImportClass implements ToModel
{
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        return new Loinc([
            'loinc_code' => $row[0],
            'loinc_display' => $row[1],
            'loinc_component' => $row[2],
            'loinc_property' => $row[3],
            'loinc_timing' => $row[4],
            'loinc_system' => $row[5],
            'loinc_scale' => $row[6],
            'loinc_method' => $row[7],
            'loinc_unitofmeasure' => $row[8],
            'loinc_codesystem' => $row[9],
        ]);
    }
}

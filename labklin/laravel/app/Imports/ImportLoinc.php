<?php

namespace App\Imports;

use App\Models\Loinc;
use Maatwebsite\Excel\Concerns\ToModel;


class ImportLoinc implements ToModel
{
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        return new Loinc([
            'id' => $row[0],
            'loinc_code' => $row[1],
            'loinc_display' => $row[2],
            'loinc_component' => $row[3],
            'loinc_property' => $row[4],
            'loinc_timing' => $row[5],
            'loinc_system' => $row[6],
            'loinc_scale' => $row[7],
            'loinc_method' => $row[8],
            'loinc_unitofmeasure' => $row[9],
            'loinc_codesystem' => $row[10],
        ]);
    }
}
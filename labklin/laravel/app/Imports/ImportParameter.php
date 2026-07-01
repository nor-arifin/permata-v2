<?php

namespace App\Imports;

use App\Models\Parameter;
use Maatwebsite\Excel\Concerns\ToModel;


class ImportParameter implements ToModel
{
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        return new Parameter([
            'parameter_code' => $row[0],
            'parameter_name' => $row[1],
            'parameter_method' => $row[2],
            'parameter_unit' => $row[3],
            'parameter_category' => $row[4],
            'parameter_group' => $row[5],
            'parameter_subgroup' => $row[6],
            'parameter_specimen' => $row[7],
            'parameter_container' => $row[8],
            'parameter_parent' => $row[9],
            'parameter_reference_type' => $row[10],
            'parameter_reference_value' => $row[11],
            'parameter_price' => $row[12],
            'parameter_acreditation' => $row[13],
            'parameter_time' => $row[14],
            'parameter_status' => $row[15],
            'parameter_description' => $row[16],
            'parameter_encode' => $row[17],
        ]);
    }
}
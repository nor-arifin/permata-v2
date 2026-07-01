<?php

namespace App\Imports;

use App\Models\Laboratory;
use Maatwebsite\Excel\Concerns\ToModel;


class ImportLabtest implements ToModel
{
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        return new Laboratory([
            'id' => $row[0],
            'test_loinc_code' => $row[1],
            'test_loinc_display' => $row[2],
            'test_code' => $row[3],
            'test_name' => $row[4],
            'test_unit' => $row[5],
            'test_method' => $row[6],
            'test_specimen' => $row[7],
            'test_specimen_vol' => $row[8],
            'test_container' => $row[9],
            'test_resulttype' => $row[10],
            'test_normal_general' => $row[11],
            'test_min_general' => $row[12],
            'test_max_general' => $row[13],
            'test_normal_male' => $row[14],
            'test_min_male' => $row[15],
            'test_max_male' => $row[16],
            'test_normal_female' => $row[17],
            'test_min_female' => $row[18],
            'test_max_female' => $row[19],
            'test_normal_baby' => $row[20],
            'test_min_baby' => $row[21],
            'test_max_baby' => $row[22],
            'test_normal_child' => $row[23],
            'test_min_child' => $row[24],
            'test_max_child' => $row[25],
            'test_group' => $row[26],
            'test_subgroup' => $row[27],
            'test_category' => $row[28],
            'test_partof' => $row[29],
            'test_active' => $row[30],
            'test_price' => $row[31],
            'test_quantity' => $row[32],
            'test_description' => $row[33],
        ]);
    }
}
<?php

namespace App\Imports;

use App\Models\Loincanswer;
use Maatwebsite\Excel\Concerns\ToModel;


class ImportLoincanswer implements ToModel
{
    public function model(array $row)
    {
        // Define how to create a model from the Excel row data
        return new Loincanswer([
            'id' => $row[0],
            'loinc_code' => $row[1],
            'loinc_name' => $row[2],
            'answer_list_id' => $row[3],
            'answer_list_name' => $row[4],
            'answer_list_type' => $row[5],
            'answer_id' => $row[6],
            'answer_sequence' => $row[7],
            'answer_display_text' => $row[8],
            'answer_system' => $row[9],
        ]);
    }
}
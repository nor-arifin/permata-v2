<?php

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Loinc; // Ganti dengan model yang sesuai

class LoincSeeder extends Seeder
{
    public function run()
    {
        $path = base_path().'/database/seeders/xlsx/loinc.xlsx'; // Lokasi file XLSX
        Excel::import(new LoincImport, $path);
    }
}

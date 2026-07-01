<?php

namespace App\Http\Controllers;

use App\Exports\ExportLoinc;
use App\Exports\ExportLabtest;
use App\Exports\ExportParameter;
use App\Exports\ExportLoincanswer;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportController extends Controller
{
    public function exportloinc()
    {
        return Excel::download(new ExportLoinc, 'loinc.xlsx');
    }
    public function exportanswerloinc()
    {
        return Excel::download(new ExportLoincanswer, 'loincanswer.xlsx');
    }
    public function exportlabtest()
    {
        return Excel::download(new ExportLabtest, 'labtest.xlsx');
    }
    public function exportparameter()
    {
        return Excel::download(new ExportParameter, 'parameter.xlsx');
    }
}
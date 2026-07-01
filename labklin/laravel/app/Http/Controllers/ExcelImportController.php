<?php

namespace App\Http\Controllers;

use App\Imports\ImportLoinc;
use Illuminate\Http\Request;
use App\Imports\ImportLabtest;
use App\Imports\ImportParameter;
use App\Imports\ImportLoincanswer;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function indexloinc()
    {
        $menu = 'master';
        $submenu = 'loinc';
        return view('pages.excel.importloinc', compact('menu', 'submenu'));
    }
    public function importloinc(Request $request)
    {

        //TUTORIAL BY
        //https://magecomp.com/blog/import-excel-file-laravel/
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file
        Excel::import(new ImportLoinc, $file);

        return redirect()->back()->with('success', 'Excel file imported successfully !');
    }
    public function importloincanswer(Request $request)
    {

        //TUTORIAL BY
        //https://magecomp.com/blog/import-excel-file-laravel/
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file
        Excel::import(new ImportLoincanswer, $file);

        return redirect()->back()->with('success', 'Excel file imported successfully !');
    }
    public function importlabtest(Request $request)
    {

        //TUTORIAL BY
        //https://magecomp.com/blog/import-excel-file-laravel/
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file
        Excel::import(new ImportLabtest, $file);

        return redirect()->back()->with('success', 'Excel file imported successfully !');
    }
    public function importparameter(Request $request)
    {

        //TUTORIAL BY
        //https://magecomp.com/blog/import-excel-file-laravel/
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file
        Excel::import(new ImportParameter, $file);

        return redirect()->back()->with('success', 'Excel file imported successfully !');
    }
}
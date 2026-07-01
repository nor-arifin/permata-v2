<?php

namespace App\Http\Controllers;

use App\Models\Icd10;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class Icd10Controller extends Controller
{
    public function index(Request $request)
    {
        //satusehat_icd10
        $menu = 'visit';
        $submenu = 'outpatient';
        $icd10 = DB::table('satusehat_icd10')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('icd10_id', 'like', '%' . $name . '%');
            })
            ->orderBy('icd10_code', 'asc')
            ->paginate(100);

        return view('pages.reference.icd10', compact('icd10', 'menu', 'submenu'));
    }
    public function icdjsonvisit()
    {
        $patients = Icd10::all();
        return DataTables::of($patients)->addIndexColumn()
            ->addColumn('action', function ($patients) {
                $button =
                    '<div class="d-flex justify-content-center">
                <button class="btn btn-sm btn-success btn-icon confirm-delete ml-2"
                    id="select" data-code="' . $patients->icd10_code . '" data-in="' . $patients->icd10_id . '"><i class="fas fa-check"></i>
                </button>
            </div>';
                return $button;
            })
            ->make(true);
    }
    public function geticd($id)
    {
        $icd = Icd10::where('icd10_code', $id)->first();
        return response()->json($icd);
    }

}
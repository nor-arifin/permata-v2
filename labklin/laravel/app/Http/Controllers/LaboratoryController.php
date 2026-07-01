<?php

namespace App\Http\Controllers;

use App\Models\Loinc;
use App\Models\Laboratory;
use App\Models\Loincanswer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class LaboratoryController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'master';
        $submenu = 'laboratory';
        $laboratories = DB::table('laboratories')
            ->when($request->input('name'), function ($query, $test_name) {
                return $query->where('test_name', 'like', '%' . $test_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.laboratories.index', compact('laboratories', 'menu', 'submenu'));
    }
    //create
    public function create()
    {
        $menu = 'master';
        $submenu = 'laboratory';
        $panels = DB::table('laboratories')->where('test_category', 'Panel')->orderBy('test_name', 'asc')->get();
        return view('pages.laboratories.create', compact('menu', 'submenu', 'panels'));
    }
    public function loincjsonvisit()
    {
        $loinc = Loinc::all();
        return DataTables::of($loinc)->addIndexColumn()
            ->addColumn('action', function ($loinc) {
                $button =
                    '<div class="d-flex justify-content-center">
                <button class="btn btn-sm btn-success btn-icon confirm-delete ml-2"
                    id="select" data-code="' . $loinc->loinc_code . '" data-display="' . $loinc->loinc_display . '" data-component="' . $loinc->loinc_component . '" data-method="' . $loinc->loinc_method . '" data-unitofmeasure="' . $loinc->loinc_unitofmeasure . '" data-scale="' . $loinc->loinc_scale . '"><i class="fas fa-check"></i>
                </button>
            </div>';
                return $button;
            })
            ->make(true);
    }
    public function loinc(Request $request)
    {
        //satusehat_icd10
        $menu = 'visit';
        $submenu = 'outpatient';
        $loinc = DB::table('loincs')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('loinc_display', 'like', '%' . $name . '%');
            })
            ->orderBy('loinc_display', 'asc')
            ->paginate(10);

        return view('pages.reference.loinc', compact('loinc', 'menu', 'submenu'));
    }
    //Get Loinc Answer
    public function getLoincAnswer($id)
    {
        $answer = Loincanswer::where('loinc_code', $id)
            ->select('answer_sequence', 'answer_id', 'answer_display_text')
            ->orderBy('answer_sequence', 'asc')
            ->get();
        return response()->json($answer);
    }
    //store
    public function store(Request $request)
    {
        $resultype = $request->test_resulttype;
        $min_general = $request->test_min_general;
        $max_general = $request->test_max_general;
        $min_male = $request->test_min_male;
        $max_male = $request->test_max_male;
        $min_female = $request->test_min_female;
        $max_female = $request->test_max_female;
        $min_baby = $request->test_min_baby;
        $max_baby = $request->test_max_baby;
        $min_child = $request->test_min_child;
        $max_child = $request->test_max_child;
        if ($resultype == 'Qn') {
            $normal_general = $min_general . ' - ' . $max_general;
            $normal_male = $min_male . ' - ' . $max_male;
            $normal_female = $min_female . ' - ' . $max_female;
            $normal_baby = $min_baby . ' - ' . $max_baby;
            $normal_child = $min_child . ' - ' . $max_child;
        } elseif ($resultype == 'Ord') {
            $normal_general = $request->test_normal_general_ord;
            $normal_male = $request->test_normal_male_ord;
            $normal_female = $request->test_normal_female_ord;
            $normal_baby = $request->test_normal_baby_ord;
            $normal_child = $request->test_normal_child_ord;
        } else {
            $normal_general = $request->test_normal_general_other;
            $normal_male = $request->test_normal_male_other;
            $normal_female = $request->test_normal_female_other;
            $normal_baby = $request->test_normal_baby_other;
            $normal_child = $request->test_normal_child_other;
        }

        $laboratory = new Laboratory();
        $laboratory->test_loinc_code = $request->test_loinc_code;
        $laboratory->test_loinc_display = $request->test_loinc_display;
        $laboratory->test_code = $request->test_code;
        $laboratory->test_name = $request->test_name;
        $laboratory->test_unit = $request->test_unit;
        $laboratory->test_method = $request->test_method;
        $laboratory->test_specimen = $request->test_specimen;
        $laboratory->test_container = $request->test_container;
        $laboratory->test_specimen_vol = $request->test_specimen_vol;
        $laboratory->test_resulttype = $request->test_resulttype;
        //MIN MAX VALUE
        $laboratory->test_min_general = $request->test_min_general;
        $laboratory->test_max_general = $request->test_max_general;
        $laboratory->test_min_male = $request->test_min_male;
        $laboratory->test_max_male = $request->test_max_male;
        $laboratory->test_min_female = $request->test_min_female;
        $laboratory->test_max_female = $request->test_max_female;
        $laboratory->test_min_baby = $request->test_min_baby;
        $laboratory->test_max_baby = $request->test_max_baby;
        $laboratory->test_min_child = $request->test_min_child;
        $laboratory->test_max_child = $request->test_max_child;
        //NORMAL VALUE
        $laboratory->test_normal_general = $normal_general;
        $laboratory->test_normal_male = $normal_male;
        $laboratory->test_normal_female = $normal_female;
        $laboratory->test_normal_baby = $normal_baby;
        $laboratory->test_normal_child = $normal_child;
        //END LOGIC NORMAL VALUR

        $laboratory->test_group = $request->test_group;
        $laboratory->test_subgroup = $request->test_subgroup;
        $laboratory->test_category = $request->test_category;
        $laboratory->test_partof = $request->test_partof;
        $laboratory->test_active = $request->test_active;
        $laboratory->test_price = $request->test_price;
        $laboratory->test_description = $request->test_description;
        $laboratory->save();
        return redirect()->route('laboratory.index')->with('success', 'Laboratory Test created successfully.');
    }
    //edit
    public function edit($id)
    {
        $menu = 'master';
        $submenu = 'laboratory';
        $laboratory = Laboratory::find($id);
        $panels = DB::table('laboratories')->where('test_category', 'Panel')->orderBy('test_name', 'asc')->get();
        return view('pages.laboratories.edit', compact('laboratory', 'menu', 'submenu', 'panels'));
    }
    //update
    public function update(Request $request, $id)
    {
        $resultype = $request->test_resulttype;
        $min_general = $request->test_min_general;
        $max_general = $request->test_max_general;
        $min_male = $request->test_min_male;
        $max_male = $request->test_max_male;
        $min_female = $request->test_min_female;
        $max_female = $request->test_max_female;
        $min_baby = $request->test_min_baby;
        $max_baby = $request->test_max_baby;
        $min_child = $request->test_min_child;
        $max_child = $request->test_max_child;
        if ($resultype == 'Qn') {
            $normal_general = $min_general . ' - ' . $max_general;
            $normal_male = $min_male . ' - ' . $max_male;
            $normal_female = $min_female . ' - ' . $max_female;
            $normal_baby = $min_baby . ' - ' . $max_baby;
            $normal_child = $min_child . ' - ' . $max_child;
        } elseif ($resultype == 'Ord') {
            $normal_general = $request->test_normal_general_ord;
            $normal_male = $request->test_normal_male_ord;
            $normal_female = $request->test_normal_female_ord;
            $normal_baby = $request->test_normal_baby_ord;
            $normal_child = $request->test_normal_child_ord;
        } else {
            $normal_general = $request->test_normal_general_other;
            $normal_male = $request->test_normal_male_other;
            $normal_female = $request->test_normal_female_other;
            $normal_baby = $request->test_normal_baby_other;
            $normal_child = $request->test_normal_child_other;
        }

        $laboratory = Laboratory::find($id);
        $laboratory->test_loinc_code = $request->test_loinc_code;
        $laboratory->test_loinc_display = $request->test_loinc_display;
        $laboratory->test_code = $request->test_code;
        $laboratory->test_name = $request->test_name;
        $laboratory->test_unit = $request->test_unit;
        $laboratory->test_method = $request->test_method;
        $laboratory->test_specimen = $request->test_specimen;
        $laboratory->test_container = $request->test_container;
        $laboratory->test_specimen_vol = $request->test_specimen_vol;
        $laboratory->test_resulttype = $request->test_resulttype;
        //MIN MAX VALUE
        $laboratory->test_min_general = $request->test_min_general;
        $laboratory->test_max_general = $request->test_max_general;
        $laboratory->test_min_male = $request->test_min_male;
        $laboratory->test_max_male = $request->test_max_male;
        $laboratory->test_min_female = $request->test_min_female;
        $laboratory->test_max_female = $request->test_max_female;
        $laboratory->test_min_baby = $request->test_min_baby;
        $laboratory->test_max_baby = $request->test_max_baby;
        $laboratory->test_min_child = $request->test_min_child;
        $laboratory->test_max_child = $request->test_max_child;
        //NORMAL VALUE
        $laboratory->test_normal_general = $normal_general;
        $laboratory->test_normal_male = $normal_male;
        $laboratory->test_normal_female = $normal_female;
        $laboratory->test_normal_baby = $normal_baby;
        $laboratory->test_normal_child = $normal_child;
        //END LOGIC NORMAL VALUR

        $laboratory->test_group = $request->test_group;
        $laboratory->test_subgroup = $request->test_subgroup;
        $laboratory->test_category = $request->test_category;
        $laboratory->test_partof = $request->test_partof;
        $laboratory->test_active = $request->test_active;
        $laboratory->test_price = $request->test_price;
        $laboratory->test_description = $request->test_description;
        $laboratory->save();
        return redirect()->route('laboratory.index')->with('success', 'Laboratory Test updated successfully.');
    }


    //destroy
    public function destroy($id)
    {
        $laboratory = Laboratory::findOrFail($id);
        $labcode = $laboratory->test_code;
        DB::table('laboratories')->where('test_partof', $labcode)->delete();
        DB::table('laboratories')->where('id', $id)->delete();
        return redirect()->route('laboratory.index')->with('success', 'Laboratory Test deleted successfully.');
    }
    //get where test_code = request
    public function getTestCode(Request $request)
    {
        $test_code = $request->input('test_code');
        $lab_details = Laboratory::where('test_code', $test_code)->first();
        return response()->json($lab_details);
    }

    //EDITABLE




}
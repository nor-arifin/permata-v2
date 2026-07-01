<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneratorController extends Controller
{
    public function napza(Request $request)
    {
        // $module = 'Generator Surat NAPZA';
        // return view('errors.progress', compact('module'));

        $menu = 'generator';
        $submenu = 'napza';
        $testcode = array(
            'NAR',
            '4NR',
        );

        $allnapza = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            // ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            //where not NULL
            ->where('visits.visit_time_validation', '!=', null)
            ->whereIn('services_detail.service_code', $testcode)
            ->select(
                'services_detail.*',
                'patients.patient_mr',
                'patients.patient_gender',
                'patients.patient_name',
                'visits.visit_patient_dept',
            )
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'desc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', '%' . $name . '%')->orWhere('patients.patient_mr', 'like', '%' . $name . '%');
            })
            ->limit(200)
            ->paginate(10);
        // dd($allgolda);
        $data = compact('menu', 'submenu', 'allnapza');
        return view('pages.generator.allnapza', $data);
    }

    public function resumenapza($regno)
    {

        $visit = Visit::where('visit_registration_id', $regno)
            ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->first();

        $visitid = Visit::where('visit_registration_id', $regno)
            ->select('id')
            ->first();

        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_registration_id', '=', $regno);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        //join table anamneses with visits by visit_registration_id
        $anamneses = DB::table('anamneses');
        $anamneses = $anamneses->join('visits', 'anamneses.visit_registration_id', '=', 'visits.visit_registration_id');
        $anamneses = $anamneses->where('visits.visit_registration_id', '=', $regno);
        $anamneses = $anamneses->select('anamneses.*');
        $anamneses = $anamneses->first();
        //GET LABORATORY RESULTS
        $napza = array(
            'NAR',
            '4NR',
            '4MP',
            '4HC',
            '4OP',
            '4NZ',
            '4MT',
            'AMP',
            'MET',
            'BNZ',
            'THC',
            'MOP',
            'COC',
            'SOM',
        );
        $results = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->whereIn('services_detail.service_code', $napza)
            ->whereNotNull('services_detail.service_result')
            ->select(
                'services_detail.id',
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
                'services_detail.service_observation_id',
                'services_detail.service_diagnosticreport_id',
                'services_detail.service_result_code',
                'laboratories.test_unit',
                'laboratories.test_resulttype',
                'laboratories.test_normal_general',
                'laboratories.test_normal_male',
                'laboratories.test_normal_female',
                'laboratories.test_normal_baby',
                'laboratories.test_normal_child',
                'laboratories.test_min_general',
                'laboratories.test_max_general',
                'laboratories.test_min_male',
                'laboratories.test_max_male',
                'laboratories.test_min_female',
                'laboratories.test_max_female',
                'laboratories.test_min_baby',
                'laboratories.test_max_baby',
                'laboratories.test_min_child',
                'laboratories.test_max_child',
                'laboratories.test_category',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_group', 'asc')
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        $menu = 'generator';
        $submenu = 'napza';
        return view('pages.generator.resumenapza', compact('visit', 'visitid', 'patient', 'anamneses', 'results', 'menu', 'submenu'));
    }

    public function napzacreate(Request $request)
    {
        $validatedData = $request->validate([
            'letter_napza_date' => 'required|date',
            'letter_napza_number' => 'required|string|max:255|unique:register_napza,letter_napza_number',
            'letter_napza_purpose' => 'required|string',
            'letter_napza_conclution' => 'required|string',
            'letter_napza_signed' => 'required|string',
            'letter_napza_name' => 'required|string',
            'letter_napza_mr' => 'required|string',
            'letter_napza_lhu' => 'required|string|unique:register_napza,letter_napza_lhu',
        ]);

        DB::table('register_napza')->insert([
            'letter_napza_date' => $request->input('letter_napza_date'),
            'letter_napza_number' => $request->input('letter_napza_number'),
            'letter_napza_purpose' => $request->input('letter_napza_purpose'),
            'letter_napza_conclution' => $request->input('letter_napza_conclution'),
            'letter_napza_signed' => $request->input('letter_napza_signed'),
            'letter_napza_name' => $request->input('letter_napza_name'),
            'letter_napza_mr' => $request->input('letter_napza_mr'),
            'letter_napza_lhu' => $request->input('letter_napza_lhu'),
            'letter_napza_encode' => md5($request->input('letter_napza_number')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('all.napza')->with('success', 'NAPZA letter has been successfully created.');
    }

    public function gennapza($id)
    {
        $regnapza = DB::table('register_napza')
            ->join('visits', 'register_napza.letter_napza_lhu', '=', 'visits.visit_registration_id')
            ->where('register_napza.letter_napza_lhu', $id)
            ->select(
                'register_napza.*',
                'visits.*'

            )
            ->first();
        $patient = DB::table('patients')
            ->where('patient_mr', $regnapza->letter_napza_mr)
            ->first();

        $data = compact('regnapza', 'patient');
        // dd($data);

        return view('pages.generator.gennapza', $data);
    }




    public function mcu()
    {
        $module = 'Generator Surat Sehat';
        return view('errors.progress', compact('module'));
    }

    public function genmcu($id)
    {
        return view('pages.laboratory.gennapza');
    }

    public function golda(Request $request)
    {
        // $module = 'Generator Kartu Golda';
        // return view('errors.progress', compact('module'));
        $menu = 'generator';
        $submenu = 'golda';
        $testcode = array(
            'GDA',
            'GDR',
        );

        $allgolda = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            // ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            //where not NULL
            ->where('visits.visit_time_validation', '!=', null)
            ->whereIn('services_detail.service_code', $testcode)
            ->select(
                'services_detail.*',
                'patients.patient_mr',
                'patients.patient_gender',
                'patients.patient_name',
                'visits.visit_patient_dept',
            )
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'desc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', '%' . $name . '%')->orWhere('patients.patient_mr', 'like', '%' . $name . '%');
            })
            ->limit(200)
            ->paginate(10);
        // dd($allgolda);
        $data = compact('menu', 'submenu', 'allgolda');
        return view('pages.generator.allgolda', $data);

    }

    public function gengolda($id)
    {

        $testcode = array(
            'GDA',
            'GDR',
        );
        $golda = DB::table('visits')
            ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'visits.visit_patient_mr', '=', 'patients.patient_mr')
            ->select(
                'visits.visit_patient_name',
                'visits.visit_date',
                'visits.visit_registration_id',
                'patients.patient_gender',
                'patients.patient_birthdate',
                'patients.patient_mr',
                'patients.patient_nik',
                'services_detail.service_result',
                'services_detail.service_code',
                'services_detail.updated_at'
            )
            ->where('visits.visit_registration_id', $id)
            ->whereIn('services_detail.service_code', $testcode)
            ->first();
        // dd($golda);

        //make pdf view
        return view('pages.generator.golda', compact('golda'));
    }
}
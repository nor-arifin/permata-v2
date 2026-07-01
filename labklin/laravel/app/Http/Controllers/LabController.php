<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Service;
use App\Services\FonnteService;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Satusehat\Integration\OAuth2Client;
use Illuminate\Support\Facades\Redirect;
use Satusehat\Integration\FHIR\Specimen;
use Yajra\DataTables\Facades\DataTables;
use Satusehat\Integration\FHIR\Observation;
use Satusehat\Integration\FHIR\Servicerequest;
use Satusehat\Integration\FHIR\Diagnosticreport;
use Satusehat\Integration\FHIR\Observationlaboratory;

class LabController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'laboratory';
        $submenu = 'order';
        //JOIN TABLE SERVICES_DETAIL WITH VISITS BY SERVICE_VISIT_REGISTRATION_ID
        // NOTES BEFORE
        // In laravel with MySql go to file config/database.php and it change in array MySql mode strict to false.
        // 'connections' => [
        //     'mysql' => [
        //                  'strict' => false, //from true

        $services = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            //where not NULL
            ->where('services_detail.service_loinc_code', '!=', null)
            ->select('services_detail.*', 'patients.patient_gender', 'patients.patient_ihs', 'patients.patient_name', 'visits.visit_status_timeline', 'visits.visit_patient_dept')
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'desc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', "%{$name}%")->orWhere('patients.patient_mr', 'like', "%{$name}%");
            })
            ->limit(200)
            ->paginate(10);


        return view('pages.laboratory.index', compact('services', 'menu', 'submenu'));
    }
    //index
    public function show($id)
    {
        $menu = 'laboratory';
        $submenu = 'order';
        $visit = Visit::where('visit_registration_id', $id)->first();
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_registration_id', '=', $id);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        //join table services with visits by visit_registration_id
        $services = Service::where('service_visit_registration_id', $id)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->get();
        return view('pages.laboratory.show', compact('visit', 'patient', 'services', 'menu', 'submenu'));

    }
    public function collection(Request $request)
    {
        $menu = 'laboratory';
        $submenu = 'collection';

        $services = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            //where not NULL
            ->where('services_detail.service_loinc_code', '!=', null)
            ->select(
                'services_detail.*',
                'patients.patient_mr',
                'patients.patient_gender',
                'patients.patient_ihs',
                'patients.patient_name',
                'visits.visit_status_timeline',
                'visits.visit_date_progress',
                'visits.visit_time_sampling',
                'visits.visit_patient_dept',
                'laboratories.test_container',
                'laboratories.test_specimen',
                'laboratories.test_specimen_vol'
            )
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'desc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', "%{$name}%")->orWhere('patients.patient_mr', 'like', "%{$name}%");
            })
            ->limit(200)
            ->paginate(10);
        return view('pages.laboratory.collection', compact('services', 'menu', 'submenu'));
    }
    public function receive(Request $request)
    {
        $menu = 'laboratory';
        $submenu = 'receive';
        $requirement = 'Examination';

        $services = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            //where not NULL
            ->where('services_detail.service_loinc_code', '!=', null)
            ->where('visits.visit_time_sampling', '!=', null)
            ->where('visits.visit_time_receive', '=', null)
            ->where('visits.visit_status_timeline', '=', $requirement)
            ->select(
                'services_detail.*',
                'patients.patient_mr',
                'patients.patient_gender',
                'patients.patient_ihs',
                'patients.patient_name',
                'visits.visit_status_timeline',
                'visits.visit_date_progress',
                'visits.visit_time_sampling',
                'visits.visit_patient_dept',
                'laboratories.test_container',
                'laboratories.test_specimen',
                'laboratories.test_specimen_vol'
            )
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'asc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', '%' . $name . '%')->orWhere('patients.patient_mr', 'like', '%' . $name . '%');
            })
            ->limit(200)
            ->paginate(10);
        return view('pages.laboratory.receive', compact('services', 'menu', 'submenu'));
    }
    public function result(Request $request)
    {
        $menu = 'laboratory';
        $submenu = 'result';
        $requirement = 'Examination';

        $services = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            //where not NULL
            ->where('services_detail.service_loinc_code', '!=', null)
            ->where('visits.visit_time_sampling', '!=', null)
            ->where('visits.visit_time_receive', '!=', null)
            ->where('visits.visit_status_timeline', '=', $requirement)
            ->select(
                'services_detail.*',
                'patients.patient_mr',
                'patients.patient_gender',
                'patients.patient_ihs',
                'patients.patient_name',
                'visits.visit_status_timeline',
                'visits.visit_date_progress',
                'visits.visit_time_sampling',
                'visits.visit_time_receive',
                'visits.visit_patient_dept',
                'laboratories.test_container',
                'laboratories.test_specimen',
                'laboratories.test_specimen_vol'
            )
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'asc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', '%' . $name . '%')->orWhere('patients.patient_mr', 'like', '%' . $name . '%');
            })
            ->paginate(10);
        return view('pages.laboratory.result', compact('services', 'menu', 'submenu'));
    }
    public function loadservice($regno)
    {
        $services = DB::table('services_detail')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            //where not NULL
            ->where('services_detail.service_visit_registration_id', $regno)
            ->select(
                'services_detail.*',
                'laboratories.test_container',
                'laboratories.test_specimen',
                'laboratories.test_specimen_vol'
            )
            ->groupBy('laboratories.test_container')
            ->orderBy('laboratories.test_container', 'asc')
            ->get();
        return DataTables::of($services)->make(true);
    }
    public function specimen($regno)
    {
        $specimens = DB::table('services_detail')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            //where not NULL
            ->where('services_detail.service_visit_registration_id', $regno)
            ->select(
                'services_detail.*',
                'laboratories.test_container',
                'laboratories.test_specimen',
                'laboratories.test_specimen_vol'
            )
            ->groupBy('laboratories.test_container')
            ->orderBy('laboratories.test_container', 'asc')
            ->get();
        $menu = 'laboratory';
        $submenu = 'collection';
        return view('pages.laboratory.specimen', compact('specimens', 'menu', 'submenu'));
    }
    public function resultentry($regno)
    {

        $menu = 'laboratory';
        $submenu = 'result';
        $visit = Visit::where('visit_registration_id', $regno)->first();
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_registration_id', '=', $regno);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        //join table services with visits by visit_registration_id
        $services = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->get();
        //GET SERVICE DETAIL WHERE GROUP HEMATOLOGY
        $hematology = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.service_group', 'Hematology')
            ->select(
                'services_detail.*',
                'laboratories.test_unit',
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
                'laboratories.test_resulttype',
                'laboratories.test_category',
                'laboratories.test_loinc_code',
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();

        //GET SERVICE DETAIL WHERE GROUP BIOCHEMISTRY
        $biochemistry = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.service_group', 'Biochemistry')
            ->select(
                'services_detail.*',
                'laboratories.test_unit',
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
                'laboratories.test_resulttype',
                'laboratories.test_category',
                'laboratories.test_loinc_code',
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        //GET SERVICE DETAIL WHERE GROUP IMMUNOLOGY
        $immunology = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.service_group', 'Immunology')
            ->select(
                'services_detail.*',
                'laboratories.test_unit',
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
                'laboratories.test_resulttype',
                'laboratories.test_category',
                'laboratories.test_loinc_code',
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        //GET SERVICE DETAIL WHERE GROUP MICROBIOLOGY
        $microbiology = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.service_group', 'Microbiology')
            ->select(
                'services_detail.*',
                'laboratories.test_unit',
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
                'laboratories.test_resulttype',
                'laboratories.test_category',
                'laboratories.test_loinc_code',
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        //GET SERVICE DETAIL WHERE GROUP URINOLOGY
        $urinology = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.service_group', 'Urinology')
            ->select(
                'services_detail.*',
                'laboratories.test_unit',
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
                'laboratories.test_resulttype',
                'laboratories.test_category',
                'laboratories.test_loinc_code',
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        //GET SERVICE DETAIL WHERE GROUP BACTERIOLOGY
        $bacteriology = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.service_group', 'Bacteriology')
            ->select(
                'services_detail.*',
                'laboratories.test_unit',
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
                'laboratories.test_resulttype',
                'laboratories.test_category',
                'laboratories.test_loinc_code',
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        //GET SERVICE DETAIL WHERE GROUP OTHER
        $other = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->whereNotIn('services_detail.service_group', ['Hematology', 'Biochemistry', 'Immunology', 'Microbiology', 'Urinology', 'Bacteriology',])
            ->select(
                'services_detail.*',
                'laboratories.test_unit',
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
                'laboratories.test_resulttype',
                'laboratories.test_category',
                'laboratories.test_loinc_code',
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        return view('pages.laboratory.entry', compact('visit', 'patient', 'services', 'hematology', 'biochemistry', 'immunology', 'microbiology', 'urinology', 'bacteriology', 'other', 'menu', 'submenu'));
    }
    //UPDATE
    public function makeservicerequest(Request $request, $id)
    {
        $request->validate([
            'visit_time_sampling' => 'required',
            'visit_sampling_by' => 'required',
        ]);

        $time = $request->visit_time_sampling;
        $by = $request->visit_sampling_by;
        $notes = $request->service_notes;
        $status = "Examination";
        $now = now();

        //Get Visits join Services Detail where visit_registration_id
        $service = DB::table('visits')
            ->join('services_detail', 'visits.visit_registration_id', '=', 'services_detail.service_visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.id', '=', $id)
            ->get();
        // dd($service);
        $regNo = $service[0]->visit_registration_id;
        $subjectId = $service[0]->visit_patient_ihs;
        $encounterId = $service[0]->visit_encounter_id;
        $doctorId = $service[0]->visit_doctor_id;
        $doctorName = $service[0]->visit_doctor_name;
        // $doctorId2 = 10000416724; //GANTI PJLAB
        // $doctorName2 = "FAIZAH YUNIANTI"; //GANTI PJ LAB
        $doctorId2 = 10014058550; //GANTI PJLAB
        $doctorName2 = "Practitioner 9"; //GANTI PJ LAB
        $loincCode = $service[0]->service_loinc_code;
        $noreg = $service[0]->visit_registration_id;
        $text = "Pemeriksaan untuk penunjang diagnosa atau pemantauan terapi";
        $servicerequest = new Servicerequest;
        $servicerequest->setStatus('active');
        $servicerequest->addRegistrationId($regNo);
        $servicerequest->setIntent('original-order'); //only original-order supported
        $servicerequest->setPriority('routine'); //routine / stat / urgent
        $servicerequest->addCategory('108252007'); // code SNOMED for 108252007=>laboratory procedure 152200007=>Laboratroy Test
        $servicerequest->addCode($loincCode);
        $servicerequest->setSubject($subjectId);
        $servicerequest->setEncounter($encounterId, $noreg);
        $servicerequest->setOccurrenceDateTime($time);
        $servicerequest->setAuthoredOn($time);
        $servicerequest->setRequester($doctorId, $doctorName);
        $servicerequest->setPerformer($doctorId2, $doctorName2); //Nanti Ganti Dokter ID DAN Name PJLAB
        $servicerequest->setReasonCode($text);
        // $body = $servicerequest->json();
        // dd($body);
        //POST to FHIR Server
        [$statusCode, $response] = $servicerequest->post();
        // dd($statusCode, $response);
        if ($statusCode == 201) {
            //GET ID OBSERVATION AS UUID
            $servicerequest_id = $response->id;
            //Update observation visit

            Service::where('id', $id)
                ->update([
                    'service_servicerequest_id' => $servicerequest_id,
                ]);

            // Return a response indicating success
            return response()->json(['message' => 'Request updated successfully', 'success' => true]);

            // return redirect()->route('collection')->with('success', 'Specimen Collected Successfully & FHIR SatuSehat Created');
        } else {
            return response()->json(['message' => 'Request updated failed', 'error' => true]);
            // return redirect()->route('collection')->with('warning', 'Specimen Collection Successfully & FHIR SatuSehat Failed');
        }
    }
    public function makespecimen(Request $request, $id)
    {
        $request->validate([
            'visit_time_receive' => 'required',
            'visit_receive_by' => 'required',
        ]);

        $time = $request->visit_time_receive;
        //Get Visits join Services Detail where visit_registration_id
        $service = DB::table('visits')
            ->join('services_detail', 'visits.visit_registration_id', '=', 'services_detail.service_visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.id', '=', $id)
            ->get();
        // dd($service);

        $regNo = $service[0]->visit_registration_id;
        $subjectId = $service[0]->visit_patient_ihs;
        $subjectName = $service[0]->visit_patient_name;
        $encounterId = $service[0]->visit_encounter_id;
        $collectingTime = $service[0]->visit_time_sampling;
        $requestId = $service[0]->service_servicerequest_id;
        $typeSpecimen = $service[0]->test_specimen;
        $specimen = new Specimen;
        $specimen->addRegistrationId($regNo);
        $specimen->setStatus('available');
        $specimen->addType($typeSpecimen);
        $specimen->setCollectionTime($collectingTime);
        $specimen->setSubject($subjectId, $subjectName);
        $specimen->setRequest($requestId);
        $specimen->setReceived($time);
        $specimen->setExtension($time);
        $body = $specimen->json();
        // dd($body);

        //POST to FHIR Server
        [$statusCode, $response] = $specimen->post();

        // dd($statusCode, $response);
        if ($statusCode == 201) {

            //GET ID OBSERVATION AS UUID
            $specimen_id = $response->id;
            //Update observation visit
            Service::where('id', $id)
                ->update([
                    'service_specimen_id' => $specimen_id,
                ]);

            // Return a response indicating success
            return response()->json(['message' => 'Specimen updated successfully', 'success' => true]);

            // return redirect()->route('collection')->with('success', 'Specimen Collected Successfully & FHIR SatuSehat Created');
        } else {
            return response()->json(['message' => 'Specimen updated failed', 'error' => true]);
            // return redirect()->route('collection')->with('warning', 'Specimen Collection Successfully & FHIR SatuSehat Failed');
        }
    }
    public function makeobservation(Request $request, $id)
    {
        // Check Flag Result
        $flag = $request->flag;
        $result = $request->result;
        // dd($flag, $result);
        if ($flag == 'L' || $flag == 'N' || $flag == 'H') {
            $flaged = $flag;
        } else if ($flag == "*") {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            }
        } else if ($flag == null) {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            } else if ($result == "A") {
                $flaged = "Group A";
            } else if ($result == "B") {
                $flaged = "Group B";
            } else if ($result == "AB") {
                $flaged = "Group AB";
            } else if ($result == "O") {
                $flaged = "Group O";
            } else {
                $flaged = "N";
            }
        }

        // dd($flaged);

        //Get Visits join Services Detail where visit_registration_id

        $service = DB::table('visits')
            ->join('services_detail', 'visits.visit_registration_id', '=', 'services_detail.service_visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.id', '=', $id)
            ->get();
        // dd($service);

        $regNo = $service[0]->visit_registration_id;
        $subjectId = $service[0]->visit_patient_ihs;
        $subjectName = $service[0]->visit_patient_name;
        $encounterId = $service[0]->visit_encounter_id;
        $doctorId = $service[0]->visit_doctor_id;
        $doctorName = $service[0]->visit_doctor_name;
        $specimenId = $service[0]->service_specimen_id;
        $requestId = $service[0]->service_servicerequest_id;
        $resultType = $service[0]->test_resulttype;
        $testCategory = $service[0]->test_group;
        // $doctorId2 = 10009689134; //GANTI PJLAB
        // $doctorName2 = "LESTARI"; //GANTI PJ LAB
        $doctorId2 = 10014058550; //GANTI PJLAB
        $doctorName2 = "Practitioner 9"; //GANTI PJ LAB
        $loincCode = $service[0]->service_loinc_code;
        $loincDisplay = $service[0]->service_loinc_display;
        $time = date('Y-m-d\TH:i:sP'); //DATETIME NOW
        $result = $service[0]->service_result;
        $code = $service[0]->test_unit;
        $unit = $service[0]->test_unit;
        $flag = $flaged;
        $min = $service[0]->test_min_general;
        $max = $service[0]->test_max_general;
        $normal = $service[0]->service_reference;
        // $unit = $service[0]->test_unitofmeasure;//NANTI DIUBAH

        // SEND FHIR OBSERVATION
        //FHIR JSON
        $observation = new Observationlaboratory;
        $observation->addRegistrationId($regNo);
        $observation->setStatus("final");
        $observation->addCategory("laboratory"); //VitalSigns
        $observation->setCode($loincCode, $loincDisplay); //Code LOINC
        $observation->setSubject($subjectId); //Patient ID IHS
        $observation->setEncounter($encounterId, $regNo); //Encounter ID
        $observation->effectiveDateTime($time);
        $observation->issued($time);
        $observation->setPerformer($doctorId2);
        $observation->setSpecimen($specimenId);
        $observation->setRequest($requestId);
        if ($resultType == "Ord" || $resultType == "OrdQn") {
            $observation->valueCodeableConcept($result); //Ordinal
        } else if ($resultType == "Qn") {
            $observation->setvalueQuantity($result, $unit, $code); //Quantitatif value, unit, code
        } else if ($resultType == "Nom") {
            $observation->valueCodeableConceptNom($result); //Ordinal
        } else {
            $observation->valueString($result); //Text
        }

        if ($resultType == "Qn") {
            $observation->setInterpretation($flag); //Support L, N, H, DET, ND, NEG, POS, A, NR, RR
        }
        if ($resultType == "Ord" || $resultType == "OrdQn") {
            $observation->setRangeOrd($normal);
        } else if ($resultType == "Qn") {
            $observation->setRangeQn($min, $max, $unit);
        }
        // $labResult = $observation->json();
        // dd($labResult);
        //POST to FHIR Server
        [$statusCode, $response] = $observation->post();
        // dd($statusCode, $response);
        if ($statusCode == 201) {
            // GET ID OBSERVATION AS UUID
            $observation_id = $response->id;
            //Update observation services_detail

            Service::where('id', $id)
                ->update([
                    'service_observation_id' => $observation_id,
                ]);

            // Return a response indicating success
            return response()->json(['message' => 'Result send successfully', 'success' => true]);
        } else {
            return response()->json(['message' => 'Result send failed', 'error' => true]);
        }
    }
    public function makereport(Request $request, $id)
    {
        // Check Flag Result
        $flag = $request->flag2;
        // dd($flag);
        $result = $request->result2;
        if ($flag == 'L' || $flag == 'N' || $flag == 'H') {
            $flaged = $flag;
        } else if ($flag == "*") {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            }
        } else if ($flag == null) {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            } else if ($result == "A") {
                $flaged = "Group A";
            } else if ($result == "B") {
                $flaged = "Group B";
            } else if ($result == "AB") {
                $flaged = "Group AB";
            } else if ($result == "O") {
                $flaged = "Group O";
            }
        }

        // dd($flaged);

        //Get Visits join Services Detail where visit_registration_id
        $service = DB::table('visits')
            ->join('services_detail', 'visits.visit_registration_id', '=', 'services_detail.service_visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.id', '=', $id)
            ->get();
        // dd($service);

        $regNo = $service[0]->visit_registration_id;
        $testCategory = $service[0]->test_group;
        $subjectId = $service[0]->visit_patient_ihs;
        $subjectName = $service[0]->visit_patient_name;
        $encounterId = $service[0]->visit_encounter_id;
        $doctorId = $service[0]->visit_doctor_id;
        $doctorName = $service[0]->visit_doctor_name;
        $specimenId = $service[0]->service_specimen_id;
        $requestId = $service[0]->service_servicerequest_id;
        $observationId = $service[0]->service_observation_id;
        $resultType = $service[0]->test_resulttype;
        // $doctorId2 = 10000416724; //GANTI PJLAB
        // $doctorName2 = "FAIZAH YUNIANTI"; //GANTI PJ LAB
        $doctorId2 = 10014058550; //GANTI PJLAB
        $doctorName2 = "Practitioner 9"; //GANTI PJ LAB
        $loincCode = $service[0]->service_loinc_code;
        $loincDisplay = $service[0]->service_loinc_display;
        $time = date('Y-m-d\TH:i:sP'); //DATETIME NOW
        $result = $service[0]->service_result;
        $code = $service[0]->test_unit;
        $unit = $service[0]->test_unit;
        $flag = $flaged;
        $min = $service[0]->test_min_general;
        $max = $service[0]->test_max_general;
        $normal = $service[0]->test_normal_general;
        // $unit = $service[0]->test_unitofmeasure;//NANTI DIUBAH

        // SEND FHIR DISGNOSTIC REPORT
        //FHIR JSON
        $diagnostic = new Diagnosticreport();
        $diagnostic->addRegistrationId($regNo);
        $diagnostic->setStatus("final");
        $diagnostic->addCategory($testCategory);
        $diagnostic->setCode($loincCode, $loincDisplay); //Code LOINC
        $diagnostic->setSubject($subjectId); //Patient ID IHS
        $diagnostic->setEncounter($encounterId); //Encounter ID
        $diagnostic->effectiveDateTime($time);
        $diagnostic->issued($time);
        $diagnostic->setPerformer($doctorId2);
        $diagnostic->setResult($observationId);
        $diagnostic->setSpecimen($specimenId);
        $diagnostic->setRequest($requestId);
        // $diagnostic->setConclusion($flag, $resultType);
        if ($resultType == "Nar") {
            $diagnostic->setConclusionNar($result); //Narrative
        } else {
            $diagnostic->setConclusion($flag, $resultType);  //Text
        }
        // $labResport = $diagnostic->json();
        // dd($labResport);

        //POST to FHIR Server
        [$statusCode, $response] = $diagnostic->post();
        // dd($statusCode, $response);
        if ($statusCode == 201) {
            // GET ID OBSERVATION AS UUID
            $diagnosticreport_id = $response->id;
            //Update observation services_detail

            Service::where('id', $id)
                ->update([
                    'service_diagnosticreport_id' => $diagnosticreport_id,
                ]);
            // Return a response indicating success
            return response()->json(['message' => 'Result send successfully', 'success' => true]);
            // return redirect()->route('collection')->with('success', 'Specimen Collected Successfully & FHIR SatuSehat Created');
        } else {
            return response()->json(['message' => 'Result send failed', 'error' => true]);
            // return redirect()->route('collection')->with('warning', 'Specimen Collection Successfully & FHIR SatuSehat Failed');
        }
    }
    public function makefullreportold(Request $request, $id)
    {
        // Check Flag Result
        // $flag = $id;
        $flag = $request->flag;
        $result = $request->result;
        dd($result, $flag);
        if ($flag == 'L' || $flag == 'N' || $flag == 'H') {
            $flaged = $flag;
        } else if ($flag == "*") {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            }
        } else if ($flag == null) {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            } else if ($result == "A") {
                $flaged = "Group A";
            } else if ($result == "B") {
                $flaged = "Group B";
            } else if ($result == "AB") {
                $flaged = "Group AB";
            } else if ($result == "O") {
                $flaged = "Group O";
            } else {
                $flaged = "N";
            }
        }

        // dd($flaged);

        //Get Visits join Services Detail where visit_registration_id

        $service = DB::table('visits')
            ->join('services_detail', 'visits.visit_registration_id', '=', 'services_detail.service_visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('services_detail.id', '=', $id)
            ->get();
        // dd($service);

        $regNo = $service[0]->visit_registration_id;
        $subjectId = $service[0]->visit_patient_ihs;
        $subjectName = $service[0]->visit_patient_name;
        $encounterId = $service[0]->visit_encounter_id;
        $doctorId = $service[0]->visit_doctor_id;
        $doctorName = $service[0]->visit_doctor_name;
        $specimenId = $service[0]->service_specimen_id;
        $requestId = $service[0]->service_servicerequest_id;
        $resultType = $service[0]->test_resulttype;
        $testCategory = $service[0]->test_group;
        // $doctorId2 = 10000416724; //GANTI PJLAB
        // $doctorName2 = "FAIZAH YUNIANTI"; //GANTI PJ LAB
        $doctorId2 = 10014058550; //GANTI PJLAB
        $doctorName2 = "Practitioner 9"; //GANTI PJ LAB
        $loincCode = $service[0]->service_loinc_code;
        $loincDisplay = $service[0]->service_loinc_display;
        $time = date('Y-m-d\TH:i:sP'); //DATETIME NOW
        $result = $service[0]->service_result;
        $resultpanel = $service[0]->visit_validation_impression;
        $code = $service[0]->test_unit;
        $unit = $service[0]->test_unit;
        $flag = $flaged;
        $min = $service[0]->test_min_general;
        $max = $service[0]->test_max_general;
        $normal = $service[0]->service_reference;
        $testcategory = $service[0]->test_category; //CEK INI
        $serviceCode = $service[0]->service_code;
        dd($flag);
        // $unit = $service[0]->test_unitofmeasure;//NANTI DIUBAH
        // LOGIC TEST CATEGORY
        if ($testcategory == "Single") {
            // SEND FHIR OBSERVATION
            //FHIR JSON
            $observation = new Observationlaboratory;
            $observation->addRegistrationId($regNo);
            $observation->setStatus("final");
            $observation->addCategory("laboratory"); //VitalSigns
            $observation->setCode($loincCode, $loincDisplay); //Code LOINC
            $observation->setSubject($subjectId); //Patient ID IHS
            $observation->setEncounter($encounterId, $regNo); //Encounter ID
            $observation->effectiveDateTime($time);
            $observation->issued($time);
            $observation->setPerformer($doctorId2);
            $observation->setSpecimen($specimenId);
            $observation->setRequest($requestId);
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->valueCodeableConcept($result); //Ordinal
            } else if ($resultType == "Qn") {
                $observation->setvalueQuantity($result, $unit, $code); //Quantitatif value, unit, code
            } else if ($resultType == "Nom") {
                $observation->valueCodeableConceptNom($result); //Ordinal
            } else {
                $observation->valueString($result); //Text
            }

            if ($resultType == "Qn") {
                $observation->setInterpretation($flag); //Support L, N, H, DET, ND, NEG, POS, A, NR, RR
            }
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->setRangeOrd($normal);
            } else if ($resultType == "Qn") {
                $observation->setRangeQn($min, $max, $unit);
            }
            $labResult = $observation->json();
            // dd($labResult);
            //POST to FHIR Server
            [$statusCode, $response] = $observation->post();
            // dd($statusCode, $response);
            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $observation_id = $response->id;
                $flagQn =
                    $flagOrd = $response->valueCodeableConcept->coding[0]->code;
                //Update observation services_detail

                Service::where('id', $id)
                    ->update([
                        'service_observation_id' => $observation_id,
                    ]);
            }

            // SEND FHIR DISGNOSTIC REPORT
            //FHIR JSON
            $diagnostic = new Diagnosticreport();
            $diagnostic->addRegistrationId($regNo);
            $diagnostic->setStatus("final");
            $diagnostic->addCategory($testCategory);
            $diagnostic->setCode($loincCode, $loincDisplay); //Code LOINC
            $diagnostic->setSubject($subjectId); //Patient ID IHS
            $diagnostic->setEncounter($encounterId); //Encounter ID
            $diagnostic->effectiveDateTime($time);
            $diagnostic->issued($time);
            $diagnostic->setPerformer($doctorId2);
            $diagnostic->setResult($observation_id);
            $diagnostic->setSpecimen($specimenId);
            $diagnostic->setRequest($requestId);
            // $diagnostic->setConclusion($flag, $resultType);
            if ($resultType == "Nar") {
                $diagnostic->setConclusionNar($result); //Narrative
            } else {
                $diagnostic->setConclusion($flag, $resultType);  //Text
            }
            // $labResport = $diagnostic->json();
            // dd($labResport);

            //POST to FHIR Server
            [$statusCode, $response] = $diagnostic->post();
            // dd($statusCode, $response);

            // $diagnosticreport_id = $response->id;
            //     //Update observation services_detail

            //     Service::where('id', $id)
            //     ->update([
            //     'service_diagnosticreport_id' => $diagnosticreport_id,
            //     ]);

            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $diagnosticreport_id = $response->id;
                //Update observation services_detail

                Service::where('id', $id)
                    ->update([
                        'service_diagnosticreport_id' => $diagnosticreport_id,
                    ]);
                // Return a response indicating success
                return response()->json(['message' => 'Result & Report send successfully', 'success' => true]);
            } else {
                return response()->json(['message' => 'Result & Report send failed', 'error' => true]);
            }

        } elseif ($testcategory == "Sub Panel") {
            // SEND FHIR OBSERVATION
            //FHIR JSON
            $observation = new Observationlaboratory;
            $observation->addRegistrationId($regNo);
            $observation->setStatus("final");
            $observation->addCategory("laboratory"); //VitalSigns
            $observation->setCode($loincCode, $loincDisplay); //Code LOINC
            $observation->setSubject($subjectId); //Patient ID IHS
            $observation->setEncounter($encounterId, $regNo); //Encounter ID
            $observation->effectiveDateTime($time);
            $observation->issued($time);
            $observation->setPerformer($doctorId2);
            $observation->setSpecimen($specimenId);
            $observation->setRequest($requestId);
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->valueCodeableConcept($result); //Ordinal
            } else if ($resultType == "Qn") {
                $observation->setvalueQuantity($result, $unit, $code); //Quantitatif value, unit, code
            } else if ($resultType == "Nom") {
                $observation->valueCodeableConceptNom($result); //Ordinal
            } else {
                $observation->valueString($result); //Text
            }

            if ($resultType == "Qn") {
                $observation->setInterpretation($flaged); //Support L, N, H, DET, ND, NEG, POS, A, NR, RR
            }
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->setRangeOrd($normal);
            } else if ($resultType == "Qn") {
                $observation->setRangeQn($min, $max, $unit);
            }

            $labResult = $observation->json();
            dd($labResult);
            [$statusCode, $response] = $observation->post();

            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $observation_id = $response->id;
                $flagshow = $response->interpretation[0]->coding[0]->code;

                Service::where('id', $id)
                    ->update([
                        'service_observation_id' => $observation_id,
                        'service_flag' => $flagshow,
                    ]);
                // Return a response indicating success
                return response()->json(['message' => 'Result Sub Panel send successfully', 'success' => true]);
            } else {
                return response()->json(['message' => 'Result Sub Panel send failed', 'error' => true]);
            }
        } elseif ($testcategory == "Panel") {
            // SEND FHIR DISGNOSTIC REPORT
            //FHIR JSON
            $diagnostic = new Diagnosticreport();
            $diagnostic->addRegistrationId($regNo);
            $diagnostic->setStatus("final");
            $diagnostic->addCategory($testCategory);
            $diagnostic->setCode($loincCode, $loincDisplay); //Code LOINC
            $diagnostic->setSubject($subjectId); //Patient ID IHS
            $diagnostic->setEncounter($encounterId); //Encounter ID
            $diagnostic->effectiveDateTime($time);
            $diagnostic->issued($time);
            $diagnostic->setPerformer($doctorId2);
            $diagnostic->setResultPanel($serviceCode, $specimenId);
            $diagnostic->setSpecimen($specimenId);
            $diagnostic->setRequest($requestId);
            $diagnostic->setConclusionNar($resultpanel);
            // $labResport = $diagnostic->json();
            // dd($labResport);
            //POST to FHIR Server
            [$statusCode, $response] = $diagnostic->post();
            // dd($statusCode, $response);

            // $diagnosticreport_id = $response->id;
            //     //Update observation services_detail

            //     Service::where('id', $id)
            //     ->update([
            //     'service_diagnosticreport_id' => $diagnosticreport_id,
            //     ]);

            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $diagnosticreport_id = $response->id;
                //Update observation services_detail

                Service::where('service_specimen_id', $specimenId)
                    ->update([
                        'service_diagnosticreport_id' => $diagnosticreport_id,
                    ]);
                // Return a response indicating success
                return response()->json(['message' => 'Report Panel send successfully', 'success' => true]);
            } else {
                return response()->json(['message' => 'Report Panel send failed', 'error' => true]);
            }
        }
    }

    public function makefullreport($id)
    {
        // Check Flag Result
        // dd($id);
        //Get service_result by ID
        $service = Service::where('services_detail.id', $id)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'visits.visit_patient_mr', '=', 'patients.patient_mr')
            ->first();
        $result = $service->service_result; //DATA HASIL LAB
        $resulttype = $service->test_resulttype; //DATA RESULT TYPE
        $answer = $service->service_result_code; //DATA RESULT TYPE
        $gender = $service->patient_gender;
        $reference = $service->service_reference;
        $birthdate = $service->patient_birthdate;
        //CALCULATE AGE FROM birthdate
        $age = Carbon::parse($birthdate)->age;
        // dd($result, $resulttype, $gender, $age);
        //{{-- 1.CHECH resulttype --}}
        if ($resulttype == 'Qn') {
            ////{{-- 2. CHECK AGE --}}
            if ($age > 12) {
                //{{-- 3. CHECK GENDER --}}
                if ($gender == 'male') {
                    $minimal = $service->test_min_male;
                    $maximal = $service->test_max_male;
                } elseif ($gender == 'female') {
                    $minimal = $service->test_min_female;
                    $maximal = $service->test_max_female;
                }
            } elseif ($age <= 12) {
                $minimal = $service->test_min_child;
                $maximal = $service->test_max_child;
            } elseif ($age <= 1) {
                $minimal = $service->test_min_baby;
                $maximal = $service->test_max_baby;
            } else {
                $minimal = $service->test_min_general;
                $maximal = $service->test_max_general;
            }
        } else {
            $minimal = $reference;
            $maximal = $reference;
        }
        // dd($minimal, $maximal);
        //{{-- CHECK FLAG --}}
        if ($resulttype == 'Qn') {
            if ($result < $minimal && $result < $maximal) {
                $flag = 'L';
            } elseif ($result > $minimal && $result > $maximal) {
                $flag = 'H';
            } else {
                $flag = 'N';
            }
        } else {
            if ($result != $reference) {
                $flag = '*';
            } else {
                $flag = '';
            }
        }
        // dd($flag);

        // Logic Make Flag

        if ($flag == 'L' || $flag == 'N' || $flag == 'H') {
            $flaged = $flag;
        } else if ($flag == "*") {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Nonreactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            } else if ($result == "A") {
                $flaged = "Group A";
            } else if ($result == "B") {
                $flaged = "Group B";
            } else if ($result == "AB") {
                $flaged = "Group AB";
            } else if ($result == "O") {
                $flaged = "Group O";
            } else if ($result == "Group A") {
                $flaged = "Group A";
            } else if ($result == "Group B") {
                $flaged = "Group B";
            } else if ($result == "Group AB") {
                $flaged = "Group AB";
            } else if ($result == "Group O") {
                $flaged = "Group O";
            } else {
                $flaged = "N";
            }
        } else if ($flag == "") {
            if ($result == 'Negative') {
                $flaged = "NEG";
            } else if ($result == 'Positive') {
                $flaged = "POS";
            } else if ($result == 'Reactive') {
                $flaged = "RR";
            } else if ($result == 'Non-reactive') {
                $flaged = "NR";
            } else if ($result == 'Nonreactive') {
                $flaged = "NR";
            } else if ($result == 'Detected') {
                $flaged = "DET";
            } else if ($result == 'Not detected') {
                $flaged = "ND";
            } else if ($result == 'Abnormal') {
                $flaged = "A";
            } else if ($result == 'Resistant') {
                $flaged = "R";
            } else if ($result == 'Susceptible') {
                $flaged = "S";
            } else if ($result == 'Intermediate') {
                $flaged = "I";
            } else if ($result == "A") {
                $flaged = "Group A";
            } else if ($result == "B") {
                $flaged = "Group B";
            } else if ($result == "AB") {
                $flaged = "Group AB";
            } else if ($result == "O") {
                $flaged = "Group O";
            } else if ($result == "Group A") {
                $flaged = "Group A";
            } else if ($result == "Group B") {
                $flaged = "Group B";
            } else if ($result == "Group AB") {
                $flaged = "Group AB";
            } else if ($result == "Group O") {
                $flaged = "Group O";
            } else {
                $flaged = "N";
            }
        }

        $regNo = $service->visit_registration_id;
        $subjectId = $service->visit_patient_ihs;
        $subjectName = $service->visit_patient_name;
        $encounterId = $service->visit_encounter_id;
        $doctorId = $service->visit_doctor_id;
        $doctorName = $service->visit_doctor_name;
        $specimenId = $service->service_specimen_id;
        $requestId = $service->service_servicerequest_id;
        $resultType = $service->test_resulttype;
        $testCategory = $service->test_group;
        // $doctorId2 = 10000416724; //GANTI PJLAB
        // $doctorName2 = "FAIZAH YUNIANTI"; //GANTI PJ LAB
        $doctorId2 = 10014058550; //GANTI PJLAB
        $doctorName2 = "Practitioner 9"; //GANTI PJ LAB

        $loincCode = $service->service_loinc_code;
        $loincDisplay = $service->service_loinc_display;
        $time = date('Y-m-d\TH:i:sP'); //DATETIME NOW
        $result = $service->service_result;
        $answerId = $service->service_result_code;
        $resultpanel = $service->visit_validation_impression;
        $code = $service->test_unit;
        $unit = $service->test_unit;
        $flag = $flaged;
        $min = $service->test_min_general;
        $max = $service->test_max_general;
        $normal = $service->service_reference;
        $testcategory = $service->test_category; //CEK INI
        $serviceCode = $service->service_code;
        // dd($testcategory);
        // // $unit = $service[0]->test_unitofmeasure;//NANTI DIUBAH
        // LOGIC TEST CATEGORY
        if ($testcategory == "Single") {
            // SEND FHIR OBSERVATION
            //FHIR JSON
            $observation = new Observationlaboratory;
            $observation->addRegistrationId($regNo);
            $observation->setStatus("final");
            $observation->addCategory("laboratory"); //VitalSigns
            $observation->setCode($loincCode, $loincDisplay); //Code LOINC
            $observation->setSubject($subjectId); //Patient ID IHS
            $observation->setEncounter($encounterId, $regNo); //Encounter ID
            $observation->effectiveDateTime($time);
            $observation->issued($time);
            $observation->setPerformer($doctorId2);
            $observation->setSpecimen($specimenId);
            $observation->setRequest($requestId);
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->valueCodeableConcept($answer, $result); //Ordinal
            } else if ($resultType == "Qn") {
                $observation->setvalueQuantity($result, $unit, $code); //Quantitatif value, unit, code
            } else if ($resultType == "Nom") {
                $observation->valueCodeableConceptNom($answer, $result); //Nominal
            } else {
                $observation->valueString($result); //Text
            }
            if ($resultType == "Qn") {
                $observation->setInterpretation($flag); //Support L, N, H, DET, ND, NEG, POS, A, NR, RR
            }
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->setRangeOrd($normal);
            } else if ($resultType == "Qn") {
                $observation->setRangeQn($min, $max, $unit);
            }
            $labResult = $observation->json();
            // dd($labResult);
            //POST to FHIR Server

            [$statusCode, $response] = $observation->post();
            // dd($statusCode, $response);
            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $observation_id = $response->id;
                $flagshow = $flag;
                //Update observation services_detail

                Service::where('id', $id)
                    ->update([
                        'service_observation_id' => $observation_id,
                        'service_flag' => $flagshow,
                    ]);
            }

            // SEND FHIR DISGNOSTIC REPORT
            //FHIR JSON
            $diagnostic = new Diagnosticreport();
            $diagnostic->addRegistrationId($regNo);
            $diagnostic->setStatus("final");
            $diagnostic->addCategory($testCategory);
            $diagnostic->setCode($loincCode, $loincDisplay); //Code LOINC
            $diagnostic->setSubject($subjectId); //Patient ID IHS
            $diagnostic->setEncounter($encounterId); //Encounter ID
            $diagnostic->effectiveDateTime($time);
            $diagnostic->issued($time);
            $diagnostic->setPerformer($doctorId2);
            $diagnostic->setResult($observation_id);
            $diagnostic->setSpecimen($specimenId);
            $diagnostic->setRequest($requestId);
            // $diagnostic->setConclusion($flag, $resultType);
            if ($resultType == "Nar") {
                $diagnostic->setConclusionNar($result); //Narrative
            } elseif ($resultType == "Nom") {
                $diagnostic->setConclusionNom($answer, $result);  //Text
            } elseif ($resultType == "Ord") {
                $diagnostic->setConclusionOrd($answer, $result);  //Text
            } else {
                $diagnostic->setConclusion($flag, $resultType);  //Text
            }
            // $diagnostic = $diagnostic->json();
            // dd($diagnostic);

            //POST to FHIR Server
            [$statusCode, $response] = $diagnostic->post();

            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $diagnosticreport_id = $response->id;
                //Update observation services_detail

                Service::where('id', $id)
                    ->update([
                        'service_diagnosticreport_id' => $diagnosticreport_id,
                    ]);
                // Return a response indicating success
                return response()->json(['message' => 'Result & Report send successfully', 'success' => true]);
            } else {
                return response()->json(['message' => 'Result & Report send failed', 'error' => true]);
            }
            //END SINGLE TEST

        } elseif ($testcategory == "Sub Panel") {
            // SEND FHIR OBSERVATION
            //FHIR JSON
            $observation = new Observationlaboratory;
            $observation->addRegistrationId($regNo);
            $observation->setStatus("final");
            $observation->addCategory("laboratory"); //VitalSigns
            $observation->setCode($loincCode, $loincDisplay); //Code LOINC
            $observation->setSubject($subjectId); //Patient ID IHS
            $observation->setEncounter($encounterId, $regNo); //Encounter ID
            $observation->effectiveDateTime($time);
            $observation->issued($time);
            $observation->setPerformer($doctorId2);
            $observation->setSpecimen($specimenId);
            $observation->setRequest($requestId);
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->valueCodeableConcept($answer, $result); //Ordinal
            } else if ($resultType == "Qn") {
                $observation->setvalueQuantity($result, $unit, $code); //Quantitatif value, unit, code
            } else if ($resultType == "Nom") {
                $observation->valueCodeableConceptNom($answer, $result); //Nominal
            } else {
                $observation->valueString($result); //Text
            }

            if ($resultType == "Qn") {
                $observation->setInterpretation($flaged); //Support L, N, H, DET, ND, NEG, POS, A, NR, RR
            }
            if ($resultType == "Ord" || $resultType == "OrdQn") {
                $observation->setRangeOrd($normal);
            } else if ($resultType == "Qn") {
                $observation->setRangeQn($min, $max, $unit);
            }

            $labResult = $observation->json();

            [$statusCode, $response] = $observation->post();

            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $observation_id = $response->id;
                $flagshow = $flag;

                Service::where('id', $id)
                    ->update([
                        'service_observation_id' => $observation_id,
                        'service_flag' => $flagshow,
                    ]);
                // Return a response indicating success
                return response()->json(['message' => 'Result Sub Panel send successfully', 'success' => true]);
            } else {
                return response()->json(['message' => 'Result Sub Panel send failed', 'error' => true]);
            }

        } elseif ($testcategory == "Panel") {
            // SEND FHIR DISGNOSTIC REPORT
            //FHIR JSON
            $diagnostic = new Diagnosticreport();
            $diagnostic->addRegistrationId($regNo);
            $diagnostic->setStatus("final");
            $diagnostic->addCategory($testCategory);
            $diagnostic->setCode($loincCode, $loincDisplay); //Code LOINC
            $diagnostic->setSubject($subjectId); //Patient ID IHS
            $diagnostic->setEncounter($encounterId); //Encounter ID
            $diagnostic->effectiveDateTime($time);
            $diagnostic->issued($time);
            $diagnostic->setPerformer($doctorId2);
            $diagnostic->setResultPanel($serviceCode, $specimenId);
            $diagnostic->setSpecimen($specimenId);
            $diagnostic->setRequest($requestId);
            $diagnostic->setConclusionNar($resultpanel);
            // $labResport = $diagnostic->json();
            // dd($labResport);
            //POST to FHIR Server
            [$statusCode, $response] = $diagnostic->post();
            if ($statusCode == 201) {
                // GET ID OBSERVATION AS UUID
                $diagnosticreport_id = $response->id;
                //Update observation services_detail
                Service::where('service_specimen_id', $specimenId)
                    ->update([
                        'service_diagnosticreport_id' => $diagnosticreport_id,
                        'service_handler' => 'Terlampir',
                    ]);
                // Return a response indicating success
                return response()->json(['message' => 'Report Panel send successfully', 'success' => true]);
            } else {
                return response()->json(['message' => 'Report Panel send failed', 'error' => true]);
            }
        }
    }


    public function testing(Request $request)
    {
        // Process the form data and perform any necessary actions
        // For demonstration purposes, we'll just return a response.
        return response()->json(['message' => 'CF Form submitted successfully!']);
    }
    //update
    public function updatesampling(Request $request, $id)
    {
        $request->validate([
            'visit_time_sampling' => 'required',
            'visit_sampling_by' => 'required',
        ]);
        $time = $request->visit_time_sampling;
        $by = $request->visit_sampling_by;
        $notes = $request->service_notes;
        $status = "Examination";
        $now = now();
        //ACTION
        Visit::where('visit_registration_id', $id)
            ->update([
                'visit_time_sampling' => $time,
                'visit_sampling_by' => $by,
                'visit_status_timeline' => $status,
                'updated_at' => $now,
            ]);
        //update service_detail
        Service::where('service_visit_registration_id', $id)
            ->update([
                'service_notes' => $notes,
                'updated_at' => $now,
            ]);
        return redirect()->route('collection')->with('success', 'Specimen Collected Successfully');
    }
    //update
    public function updatereceive(Request $request, $id)
    {
        $request->validate([
            'visit_time_receive' => 'required',
            'visit_receive_by' => 'required',
        ]);
        $time = $request->visit_time_receive;
        $by = $request->visit_receive_by;
        $notes = $request->service_notes;
        $now = now();
        Visit::where('visit_registration_id', $id)
            ->update([
                'visit_time_receive' => $time,
                'visit_receive_by' => $by,
                'updated_at' => $now,
            ]);
        //update service_detail
        Service::where('service_visit_registration_id', $id)
            ->update([
                'service_notes' => $notes,
                'updated_at' => $now,
            ]);

        return redirect()->route('receive')->with('success', 'Specimen Received Successfully & FHIR SatuSehat Created');
    }
    //reject
    public function rejectreceive(Request $request, $id)
    {
        $time = null;
        $by = null;
        $notes = $request->service_notes;
        $status = "Sampling";
        $now = now();
        Visit::where('visit_registration_id', $id)
            ->update([
                'visit_time_sampling' => $time,
                'visit_sampling_by' => $by,
                'visit_time_receive' => $time,
                'visit_receive_by' => $by,
                'visit_status_timeline' => $status,
                'updated_at' => $now,
            ]);
        //update service_detail
        Service::where('service_visit_registration_id', $id)
            ->update([
                'service_notes' => $notes,
                'service_servicerequest_id' => null,
                'service_specimen_id' => null,
                'updated_at' => $now,
            ]);
        return redirect()->route('receive')->with('danger', 'Specimen Rejected Successfully');
    }

    //update result
    public function entryresult(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // Find the record in the database based on its ID
        $record = Service::findOrFail($data['id']);
        // Update the record with the new data
        $loincCode = $record->service_loinc_code;
        $result = $data['service_result'];
        $service_id = $data['id'];
        $record->update($data);
        $answer_code = \DB::table('loinc_answers')->where('loinc_code', $loincCode)->where('answer_display_text', $result)->value('answer_id');
        \DB::table('services_detail')
            ->where('id', $service_id)
            ->update(['service_result_code' => $answer_code]);

        // Return a response indicating success
        return response()->json(['message' => $answer_code, 'success' => true]);
    }
    public function getAnswerId(Request $request)
    {

        // Example logic to fetch the answer ID
        $id = $request->input('id');
        $result = $request->input('result');
        $loincCode = \DB::table('services_detail')->where('id', $id)->value('service_loinc_code');
        // dd($loincCode);
        $answerId = \DB::table('loinc_answers')->where('loinc_code', $loincCode)->where('answer_display_text', $result)->value('answer_id');

        if ($answerId) {
            return response()->json(['answer_id' => $answerId]);
        }
        return response()->json(['error' => 'Answer ID not found'], 404);
    }

    public function sendrequest(Request $request)
    {
        $data = $request->all();
        // dd($data);
        // Find the record in the database based on its ID
        $record = Service::findOrFail($data['id']);
        // Update the record with the new data
        $record->update($data);

        // Return a response indicating success
        return response()->json(['message' => 'Record updated successfully', 'success' => true]);
    }

    function notifValidate($regno)
    {

        $visit = Visit::where('visit_registration_id', $regno)->first();
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_registration_id', '=', $regno);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();

        // $kesmas = Kesmas::findOrFail($id);
        // //Get kesmas_orders Data join kesmas_customers
        // $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        // $verificator = DB::table('users')->where('id', $kesmas->order_verify_user)->first();
        $target = "081349067007"; //nomor tujuan notifikasi - validator
        $visit_date = date('d-m-Y', strtotime($visit->visit_date));
        $tat = now()->diffInHours($visit->visit_time_sampling);

        $message =
            "*NOTIFIKASI VALIDASI*
            
Yth. *Validator*,
Terdapat Lambar Hasil Uji Laboratorium Klinik menunggu expertise dan validasi klinis dari Anda.:

No. Lab : *" . $visit->visit_registration_id . "*
Tanggal Pemeriksaan : " . $visit_date . "
Nama Pasien : " . $visit->visit_patient_name . "
No Rekam Medik : " . $visit->visit_patient_mr . "
Dokter Pengirim : " . $visit->visit_doctor_name . "

Turn Around Time (TAT) : " . $tat . " jam sejak sample diterima.

Mohon segera dilakukan validasi melalui LabKlin Systems.

*Terima Kasih*
_Pesan ini dibuat otomatis oleh sistem_";
        FonnteService::send($target, $message);
    }

    //update result
    public function updateresult(Request $request, $id)
    {
        $request->validate([
            'visit_status_timeline' => 'required',
        ]);
        $now = now();
        Visit::where('visit_registration_id', $id)
            ->update([
                'visit_status_timeline' => $request->visit_status_timeline,
                'updated_at' => $now,
            ]);
        //notif validate
        $this->notifValidate($id);
        return redirect()->route('result')->with('success', 'Results Recorded Successfully');
    }
    public function validation(Request $request)
    {
        $menu = 'laboratory';
        $submenu = 'validation';
        $requirement = 'Validation';

        $services = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            //where not NULL
            ->where('visits.visit_time_sampling', '!=', null)
            ->where('visits.visit_time_receive', '!=', null)
            ->where('visits.visit_status_timeline', '=', $requirement)
            ->select(
                'services_detail.*',
                'patients.patient_mr',
                'patients.patient_gender',
                'patients.patient_name',
                'visits.visit_status_timeline',
                'visits.visit_date_progress',
                'visits.visit_time_sampling',
                'visits.visit_patient_dept',
            )
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'asc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', '%' . $name . '%')->orWhere('patients.patient_mr', 'like', '%' . $name . '%');
            })
            ->limit(200)
            ->paginate(10);
        return view('pages.laboratory.validation', compact('services', 'menu', 'submenu'));
    }
    public function viewvalidation($regno)
    {
        $menu = 'laboratory';
        $submenu = 'validation';
        $visit = Visit::where('visit_registration_id', $regno)
            ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
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
        $results = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            // ->where('services_detail.service_reference', '!=', 'Terlampir')
            ->whereNotNull('services_detail.service_result')
            ->select(
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
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
                'laboratories.test_code',
                'laboratories.test_partof',
            )
            ->orderBy('services_detail.service_group', 'asc')
            ->orderBy('services_detail.service_servicerequest_id', 'asc')
            ->orderBy('services_detail.id', 'asc')
            ->get();
        // 3 LATEST VISIT REGISTRATION ID
        $patient_rm = $patient->patient_mr;
        $lastvisits = Visit::where('visit_patient_mr', $patient_rm)
            ->select('visit_registration_id', 'visit_date', 'visit_validation_impression')
            ->limit(3)
            ->orderBy('visit_registration_id', 'desc')
            ->get();

        return view('pages.laboratory.validationshow', compact('visit', 'patient', 'anamneses', 'results', 'menu', 'submenu', 'lastvisits'));
    }

    function notifResult($regno)
    {
        $visit = Visit::where('visit_registration_id', $regno)->first();
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_registration_id', '=', $regno);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        $target = $patient->patient_telecom; //nomor tujuan notifikasi hasil

        $visit_date = date('d-m-Y', strtotime($visit->visit_date));
        $link = 'https://labkesmas-kalteng.id/verify/labreport/' . $visit->visit_encoded;

        $message =
            "*NOTIFIKASI HASIL*
            
Yth. Bapak/Ibu *" . $visit->visit_patient_name . "*,
Hasil Laboratorium Anda telah tersedia.

No. Lab : *" . $visit->visit_registration_id . "*
Tanggal Pemeriksaan : " . $visit_date . "
Nama Pasien : " . $visit->visit_patient_name . "
No Rekam Medik : " . $visit->visit_patient_mr . "
Dokter : " . $visit->visit_doctor_name . "

Anda dapat mengunduh dan mencetak Lembar Hasil Laboratorium pada tautan berikut ini:
" . $link . "

Mohon untuk tidak membagikan hasil ini kepada pihak lain tanpa izin dari dokter Anda dan membagikan di media sosial.
Jika Anda membutuhkan interpretasi medis lebih lanjut, silakan hubungi dokter Anda.

Untuk informasi lebih lanjut, silakan hubungi :
085824184658
layanan@labkesmas-kalteng.id

Terima kasih telah menggunakan layanan Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.

_Pesan ini dibuat otomatis oleh sistem_";
        FonnteService::send($target, $message);
    }
    function sendResult($regno)
    {
        $visit = Visit::where('visit_registration_id', $regno)->first();
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_registration_id', '=', $regno);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        $target = $patient->patient_telecom; //nomor tujuan notifikasi hasil

        $visit_date = date('d-m-Y', strtotime($visit->visit_date));
        $link = 'https://labkesmas-kalteng.id/verify/labreport/' . $visit->visit_encoded;

        $message =
            "*NOTIFIKASI HASIL*
            
Yth. Bapak/Ibu *" . $visit->visit_patient_name . "*,
Hasil Laboratorium Anda telah tersedia.

No. Lab : *" . $visit->visit_registration_id . "*
Tanggal Pemeriksaan : " . $visit_date . "
Nama Pasien : " . $visit->visit_patient_name . "
No Rekam Medik : " . $visit->visit_patient_mr . "
Dokter : " . $visit->visit_doctor_name . "

Anda dapat mengunduh dan mencetak Lembar Hasil Laboratorium pada tautan berikut ini:
" . $link . "

Mohon untuk tidak membagikan hasil ini kepada pihak lain tanpa izin dari dokter Anda dan membagikan di media sosial.
Jika Anda membutuhkan interpretasi medis lebih lanjut, silakan hubungi dokter Anda.

Untuk informasi lebih lanjut, silakan hubungi :
085824184658
layanan@labkesmas-kalteng.id

Terima kasih telah menggunakan layanan Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.

_Pesan ini dibuat otomatis oleh sistem_";
        FonnteService::send($target, $message);

        return redirect()->route('validation')->with('success', 'Notification Sent to Patient');
    }
    //update validate
    public function updateval(Request $request, $id)
    {
        $request->validate([
            'visit_status_timeline' => 'required',
        ]);
        $validator = Auth::user()->name;
        $time = date("Y-m-d H:i:s");
        Visit::where('visit_registration_id', $id)
            ->update([
                'visit_status_timeline' => $request->visit_status_timeline,
                'visit_validation_impression' => $request->visit_validation_impression,
                'visit_validation_by' => $validator,
                'visit_time_validation' => $time,
            ]);

        //notif validate
        $this->notifResult($id);
        return redirect()->route('validation')->with('success', 'Results Validated Successfully & Notification Sent to Patient');
    }
    //cancel to collect
    public function updatetocollect(Request $request, $id)
    {
        $request->validate([
            'visit_status_timeline' => 'required',
        ]);
        Visit::where('visit_registration_id', $id)
            ->update([
                'visit_status_timeline' => $request->visit_status_timeline,
                'visit_sampling_by' => null,
                'visit_time_sampling' => null,
                'visit_receive_by' => null,
                'visit_time_receive' => null,
                'visit_validation_impression' => null,
                'visit_validation_by' => null,
                'visit_time_validation' => null,
            ]);
        Service::where('service_visit_registration_id', $id)
            ->update([
                'service_result' => null,
                'service_reference' => null,
                'service_notes' => null,
                'service_handler' => null,
            ]);

        return redirect()->route('validation')->with('success', 'Results Cancelled Successfully');
    }
    public function updatetoreceive(Request $request, $id)
    {
        $request->validate([
            'visit_status_timeline' => 'required',
        ]);
        Visit::where('visit_registration_id', $id)
            ->update([
                'visit_status_timeline' => $request->visit_status_timeline,
                'visit_validation_impression' => null,
                'visit_validation_by' => null,
                'visit_time_validation' => null,
            ]);

        return redirect()->route('validation')->with('success', 'Results Cancelled Successfully');
    }

    public function report(Request $request)
    {
        $menu = 'laboratory';
        $submenu = 'report';
        $requirement = 'Reporting';
        $requirement2 = 'Finished';

        $services = DB::table('services_detail')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('patients', 'services_detail.service_visit_patient_mr', '=', 'patients.patient_mr')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            //where not NULL
            ->whereNotNull('visits.visit_time_sampling')
            ->whereNotNull('visits.visit_time_receive')
            ->where(function ($query) use ($requirement, $requirement2) {
                $query->where('visits.visit_status_timeline', $requirement)
                    ->orWhere('visits.visit_status_timeline', $requirement2);
            })
            ->select(
                'services_detail.*',
                'patients.patient_mr',
                'patients.patient_gender',
                'patients.patient_name',
                'visits.visit_status_timeline',
                'visits.visit_date_progress',
                'visits.visit_time_sampling',
                'visits.visit_time_validation',
                'visits.visit_patient_dept',
            )
            ->groupBy('services_detail.service_visit_registration_id')
            ->orderBy('services_detail.service_visit_registration_id', 'desc')
            ->when($request->input('search'), function ($query, $name) {
                return $query->where('patients.patient_name', 'like', '%' . $name . '%')
                    ->orWhere('patients.patient_mr', 'like', '%' . $name . '%');
            })
            ->limit(200)
            ->paginate(10);

        return view('pages.laboratory.report', compact('services', 'menu', 'submenu'));
    }

    public function generate(Request $request, $code)
    {
        $request->validate([
            'testcode' => 'required',
        ]);

        $testcode = $request->testcode;
        // dd($testcode);
        $visit = DB::table('services_detail')
            ->where('service_visit_registration_id', $code)
            ->where('service_code', $testcode)
            ->first();
        // dd($visit);
        // LOAD LABORATORIES BY TEST CODE
        $subpanel = DB::table('laboratories')
            ->where('test_partof', $testcode)
            ->where('test_active', 'active')
            ->get();
        // dd($subpanel);
        $subcode = $subpanel->pluck('test_code');
        // dd($testcode);
        $count = count($subcode);
        // // dd($count);
        if ($count > 0) {
            foreach ($subcode as $key => $value) {
                $lab = DB::table('laboratories')
                    ->where('test_code', $value)->first();
                // dd($lab);
                DB::table('services_detail')->insert([
                    'service_visit_registration_id' => $visit->service_visit_registration_id,
                    'service_visit_encounter_id' => $visit->service_visit_encounter_id,
                    'service_servicerequest_id' => $visit->service_servicerequest_id,
                    'service_specimen_id' => $visit->service_specimen_id,
                    'service_visit_encoded' => $visit->service_visit_encoded,
                    'service_visit_patient_mr' => $visit->service_visit_patient_mr,
                    'service_loinc_code' => $lab->test_loinc_code,
                    'service_loinc_display' => $lab->test_loinc_display,
                    'service_code' => $lab->test_code,
                    'service_name' => $lab->test_name,
                    'service_group' => $lab->test_group,
                    'service_subgroup' => $lab->test_subgroup,
                    'service_result' => '',
                    'service_price' => $lab->test_price,
                    'service_quantity' => 1,
                    'service_notes' => null,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
        }
        // update service_detail reference to Terlampir
        $visit = DB::table('services_detail')
            ->where('service_visit_registration_id', $code)
            ->where('service_code', $testcode)
            ->update([
                'service_time_result' => date('Y-m-d H:i:s'),
                'service_reference' => 'Terlampir',
            ]);

        return redirect()->route('lab.result', $code)->with('success', 'Sub Test Generated Successfully');
    }
}
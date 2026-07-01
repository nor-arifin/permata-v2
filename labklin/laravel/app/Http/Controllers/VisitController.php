<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use GuzzleHttp\Client;
use App\Models\Service;
use App\Models\Anamnesis;
use App\Models\Laboratory;
use Illuminate\Http\Request;
use App\Models\ProfileClinic;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Psr7\Request as Req;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Condition;
use Satusehat\Integration\FHIR\Encounter;
use Satusehat\Integration\FHIR\Bundle;


class VisitController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'visit';
        $submenu = 'outpatient';
        $visits = DB::table('visits')
            ->when($request->input('name'), function ($query, $visit_patient_name) {
                return $query->where('visit_patient_name', 'like', '%' . $visit_patient_name . '%');
            })
            ->orderBy('visit_registration_id', 'desc')
            ->limit(200)
            ->paginate(10);
        return view('pages.visits.index', compact('visits', 'menu', 'submenu'));
    }
    //create
    public function create()
    {
        $menu = 'visit';
        $submenu = 'outpatient';
        //SCRIPT GENERATE REG NO
        $noreg = Visit::where('visit_date', date('Y-m-d'))->orderBy('id', 'desc')->value('visit_registration_id'); // gets only the id
        if ($noreg == NULL) {
            $lastreg = date('Ymd') . '000';
        } else {
            $lastreg = $noreg;
        }
        $newreg = $lastreg + 1;
        $autoreg = $newreg; //REG NO RESULT

        $profiles = ProfileClinic::find(1);
        $doctors = DB::table('doctors')->get();
        $locations = DB::table('locations')->get();
        return view('pages.visits.create', compact('profiles', 'autoreg', 'locations', 'doctors', 'menu', 'submenu'));
    }
    //store
    public function store(Request $request)
    {
        //VALIDATION INPUT
        $request->validate([
            'visit_registration_id' => 'required',
            'visit_date_arrived' => 'required',
            'visit_method' => 'required',
            'visit_patient_id' => 'required',
            'visit_patient_name' => 'required',
            'visit_doctor_id' => 'required',
            'visit_doctor_name' => 'required',
            'visit_location_id' => 'required',
            'visit_location_name' => 'required',
        ]);
        $RegistrationId = $request->visit_registration_id;
        $Arrived = $request->visit_date_arrived;
        $ConsultationMethod = $request->visit_method;
        $SubjectId = $request->visit_patient_id;
        $SubjectName = $request->visit_patient_name;
        $ParticipantId = $request->visit_doctor_id;
        $ParticipantName = $request->visit_doctor_name;
        $LocationId = $request->visit_location_id;
        $LocationName = $request->visit_location_name;
        // STORE TO DATABASE
        $visit = new Visit;
        $visit->visit_registration_id = $RegistrationId;
        $visit->visit_date_arrived = $Arrived;
        $visit->visit_method = $ConsultationMethod;
        $visit->visit_patient_ihs = $SubjectId;
        $visit->visit_patient_name = $SubjectName;
        $visit->visit_doctor_id = $ParticipantId;
        $visit->visit_doctor_name = $ParticipantName;
        $visit->visit_location_id = $LocationId;
        $visit->visit_location_name = $LocationName;
        //OUTFORM
        $visit->visit_patient_mr = $request->visit_patient_mr;
        $visit->visit_patient_telecom = $request->visit_patient_telecom;
        $visit->visit_patient_dept = $LocationName;
        $visit->visit_status_timeline = "Arrived";
        $visit->visit_registered_by = Auth::user()->name;
        $visit->visit_date_arrived = date('Y-m-d H:i:s');
        $visit->visit_encoded = md5($RegistrationId);
        $visit->visit_date = date('Y-m-d');
        $visit->visit_patient_status = $request->visit_patient_status;
        $visit->visit_patient_account = $request->visit_patient_account;
        $visit->visit_patient_telecom = $request->visit_patient_telecom;
        $visit->save();
        // MAKE ENCOUNTER JSON
        $encounter = new Encounter;
        $encounter->addRegistrationId($RegistrationId); // unique string free text (increments / UUID)
        $encounter->setArrived($Arrived);
        $encounter->setConsultationMethod($ConsultationMethod); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
        $encounter->setSubject($SubjectId, $SubjectName); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $encounter->addParticipant($ParticipantId, $ParticipantName); // ID SATUSEHAT Dokter, Nama Dokter
        $encounter->addLocation($LocationId, $LocationName); // ID SATUSEHAT Location, Nama Poli
        // $body = $encounter->json(); //MAKE ENCOUNTER JSON AS BODY
        // dd($body); //TEST JSON FORMAT
        // Membuat client Auth IHS
        // $client = new OAuth2Client;
        // Type FHIR Resource
        // $resource = "Encounter"; //FHIR Resource (Bundle, Organization, Location, Patient, Practitioner, Encounter, Condition)
        //POST Agnostic
        // [$statusCode, $response] = $client->ss_post($resource, $body);

        [$statusCode, $response] = $encounter->post();
        // dd($statusCode, $response);

        if ($statusCode == 201) {
            //GET ID ENCOUNTER AS UUID
            $encounter_uuid = $response->id;
            Visit::where('visit_registration_id', $RegistrationId)
                ->update([
                    'visit_encounter_id' => $encounter_uuid
                ]);
            return redirect()->route('visits.index')->with('success', 'Visit created successfully with FHIR Encounter.');
        } else {
            return redirect()->route('visits.index')->with('warning', 'Visit created successfully without FHIR Encounter.');
        }
    }

    //resendencounter
    public function resendencounter($id)
    {
        //GET DATA VISIT FORM ID
        //EDIT
        $visit = Visit::where('visit_registration_id', $id)->first();

        $RegistrationId = $visit->visit_registration_id;
        $Arrived = $visit->visit_date_arrived;
        $ConsultationMethod = "RAJAL";
        $SubjectId = $visit->visit_patient_ihs;
        $SubjectName = $visit->visit_patient_name;
        $ParticipantId = $visit->visit_doctor_id;
        $ParticipantName = $visit->visit_doctor_name;
        $LocationId = $visit->visit_location_id;
        $LocationName = $visit->visit_location_name;
        $idkey = $visit->id;

        // MAKE ENCOUNTER JSON
        $encounter = new Encounter;
        $encounter->addRegistrationId($RegistrationId); // unique string free text (increments / UUID)
        $encounter->setArrived($Arrived);
        $encounter->setConsultationMethod($ConsultationMethod); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
        $encounter->setSubject($SubjectId, $SubjectName); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $encounter->addParticipant($ParticipantId, $ParticipantName); // ID SATUSEHAT Dokter, Nama Dokter
        $encounter->addLocation($LocationId, $LocationName); // ID SATUSEHAT Location, Nama Poli
        // $body = $encounter->json(); //MAKE ENCOUNTER JSON AS BODY
        // dd($body); //TEST JSON FORMAT
        // // Membuat client Auth IHS
        // $client = new OAuth2Client;
        // // Type FHIR Resource
        // $resource = "Encounter"; //FHIR Resource (Bundle, Organization, Location, Patient, Practitioner, Encounter, Condition)
        //POST Agnostic
        // [$statusCode, $response] = $client->ss_post($resource, $body);

        [$statusCode, $response] = $encounter->post();
        // dd($statusCode, $response);

        if ($statusCode == 201) {
            //GET ID ENCOUNTER AS UUID
            $encounter_uuid = $response->id;
            Visit::where('visit_registration_id', $RegistrationId)
                ->update([
                    'visit_encounter_id' => $encounter_uuid
                ]);
            return redirect()->route('visits.anamneses', $idkey)->with('success', 'Visit successfully connected with FHIR Encounter.');
        } else {
            // Fallback: cari Encounter berdasarkan subject (patient IHS ID)
            try {
                $satusehatClient = new OAuth2Client;
                $token = $satusehatClient->token();
                $guzzle = new Client();
                $headers = ['Authorization' => 'Bearer ' . $token];
                $searchUrl = $satusehatClient->fhir_url . '/Encounter?subject=' . $SubjectId;
                $req = new Req('GET', $searchUrl, $headers);
                $res = $guzzle->sendAsync($req)->wait();
                $searchResponse = json_decode($res->getBody()->getContents());

                if (
                    isset($searchResponse->total) &&
                    $searchResponse->total > 0 &&
                    isset($searchResponse->entry[0]->resource->id)
                ) {
                    $encounter_uuid = $searchResponse->entry[0]->resource->id;
                    Visit::where('visit_registration_id', $RegistrationId)
                        ->update(['visit_encounter_id' => $encounter_uuid]);
                    return redirect()->route('visits.anamneses', $idkey)->with('success', 'Encounter ID ditemukan di FHIR Server dan berhasil disimpan.');
                } else {
                    return redirect()->route('visits.anamneses', $idkey)->with('warning', 'Visit gagal terhubung ke FHIR Encounter dan tidak ditemukan di server.');
                }
            } catch (\Exception $e) {
                return redirect()->route('visits.anamneses', $idkey)->with('warning', 'Visit gagal terhubung ke FHIR Encounter: ' . $e->getMessage());
            }
        }
    }
    //store
    // public function store(Request $request)
    // {
    //     //VALIDATION INPUT
    //     // $request->validate([
    //     //     'visit_registration_id' => 'required',
    //     //     'visit_date_arrived' => 'required',
    //     //     'visit_method' => 'required',
    //     //     'visit_patient_id' => 'required',
    //     //     'visit_patient_name' => 'required',
    //     //     'visit_doctor_id' => 'required',
    //     //     'visit_doctor_name' => 'required',
    //     //     'visit_location_id' => 'required',
    //     //     'visit_location_name' => 'required',
    //     // ]);

    //     $RegistrationId = $request->visit_registration_id;
    //     $Arrived = $request->visit_date_arrived;
    //     $ConsultationMethod = $request->visit_method;
    //     $SubjectId = $request->visit_patient_id;
    //     $SubjectName = $request->visit_patient_name;
    //     $ParticipantId = $request->visit_doctor_id;
    //     $ParticipantName = $request->visit_doctor_name;
    //     $LocationId = $request->visit_location_id;
    //     $LocationName = $request->visit_location_name;
    //     $environment = $request->environment;
    //     $organization_id = $request->organization_id;

    //     // MAKE ENCOUNTER JSON
    //     // $encounter = new Encounter;
    //     // $encounter->addRegistrationId($RegistrationId); // unique string free text (increments / UUID)

    //     // $encounter->setArrived($Arrived);
    //     // $encounter->setConsultationMethod($ConsultationMethod); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
    //     // $encounter->setSubject($SubjectId, $SubjectName); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
    //     // $encounter->addParticipant($ParticipantId, $ParticipantName); // ID SATUSEHAT Dokter, Nama Dokter
    //     // $encounter->addLocation($LocationId, $LocationName); // ID SATUSEHAT Location, Nama Poli
    //     // $encounters = $encounter->json();

    //     // dd($encounter);
    //     // [$statusCode, $response] = $encounter->post();
    //     // dd($response);

    //     // Membuat client baru
    //     $client = new Client();
    //     //Auth IHS get Token
    //     $gettoken = new OAuth2Client;
    //     $token = $gettoken->token();
    //     // Header request
    //     $headers = [
    //         'Authorization' => 'Bearer ' . $token,
    //         'Accept'        => 'application/json',
    //         'Content-Type'  => 'application/json'
    //     ];
    //     // //JSON Data
    //     $encounters = [
    //         'resourceType' => 'Encounter',
    //         'status' => 'arrived',
    //         'class' => [
    //             'system' => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
    //             'code' => 'AMB',
    //             'display' => 'ambulatory'
    //         ],
    //         'subject' => [
    //             'reference' => 'Patient/' . $SubjectId,
    //             'display' => $SubjectName
    //         ],
    //         'participant' => [
    //             [
    //                 'type' => [
    //                     [
    //                         'coding' => [
    //                             [
    //                                 'system' => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
    //                                 'code' => 'ATND',
    //                                 'display' => 'attender'
    //                             ]
    //                         ]
    //                     ]
    //                 ],
    //                 'individual' => [
    //                     'reference' => 'Practitioner/' . $ParticipantId,
    //                     'display' => $ParticipantName
    //                 ],
    //             ],
    //         ],
    //         'period' => [
    //             'start' => date('Y-m-d\TH:i:sP', strtotime($Arrived))
    //         ],
    //         'location' => [
    //             [
    //                 'location' => [
    //                     'reference' => 'Location/' . $LocationId,
    //                     'display' => $LocationName
    //                 ],
    //             ]
    //         ],
    //         'statusHistory' => [
    //             [
    //                 'status' => 'arrived',
    //                 'period' => [
    //                     'start' => date('Y-m-d\TH:i:sP', strtotime($Arrived)),
    //                 ]
    //             ]
    //         ],
    //         'serviceProvider' => [
    //             'reference' => 'Organization/'.$organization_id,
    //         ],
    //         'identifier' => [
    //             'system' => 'http://sys-ids.kemkes.go.id/encounter/'.$organization_id,
    //             'value' => $RegistrationId
    //         ],
    //     ];
    //     //URL
    //     if($environment == "PROD"){
    //         $url = "https://api-satusehat.kemkes.go.id/consent/v1";
    //     }elseif($environment == "STG"){
    //         $url = "https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Encounter";
    //     }else{
    //         $url = "https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1/Encounter";
    //     }
    //     //POST TO API WITH BEARER TOKEN
    //     $response = $client->request('POST', $url, [
    //         'headers' => $headers,
    //         'json'    => $encounters
    //     ]);
    //     // Mendapatkan isi response
    //     $body = $response->getBody();
    //     // Decode JSON response menjadi array PHP
    //     $data = json_decode($body, true);
    //     // // Mengambil nilai consent id
    //     $encounters_id = $data['id'];
    //     echo ($data);





    //     // // Melakukan request POST
    //     // $response = $client->post($url, [
    //     //     'headers' => $headers,
    //     //     'json'    => $encounters
    //     // ]);
    // //     // Mendapatkan isi response
    // //     $body = $response->getBody();
    // //     // Decode JSON response menjadi array PHP
    // //     $data = json_decode($body, true);
    // //     // Mengambil nilai consent id
    // //     $encounters_id = $data['id'];
    // //     echo ($encounters_id);


    // //     // // STORE TO DATABASE
    // //     // $visit = new Visit;
    // //     // $visit->visit_registration_id = $RegistrationId;
    // //     // $visit->visit_date_arrived = $Arrived;
    // //     // $visit->visit_method = $ConsultationMethod;
    // //     // $visit->visit_patient_ihs = $SubjectId;
    // //     // $visit->visit_patient_name = $SubjectName;
    // //     // $visit->visit_doctor_id = $ParticipantId;
    // //     // $visit->visit_doctor_name = $ParticipantName;
    // //     // $visit->visit_location_id = $LocationId;
    // //     // $visit->visit_location_name = $LocationName;
    // //     // //OUTFORM
    // //     // $visit->visit_patient_mr = $request->visit_patient_mr;
    // //     // $visit->visit_patient_telecom = $request->visit_patient_telecom;
    // //     // $visit->visit_patient_dept = $LocationName;
    // //     // $visit->visit_status_timeline = "Arrived";
    // //     // $visit->visit_registered_by = Auth::user()->name;
    // //     // $visit->visit_date = date('Y-m-d');
    // //     // $visit->visit_encoded = Hash::make($RegistrationId);
    // //     // // $visit->visit_encounter_id = $EncounterId;

    // //     // $visit->save();
    // //     // return redirect()->route('consents.index')->with('success', 'Consent created successfully.');

    // }
    // public function store(Request $request)
    // {
    //     $RegistrationId = $request->visit_registration_id;
    //     $Arrived = $request->visit_date_arrived;
    //     $ConsultationMethod = $request->visit_method;
    //     $SubjectId = $request->visit_patient_id;
    //     $SubjectName = $request->visit_patient_name;
    //     $ParticipantId = $request->visit_doctor_id;
    //     $ParticipantName = $request->visit_doctor_name;
    //     $LocationId = $request->visit_location_id;
    //     $LocationName = $request->visit_location_name;
    //     $environment = $request->environment;
    //     $organization_id = $request->organization_id;

    //     // MAKE ENCOUNTER JSON
    //     $encounter = new Encounter;
    //     $encounter->addRegistrationId($RegistrationId); // unique string free text (increments / UUID)

    //     $encounter->setArrived($Arrived);
    //     $encounter->setConsultationMethod($ConsultationMethod); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
    //     $encounter->setSubject($SubjectId, $SubjectName); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
    //     $encounter->addParticipant($ParticipantId, $ParticipantName); // ID SATUSEHAT Dokter, Nama Dokter
    //     $encounter->addLocation($LocationId, $LocationName); // ID SATUSEHAT Location, Nama Poli
    //     $encounter->json();
    //     // Membuat client baru
    //     $client = new Client();
    //     //Auth IHS get Token
    //     $gettoken = new OAuth2Client;
    //     $token = $gettoken->token();
    //     //URL
    //     if($environment == "PROD"){
    //         $url = "https://api-satusehat.kemkes.go.id/consent/v1";
    //     }elseif($environment == "STG"){
    //         $url = "https://api-satusehat-stg.dto.kemkes.go.id/consent/v1/Encounter";
    //     }else{
    //         $url = "https://api-satusehat-dev.dto.kemkes.go.id/consent/v1/Encounter";
    //     }
    //     // Header request
    //     $headers = [
    //         'Authorization' => 'Bearer ' . $token,
    //         'Accept'        => 'application/json',
    //         'Content-Type'  => 'application/json'
    //     ];

    //     // Melakukan request POST
    //     $response = $client->post($url, [
    //         'headers' => $headers,
    //         'json'    => $encounter
    //     ]);
    //     // Mendapatkan isi response
    //     $body = $response->getBody();
    //     // Decode JSON response menjadi array PHP
    //     $data = json_decode($body, true);
    //     // Mengambil nilai consent id
    //     $consent_uuid = $data['id'];

    // }
    public function edit($id)
    {
        $visit = Visit::findOrFail($id);
        $menu = 'visit';
        $submenu = 'outpatient';
        return view('pages.visits.edit', compact('visit', 'menu', 'submenu'));
    }
    public function anamneses($id)
    {
        $visit = Visit::findOrFail($id);
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.id', '=', $id);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        //satusehat_icd10
        $icd10 = DB::table('satusehat_icd10')->get();
        $menu = 'visit';
        $submenu = 'outpatient';
        return view('pages.visits.anamneses', compact('visit', 'menu', 'submenu', 'patient', 'icd10'));
    }

    public function services($id)
    {
        $visit = Visit::findOrFail($id);
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.id', '=', $id);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        //join table anamneses with visits by visit_registration_id
        $anamneses = DB::table('anamneses');
        $anamneses = $anamneses->join('visits', 'anamneses.visit_registration_id', '=', 'visits.visit_registration_id');
        $anamneses = $anamneses->where('visits.id', '=', $id);
        $anamneses = $anamneses->select('anamneses.*');
        $anamneses = $anamneses->first();
        //laboratory items
        $laboratories = DB::table('laboratories')
            ->where('laboratories.test_category', '!=', 'Sub Panel')
            ->orderBy('test_name', 'asc')->get();
        $menu = 'visit';
        $submenu = 'outpatient';
        return view('pages.visits.services', compact('visit', 'menu', 'submenu', 'patient', 'anamneses', 'laboratories'));
    }

    public function payment($id)
    {
        $visit = Visit::findOrFail($id);
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.id', '=', $id);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();
        //join table services with visits by visit_registration_id
        $services = DB::table('services_detail');
        $services = $services->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id');
        $services = $services->where('visits.id', '=', $id);
        $services = $services->select('services_detail.*');
        $services = $services->orderBy('services_detail.id', 'asc');
        $services = $services->get();
        // dd($services);
        //laboratory items
        $menu = 'visit';
        $submenu = 'outpatient';
        return view('pages.visits.payment', compact('visit', 'menu', 'submenu', 'patient', 'services'));
    }

    public function resume($regno)
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
        $results = Service::where('service_visit_registration_id', $regno)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
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
        $menu = 'visit';
        $submenu = 'outpatient';
        return view('pages.visits.resume', compact('visit', 'visitid', 'patient', 'anamneses', 'results', 'menu', 'submenu'));
    }
    //update
    public function updatepayment(Request $request, $id)
    {
        $request->validate([
            'visit_payment_charge' => 'required',
            'visit_payment_discount' => 'required',
            'visit_payment_amount' => 'required',
            'visit_payment_remaining' => 'required|integer|size:0',
            'visit_payment_method' => 'required',
        ]);
        $method = $request->visit_payment_method;
        $card_number = $request->card_number;
        $card_cvc = $request->card_cvc;
        $card_holder = $request->card_holder;
        $card_month = $request->card_month;
        $card_year = $request->card_year;
        $bank_name = $request->bank_name;
        $ref_number = $request->ref_number;
        $bpjs_number = $request->bpjs_number;
        $bpjs_sep = $request->bpjs_sep;
        $officer = Auth::user()->name;
        $remaining = $request->visit_payment_remaining;

        if ($method == "Credit Card") {
            $notes = "CC" . $card_number . "CVC" . $card_cvc . "HOLD" . $card_holder . "EXP" . $card_month . "/" . $card_year;
        } else if ($method == "Debit Card") {
            $notes = "DC" . $bank_name . "REF" . $ref_number;
        } else if ($method == "BPJS") {
            $notes = "BPJS" . $bpjs_number . "SEP" . $bpjs_sep;
        } else {
            $notes = $method . "ON" . date("dmYH:i") . $officer;
        }
        //CEK PAYMENT REMAINING
        if ($remaining == 0) {
            $status = "paid";
        } else {
            $status = "unpaid";
        }

        $visit = Visit::findOrFail($id);
        $visit->visit_payment_charge = $request->visit_payment_charge;
        $visit->visit_payment_discount = $request->visit_payment_discount;
        $visit->visit_payment_method = $request->visit_payment_method;
        $visit->visit_payment_amount = $request->visit_payment_amount;
        $visit->visit_payment_remaining = $request->visit_payment_remaining;
        $visit->visit_payment_time = now();
        $visit->visit_payment_status = $status;
        $visit->visit_payment_officer = $officer;
        $visit->visit_payment_notes = $notes;
        $visit->updated_at = now();
        $visit->save();
        return redirect()->route('payment.clinic')->with('success', 'Payment updated successfully.');
    }
    public function printreceipt($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();
        //delete anamneses with visit.id
        Anamnesis::where('visit_registration_id', $visit->visit_registration_id)->delete();

        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }

    public function destroy($id)
    {
        $visit = Visit::findOrFail($id);
        $visit->delete();
        //delete anamneses with visit.id
        Anamnesis::where('visit_registration_id', $visit->visit_registration_id)->delete();
        Service::where('service_visit_registration_id', $visit->visit_registration_id)->delete();

        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }

    public function delete($id)
    {
        $visit = Visit::findOrFail($id);
        //delete anamneses with visit.id
        Anamnesis::where('visit_registration_id', $visit->visit_registration_id)->delete();
        Service::where('service_visit_registration_id', $visit->visit_registration_id)->delete();
        $visit->delete();

        return redirect()->route('visits.index')->with('success', 'Visit deleted successfully.');
    }
    public function destroyserverside($id)
    {
        $visit = Visit::findOrFail($id);
        //delete anamneses with visit.id
        Anamnesis::where('visit_registration_id', $visit->visit_registration_id)->delete();
        Service::where('service_visit_registration_id', $visit->visit_registration_id)->delete();
        $visit->delete();
        return redirect()->route('visits.serverside')->with('success', 'Visit deleted successfully.');
    }


    //Update Service Detail Add And Delete Row
    public function serviceupdate(Request $request, $id)
    {
        $visit = Visit::findOrFail($id);
        $request->validate([
            'test_code' => 'required',
            'test_group' => 'required',
            'test_method' => 'required',
            'test_price' => 'required',
            'test_loinc_code' => 'required',
        ]);
        // dd($request->all());
        if (count($request->test_code) > 0) {
            foreach ($request->test_code as $key => $value) {
                $lab = Laboratory::where('test_code', $value)->first();
                DB::table('services_detail')->insert([
                    'service_visit_registration_id' => $visit->visit_registration_id,
                    'service_visit_encounter_id' => $visit->visit_encounter_id,
                    'service_visit_encoded' => $visit->visit_encoded,
                    'service_visit_patient_mr' => $visit->visit_patient_mr,
                    'service_loinc_code' => $lab->test_loinc_code,
                    'service_loinc_display' => $lab->test_loinc_display,
                    'service_code' => $lab->test_code,
                    'service_name' => $lab->test_name,
                    'service_group' => $lab->test_group,
                    'service_subgroup' => $lab->test_subgroup,
                    'service_result' => '',
                    'service_price' => $lab->test_price,
                    'service_quantity' => 1,
                    'service_notes' => '',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            }
            //check charge value
            if ($visit->visit_payment_charge == NULL) {
                $charge = 0;
            } else {
                $charge = intval($visit->visit_payment_charge);
            }
            // update visit_payment_charge on visits table
            foreach ($request->test_code as $key => $value) {
                $lab = Laboratory::where('test_code', $value)->first();
                $charge += $lab->test_price;
            }
            // dd($charge);
            $visit->visit_payment_charge = $charge;
            $visit->visit_payment_remaining = $charge;
            $visit->visit_status_timeline = 'Sampling';
            $visit->updated_at = now();
            $visit->save();
        }
        return redirect(route('visits.index'))->with('success', 'Service updated successfully.');
        ;
    }
    //update validate
    public function updatefinish(Request $request, $noreg)
    {
        $request->validate([
            'visit_status_timeline' => 'required',
            'visit_date_arrived' => 'required',
            'visit_date_progress' => 'required',
        ]);

        $timenow = date("Y-m-d H:i:s");
        Visit::where('visit_registration_id', $noreg)
            ->update([
                'visit_status_timeline' => $request->visit_status_timeline,
                'visit_date_finished' => $timenow,
            ]);

        // Format Agnostic PUT
        // All resources except Bundle
        $patients = Visit::where('visit_registration_id', $noreg)->first();
        $conditions = Anamnesis::where('visit_registration_id', $noreg)->first();

        $encounter = $request->visit_encounter_id;
        $arrived = $request->visit_date_arrived;
        $progresstart = $request->visit_date_progress;
        $progresend = $patients->visit_time_receive;
        $finish = $timenow;

        $RegistrationId = $patients->visit_registration_id;
        $ConsultationMethod = $patients->visit_method;
        $SubjectId = $patients->visit_patient_ihs;
        $SubjectName = $patients->visit_patient_name;
        $ParticipantId = $patients->visit_doctor_id;
        $ParticipantName = $patients->visit_doctor_name;
        $LocationId = $patients->visit_location_id;
        $LocationName = $patients->visit_location_name;

        $icd10 = $patients->visit_icd10_code;
        // MAKE ENCOUNTER JSON
        $encounterID = $patients->visit_encounter_id;
        $conditionID = $conditions->condition_id;
        $client = new OAuth2Client;
        $encounter = new Encounter;
        // $encounter->setID($encounterID);
        $encounter->addRegistrationId($RegistrationId);
        $encounter->setConsultationMethod($ConsultationMethod); // RAJAL, IGD, RANAP, HOMECARE, TELEKONSULTASI
        $encounter->setSubject($SubjectId, $SubjectName); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $encounter->addParticipant($ParticipantId, $ParticipantName);// ID SATUSEHAT Dokter, Nama Dokter
        $encounter->addDiagnosis($conditionID, $icd10);
        $encounter->addLocation($LocationId, $LocationName);
        $encounter->setArrived($arrived);
        $encounter->setInProgress($progresstart, $progresend);
        $encounter->setFinished($finish);
        //CARA 1
        // $body = $encounter->json(); //MAKE ENCOUNTER JSON AS BODY
        // dd($body); //TEST JSON FORMAT
        //  //PUT Agnostic
        // $resource = "Encounter";
        // [$statusCode, $response] = $client->ss_put($resource, $encounterID, $body);
        //CARA 2
        [$statusCode, $response] = $encounter->put($encounterID);
        // dd($statusCode);
        if ($statusCode == 200) {
            return redirect()->route('visits.index')->with('success', 'Visit Finished and Recorded to FHIR SatuSehat Successfully');
        } else {
            return redirect()->route('visits.index')->with('warning', 'Visit Finished, FHIR SatuSehat Recording Failed');
        }

    }
    // Delete Service Detail
    public function deleteservices($id)
    {
        $service = Service::findOrFail($id);
        $visit = Visit::where('visit_registration_id', $service->service_visit_registration_id)->first();
        $charge = $visit->visit_payment_charge;
        $charge -= $service->service_price;
        $visit->visit_payment_charge = $charge;
        $visit->visit_payment_remaining = $charge;
        $visit->updated_at = now();
        $visit->save();
        $service->delete();
        return response()->json([
            'success' => true,
            'message' => 'Laboratory order deleted successfully.',
        ]);
    }
}
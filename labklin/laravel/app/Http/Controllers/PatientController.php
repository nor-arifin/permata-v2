<?php

namespace App\Http\Controllers;

use App\Models\Icd10;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Models\ProvinceModel;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Satusehat\Integration\FHIR\Patient as FHIRPatient;

class PatientController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'registration';
        $submenu = 'patients';
        $patients = DB::table('patients')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('patient_name', 'like', '%' . $name . '%');
            })
            ->orderBy('patient_mr', 'desc')
            ->limit(200)
            ->paginate(10);

        return view('pages.patients.index', compact('patients', 'menu', 'submenu'));
    }
    //create
    public function create()
    {
        $menu = 'registration';
        $submenu = 'patients';
        // SCRIPT GENERATE NOMOR RM
        $patients = Patient::orderBy('patient_mr', 'desc')->value('patient_mr'); // gets only the id
        if ($patients == NULL) {
            $lastrm = 0;
        } else {
            $lastrm = $patients;
        }
        $nowrm = $lastrm + 1;
        $autorm = sprintf("%06d", $nowrm);

        $provinsi = ProvinceModel::all();

        return view('pages.patients.create', compact('autorm', 'provinsi', 'menu', 'submenu'));
    }
    // store
    public function store(Request $request)
    {
        $request->validate([
            'patient_mr' => 'required|unique:patients,patient_mr|min_digits:6|max_digits:6',
            'patient_ihs' => 'nullable',
            'patient_nik' => 'required|unique:patients,patient_nik|min_digits:16|max_digits:16',
            'patient_name' => 'required',
            'patient_title' => 'required', //Added
            'patient_gender' => 'required',
            'patient_birthplace' => 'required',
            'patient_birthdate' => 'required',
            'patient_telecom' => 'required',
            'patient_religion' => 'required', //Added
            'patient_address_line' => 'required',
            'patient_address_city' => 'required',
            'patient_address_extension' => 'required',
            'patient_code_province' => 'required',
            'patient_code_city' => 'required',
            'patient_code_district' => 'required',
            'patient_code_village' => 'required',
            'patient_marital_status' => 'required',
            'patient_status' => 'required', //Added
            'patient_profession' => 'required',
            'patient_bloodtype' => 'required',
        ]);
        $patient_ihs = $request->patient_ihs;
        $patient_identifier = "nik";
        $patient_nik = $request->patient_nik;
        $patient_name = $request->patient_name;
        $patient_telecom = $request->patient_telecom;
        $patient_gender = $request->patient_gender;
        $patient_birthdate = $request->patient_birthdate;
        $patient_address_line = $request->patient_address_line;
        $patient_address_city = $request->patient_address_city;
        $patient_code_province = $request->patient_code_province;
        $patient_code_city = $request->patient_code_city;
        $patient_code_district = $request->patient_code_district;
        $patient_code_village = $request->patient_code_village;
        $patient_code_rt = $request->patient_code_rt;
        $patient_code_rw = $request->patient_code_rw;
        $patient_marital_status = $request->patient_marital_status;
        if ($patient_marital_status == "M") {
            $patient_marital_display = "married";
        } elseif ($patient_marital_status == "S") {
            $patient_marital_display = "never";
        } elseif ($patient_marital_status == "D") {
            $patient_marital_display = "divorced";
        } elseif ($patient_marital_status == "W") {
            $patient_marital_display = "widowed";
        }
        $patient_relationship_name = $request->patient_relationship_name;
        $patient_relationship_phone = $request->patient_relationship_phone;


        if (empty($patient_ihs)) {
            // Patient
            $patient = new FHIRPatient;
            $patient->addIdentifier($patient_identifier, $patient_nik);
            $patient->setName($patient_name);
            /*
             *  Defaultnya adalah nomor telepon. Kalau ingin yang lain bisa seperti
             *  $patient->addTelecom('{telecom_value}', '{telecom_system}', '{telecom_use}')
             *  Telecom system : https://www.hl7.org/fhir/R4/valueset-contact-point-system.html
             *  Telecom use : https://www.hl7.org/fhir/R4/valueset-contact-point-use.html
             */
            $patient->addTelecom($patient_telecom);
            $address_detail = [
                'address' => $patient_address_line,
                'city' => $patient_address_city,
                'postalCode' => $patient_code_district,
                'country' => 'ID', // Kode negara
                'provinceCode' => $patient_code_province,
                'cityCode' => $patient_code_city,
                'districtCode' => $patient_code_district,
                'villageCode' => $patient_code_village,
                'rt' => $patient_code_rt,
                'rw' => $patient_code_rw,
            ];
            $patient->setGender($patient_gender);
            $patient->setBirthDate($patient_birthdate);
            $patient->setDeceased(false);
            $patient->setAddress($address_detail);
            $patient->setMaritalStatus($patient_marital_display); // Married, unmarried, never, divorced, widowed
            $patient->setMultipleBirth(1); // menunjukkan urutan kelahiran yang sebenarnya
            if ($patient_relationship_name == null) {
                $patient->setEmergencyContact('Tidak Ada', $patient_telecom);
            } else {
                $patient->setEmergencyContact($patient_relationship_name, $patient_relationship_phone);
            }
            $patient->setCommunication(); // Bahasa pasien, default Indonesian
            // $body = $patient->json();
            // dd($body);
            // POST Patient
            [$statusCode, $response] = $patient->post();
            // GET Patient ID
            // dd($statusCode, $response);
            if ($statusCode == 201) {
                $generated_patient_ihs = $response->data->id;
                $generated_patient_status = "active";
            } elseif ($statusCode == 400) {
                $generated_patient_ihs = $response->data->resourceID;
                $generated_patient_status = "active";
            } else {
                $generated_patient_ihs = date('YmdHis');
                $generated_patient_status = "active";
            }
        } else {
            $generated_patient_ihs = $request->patient_ihs;
            $generated_patient_status = $request->patient_status;
        }

        $patients = new Patient;
        $patients->patient_mr = $request->patient_mr;
        $patients->patient_nik = $request->patient_nik;
        $patients->patient_status = $generated_patient_status; //Added
        $patients->patient_ihs = $generated_patient_ihs;
        $patients->patient_name = $request->patient_name;
        $patients->patient_title = $request->patient_title; //Added
        $patients->patient_gender = $request->patient_gender;
        $patients->patient_birthplace = $request->patient_birthplace;
        $patients->patient_birthdate = $request->patient_birthdate;
        $patients->patient_telecom = $request->patient_telecom;
        $patients->patient_email = $request->patient_email;
        $patients->patient_religion = $request->patient_religion; //Added
        $patients->patient_address_line = $request->patient_address_line;
        $patients->patient_address_city = $request->patient_address_city;
        $patients->patient_address_extension = $request->patient_address_extension;
        $patients->patient_code_province = $request->patient_code_province;
        $patients->patient_code_city = $request->patient_code_city;
        $patients->patient_code_district = $request->patient_code_district;
        $patients->patient_code_village = $request->patient_code_village;
        $patients->patient_code_rt = $request->patient_code_rt;
        $patients->patient_code_rw = $request->patient_code_rw;
        $patients->patient_marital_status = $request->patient_marital_status;
        $patients->patient_relationship_name = $request->patient_relationship_name;
        $patients->patient_relationship_phone = $request->patient_relationship_phone;
        $patients->patient_profession = $request->patient_profession;
        $patients->patient_bloodtype = $request->patient_bloodtype;
        $patients->save();
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }
    //edit
    public function edit($id)
    {
        $patient = Patient::findOrFail($id);
        $provinsi = ProvinceModel::all();
        $menu = 'registration';
        $submenu = 'patients';
        return view('pages.patients.edit', compact('patient', 'provinsi', 'menu', 'submenu'));
    }
    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'patient_ihs' => 'nullable',
            'patient_nik' => 'required|min_digits:16|max_digits:16',
            'patient_name' => 'required',
            'patient_title' => 'required', //Added
            'patient_gender' => 'required',
            'patient_birthplace' => 'required',
            'patient_birthdate' => 'required',
            'patient_telecom' => 'required',
            'patient_religion' => 'required', //Added
            'patient_marital_status' => 'required',
            'patient_status' => 'required', //Added
            'patient_profession' => 'required',
            'patient_bloodtype' => 'required',
        ]);
        //CEK
        if ($request->patient_address_line == "") {
            $address = $request->old_patient_address_line;
        } else {
            $address = $request->patient_address_line;
        }

        if ($request->patient_address_city == "") {
            $city = $request->old_patient_address_city;
        } else {
            $city = $request->patient_address_city;
        }
        //PROVINCE
        if ($request->patient_code_province == "") {
            $code_province = $request->old_patient_code_province;
        } else {
            $code_province = $request->patient_code_province;
        }
        //CITY
        if ($request->patient_code_city == "") {
            $code_city = $request->old_patient_code_city;
        } else {
            $code_city = $request->patient_code_city;
        }
        //DISTRICT
        if ($request->patient_code_district == "") {
            $code_district = $request->old_patient_code_district;
        } else {
            $code_district = $request->patient_code_district;
        }
        //VILLAGE
        if ($request->patient_code_village == "") {
            $code_village = $request->old_patient_code_village;
        } else {
            $code_village = $request->patient_code_village;
        }
        //RT
        if ($request->patient_code_rt == "") {
            $code_rt = $request->old_patient_code_rt;
        } else {
            $code_rt = $request->patient_code_rt;
        }
        //RW
        if ($request->patient_code_rw == "") {
            $code_rw = $request->old_patient_code_rw;
        } else {
            $code_rw = $request->patient_code_rw;
        }

        $patient = Patient::findOrFail($id);
        $patient->patient_nik = $request->patient_nik;
        $patient->patient_kk = $request->patient_kk;
        $patient->patient_status = $request->patient_status; //Added
        $patient->patient_ihs = $request->patient_ihs;
        $patient->patient_name = $request->patient_name;
        $patient->patient_title = $request->patient_title; //Added
        $patient->patient_gender = $request->patient_gender;
        $patient->patient_birthplace = $request->patient_birthplace;
        $patient->patient_birthdate = $request->patient_birthdate;
        $patient->patient_telecom = $request->patient_telecom;
        $patient->patient_email = $request->patient_email;
        $patient->patient_religion = $request->patient_religion; //Added
        $patient->patient_address_line = $address;
        $patient->patient_address_city = $city;
        $patient->patient_address_extension = $request->patient_address_extension;
        $patient->patient_code_province = $code_province;
        $patient->patient_code_city = $code_city;
        $patient->patient_code_district = $code_district;
        $patient->patient_code_village = $code_village;
        $patient->patient_code_rt = $code_rt;
        $patient->patient_code_rw = $code_rw;
        $patient->patient_marital_status = $request->patient_marital_status;
        $patient->patient_relationship_name = $request->patient_relationship_name;
        $patient->patient_relationship_phone = $request->patient_relationship_phone;
        $patient->patient_profession = $request->patient_profession;
        $patient->patient_bloodtype = $request->patient_bloodtype;
        $patient->patient_bpjs = $request->patient_bpjs;
        $patient->save();
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }
    //destroy
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
    //destroyserverside
    public function destroyserverside($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();
        return redirect()->route('patients.serverside')->with('success', 'Patient deleted successfully.');
    }
    //serverside
    public function serverside()
    {
        $menu = 'master';
        $submenu = 'patients';
        $patients = Patient::all();
        return view('pages.patients.indexserverside', compact('patients', 'menu', 'submenu'));
    }
    public function datatablejson()
    {
        $menu = 'registration';
        $submenu = 'patients';
        $patients = Patient::all();
        return DataTables::of($patients)->addIndexColumn()
            ->addColumn('action', function ($patients) {
                $button =
                    '<div class="d-flex justify-content-center">
                <a href="' . route("patients.edit", $patients->id) . '"
                    class="btn btn-sm btn-warning btn-icon">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="' . route("print.record", $patients->patient_mr) . '"
                    class="btn btn-sm btn-primary btn-icon ml-2">
                    <i class="fas fa-credit-card"></i>
                </a>
                <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                    data-toggle="modal" data-target="#deleteModal' . $patients->id . '"><i class="fas fa-trash"></i>
                </button>
            </div>';
                return $button;
            })
            ->addColumn('patient_gender', function ($patients) {
                if ($patients->patient_gender == 'male') {
                    return 'Male';
                } else {
                    return 'Female';
                }
            })
            ->addColumn('patient_status', function ($patients) {
                if ($patients->patient_status == 'active') {
                    return 'Active';
                } else if ($patients->patient_status == 'registered') {
                    return 'Registered';
                } else if ($patients->patient_status == 'inactive') {
                    return 'Inactive';
                }
            })
            ->make(true);
    }

    public function datatablejsonvisit()
    {
        $menu = 'registration';
        $submenu = 'patients';
        $patients = Patient::all();
        return DataTables::of($patients)->addIndexColumn()
            ->addColumn('action', function ($patients) {
                $button =
                    '<div class="d-flex justify-content-center">
                <button class="btn btn-sm btn-success btn-icon confirm-delete ml-2"
                    id="select" data-ihs="' . $patients->patient_ihs . '" data-mr="' . $patients->patient_mr . '" data-name="' . $patients->patient_name . '" data-birthdate="' . $patients->patient_birthdate . '" data-birthplace="' . $patients->patient_birthplace . '" data-telecom="' . $patients->patient_telecom . '"><i class="fas fa-check"></i>
                </button>
            </div>';
                return $button;
            })
            ->addColumn('patient_gender', function ($patients) {
                if ($patients->patient_gender == 'male') {
                    return 'Male';
                } else {
                    return 'Female';
                }
            })
            ->addColumn('patient_status', function ($patients) {
                if ($patients->patient_status == 'active') {
                    return 'Active';
                } else if ($patients->patient_status == 'registered') {
                    return 'Registered';
                } else if ($patients->patient_status == 'inactive') {
                    return 'Inactive';
                }
            })
            ->make(true);
    }

    // SATU SEHAT API
    // public function getbyid($id)
    // {
    //     $nik = $id;
    //     $client_id = "XVFWGeUadhRKmAC1WH26mLm6mCE9GD99jzAmad3vaOjXt7JD";
    //     $client_secret = "GvrYqRdVcYHNBroABoIdd7hHrgolVuwdutAY25EhuU44kMks0iCJ3cxGM2awzyau";
    //     $url = "https://api-satusehat-stg.dto.kemkes.go.id/oauth2/v1/accesstoken?grant_type=client_credentials";
    //     $urlpatient = "https://api-satusehat-stg.dto.kemkes.go.id/fhir-r4/v1/Patient";

    //     $response = Http::asForm()->post($url, [
    //         'client_id' => $client_id,
    //         'client_secret' => $client_secret,
    //     ]);

    //     $token = $response['access_token'];

    //     $response2 = Http::withToken($token)->get($urlpatient, [
    //         'identifier' => 'https://fhir.kemkes.go.id/id/nik|' . $nik,
    //     ]);
    //     $data = $response2; //JIKA AMBIL SEMUA JSON
    //     return $data;
    // }

}

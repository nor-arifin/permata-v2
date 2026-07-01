<?php

namespace App\Http\Controllers;

use App\Models\Consent;
use App\Models\Kesmas;
use App\Models\Visit;
use App\Models\Service;
use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PdfController extends Controller
{
    protected $fpdf;

    // public function __construct()
    // {
    //     $this->fpdf = new Fpdf;
    // }

    public function index()
    {
        $this->fpdf = new Fpdf;
        $this->fpdf->SetFont('Arial', 'B', 15);
        $this->fpdf->AddPage("L", ['100', '100']);
        $this->fpdf->Text(10, 10, "Hello World!");

        $this->fpdf->Output();

        exit;
    }
    // UNTUK MENGEDIT PDF di Vendor\Codedge\Fpdf\Fpdf;
    public function receipt($id)
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
        $services = $services->where('services_detail.service_price', '!=', 0);
        $services = $services->select('services_detail.*');
        $services = $services->orderBy('services_detail.id', 'asc');
        $services = $services->get();
        //make pdf view
        return view('pages.visits.receipt', compact('visit', 'patient', 'services'));
    }

    public function receiptkm($id)
    {
        $kesmas = Kesmas::findOrFail($id);
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $kesmas->id)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $kesmas->id)->first();
        $payment = DB::table('payment_details')->where('payment_order_id', $kesmas->id)->first();
        $data = compact('kesmas', 'customers', 'samples', 'parameters', 'additional', 'payment');
        // dd($data);
        //make pdf view
        return view('pages.kesmas.receipt', $data);
    }
    public function receiptpks($id)
    {
        $kesmas = Kesmas::findOrFail($id);
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $kesmas->id)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $kesmas->id)->first();
        $payment = DB::table('payment_details')->where('payment_order_id', $kesmas->id)->first();
        $data = compact('kesmas', 'customers', 'samples', 'parameters', 'additional', 'payment');
        // dd($data);
        //make pdf view
        return view('pages.kesmas.receiptpks', $data);
    }

    public function labreport($regno)
    {

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

        $onepage = [
            'Hematology',
            'Urinology',
            // 'Biochemistry',
            // 'Serology',
            // 'Immunology',
            // 'Microbiology',
            // 'Parasitology',
            // 'Histopathology',
            // 'Cytopathology',
            // 'Blood Bank',
        ];
        // GET LABORATORY RESULTS
        $results = Service::where('service_visit_registration_id', $regno)
            ->whereNotIn('service_group', $onepage)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            // ->whereNotNull('services_detail.service_result')
            ->select(
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
                'services_detail.service_group',
                'services_detail.service_subgroup',
                'services_detail.id',
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
            )
            ->orderBy('services_detail.service_group', 'asc')
            ->orderBy('services_detail.service_subgroup', 'asc')
            // ->orderBy('services_detail.id', 'asc')
            ->orderBy('services_detail.created_at', 'asc')
            ->get();

        //GET RESULTS HEMATOLOGY
        $resultshematology = Service::where('service_visit_registration_id', $regno)
            ->where('service_group', "Hematology")
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            // ->whereNotNull('services_detail.service_result')
            ->select(
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
                'services_detail.service_group',
                'services_detail.service_subgroup',
                'services_detail.id',
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
            )
            ->orderBy('services_detail.service_group', 'asc')
            // ->orderBy('services_detail.service_subgroup', 'asc')
            // ->orderBy('services_detail.id', 'asc')
            ->orderBy('services_detail.created_at', 'asc')
            ->get();

        //GET RESULTS URIN
        $resultsurinology = Service::where('service_visit_registration_id', $regno)
            ->where('service_group', "Urinology")
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->select(
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
                'services_detail.service_group',
                'services_detail.service_subgroup',
                'services_detail.id',
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
            )
            ->orderBy('services_detail.service_group', 'asc')
            // ->orderBy('services_detail.service_subgroup', 'asc')
            // ->orderBy('services_detail.id', 'asc')
            ->orderBy('services_detail.created_at', 'asc')
            ->get();
        // dd($results, $resultshematology, $resultsurinology);
        //make pdf view
        return view('pages.laboratory.print', compact('visit', 'patient', 'anamneses', 'results', 'resultshematology', 'resultsurinology'));
    }
    public function verifylabreport($encoded)
    {
        $visit = Visit::where('visit_encoded', $encoded)
            ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->first();

        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_encoded', '=', $encoded);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();

        //join table anamneses with visits by visit_registration_id
        $anamneses = DB::table('anamneses');
        $anamneses = $anamneses->join('visits', 'anamneses.visit_registration_id', '=', 'visits.visit_registration_id');
        $anamneses = $anamneses->where('visits.visit_encoded', '=', $encoded);
        $anamneses = $anamneses->select('anamneses.*');
        $anamneses = $anamneses->first();

        $onepage = [
            'Hematology',
            'Urinology',
            // 'Biochemistry',
            // 'Serology',
            // 'Immunology',
            // 'Microbiology',
            // 'Parasitology',
            // 'Histopathology',
            // 'Cytopathology',
            // 'Blood Bank',
        ];
        // GET LABORATORY RESULTS
        $results = Service::where('service_visit_encoded', $encoded)
            ->whereNotIn('service_group', $onepage)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            // ->whereNotNull('services_detail.service_result')
            ->select(
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
                'services_detail.service_group',
                'services_detail.service_subgroup',
                'services_detail.id',
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
            )
            ->orderBy('services_detail.service_group', 'asc')
            ->orderBy('services_detail.service_subgroup', 'asc')
            // ->orderBy('services_detail.id', 'asc')
            ->orderBy('services_detail.created_at', 'asc')
            ->get();

        //GET RESULTS HEMATOLOGY
        $resultshematology = Service::where('service_visit_encoded', $encoded)
            ->where('service_group', "Hematology")
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            // ->whereNotNull('services_detail.service_result')
            ->select(
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
                'services_detail.service_group',
                'services_detail.service_subgroup',
                'services_detail.id',
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
            )
            ->orderBy('services_detail.service_group', 'asc')
            // ->orderBy('services_detail.service_subgroup', 'asc')
            // ->orderBy('services_detail.id', 'asc')
            ->orderBy('services_detail.created_at', 'asc')
            ->get();

        //GET RESULTS URIN
        $resultsurinology = Service::where('service_visit_encoded', $encoded)
            ->where('service_group', "Urinology")
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->select(
                'services_detail.service_code',
                'services_detail.service_name',
                'services_detail.service_result',
                'services_detail.service_time_result',
                'services_detail.service_reference',
                'services_detail.service_group',
                'services_detail.service_subgroup',
                'services_detail.id',
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
            )
            ->orderBy('services_detail.service_group', 'asc')
            // ->orderBy('services_detail.service_subgroup', 'asc')
            // ->orderBy('services_detail.id', 'asc')
            ->orderBy('services_detail.created_at', 'asc')
            ->get();
        // dd($results, $resultshematology, $resultsurinology);
        //make pdf view
        return view('pages.laboratory.print', compact('visit', 'patient', 'anamneses', 'results', 'resultshematology', 'resultsurinology'));

    }
    public function verifylabreportold($encoded)
    {

        $visit = Visit::where('visit_encoded', $encoded)
            ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->first();
        // dd($visit);

        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr');
        $patient = $patient->where('visits.visit_encoded', '=', $encoded);
        $patient = $patient->select('patients.*', 'visits.*');
        $patient = $patient->first();

        //join table anamneses with visits by visit_registration_id
        $anamneses = DB::table('anamneses');
        $anamneses = $anamneses->join('visits', 'anamneses.visit_registration_id', '=', 'visits.visit_registration_id');
        $anamneses = $anamneses->where('visits.visit_encoded', '=', $encoded);
        $anamneses = $anamneses->select('anamneses.*');
        $anamneses = $anamneses->first();
        //GET LABORATORY RESULTS
        $results = Service::where('service_visit_encoded', $encoded)
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
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
            )
            ->orderBy('services_detail.id', 'asc')
            ->get();
        //make pdf view
        return view('pages.laboratory.print', compact('visit', 'patient', 'anamneses', 'results'));
    }

    public function verifylhu($encoded)
    {
        $kesmas = DB::table('kesmas_orders')->where('order_encode', $encoded)->first();
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $kesmas->id)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $kesmas->id)->first();
        $payment = DB::table('payment_details')->where('payment_order_id', $kesmas->id)->first();
        $review = DB::table('kesmas_reviews')
            ->join('users', 'kesmas_reviews.review_by', '=', 'users.id')
            ->select('kesmas_reviews.*', 'users.name as reviewer')
            ->where('review_code', $kesmas->id)->first();
        $paper = 'lhu-kesmas';
        $data = compact('kesmas', 'customers', 'samples', 'parameters', 'additional', 'payment', 'review', 'paper');
        // dd($data);
        //make pdf view
        // dd($data);
        return view('pages.kesmas.print', $data);
    }

    public function verifylhukan($encoded)
    {
        $kesmas = DB::table('kesmas_orders')->where('order_encode', $encoded)->first();
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $kesmas->id)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $kesmas->id)->first();
        $payment = DB::table('payment_details')->where('payment_order_id', $kesmas->id)->first();
        $review = DB::table('kesmas_reviews')
            ->join('users', 'kesmas_reviews.review_by', '=', 'users.id')
            ->select('kesmas_reviews.*', 'users.name as reviewer')
            ->where('review_code', $kesmas->id)->first();
        $paper = 'lhu-kesmas';
        $data = compact('kesmas', 'customers', 'samples', 'parameters', 'additional', 'payment', 'review', 'paper');
        // dd($data);
        //make pdf view
        // dd($data);
        return view('pages.kesmas.printkan', $data);
    }

    public function record($patient_mr)
    {

        // $visit = Visit::where('visit_encoded', $encoded)
        // ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
        // ->first();

        //Data Patient
        $patient = DB::table('patients')
            ->join('visits', 'patients.patient_mr', '=', 'visits.visit_patient_mr')
            ->where('patients.patient_mr', '=', $patient_mr)
            ->orderBy('visits.id', 'desc')
            ->first();

        $visit = Visit::where('visit_patient_mr', $patient_mr)
            ->join('anamneses', 'anamneses.visit_registration_id', '=', 'visits.visit_registration_id')
            ->groupBy('visits.visit_registration_id')
            ->get();


        //make pdf view
        return view('pages.patients.record', compact('patient', 'visit'));
    }

    public function label($id)
    {

        $label = DB::table('visits')
            ->where('visit_registration_id', $id)
            ->join('services_detail', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->join('patients', 'visits.visit_patient_mr', '=', 'patients.patient_mr')
            ->groupBy('laboratories.test_container')
            ->select('laboratories.test_container', 'visits.visit_patient_name', 'visits.visit_date', 'visits.visit_registration_id', 'patients.patient_gender', 'patients.patient_birthdate', 'patients.patient_mr')
            ->get();

        // dd($label);

        //make pdf view
        return view('pages.laboratory.label', compact('label'));
    }

    public function labelkm($id)
    {

        $label = DB::table('kesmas_orders')
            ->where('kesmas_orders.id', $id)
            ->join('kesmas_order_samples', 'kesmas_order_samples.order_code', '=', 'kesmas_orders.id')
            ->join('kesmas_customers', 'kesmas_customers.customer_code', '=', 'kesmas_orders.order_customer')
            // ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            // ->join('patients', 'visits.visit_patient_mr', '=', 'patients.patient_mr')
            // ->groupBy('kesmas_order_samples.test_container')
            ->select(
                'kesmas_orders.order_code as fpps',
                'kesmas_orders.order_date as date',
                'kesmas_orders.order_type as division',
                'kesmas_order_samples.sample_code as sample_code',
                'kesmas_order_samples.sample_type as sample_type',
                'kesmas_order_samples.sample_container as container',
                'kesmas_order_samples.sample_volume as volume',
                'kesmas_order_samples.sample_description as desc',
                'kesmas_order_samples.sample_note as note',
                'kesmas_customers.customer_name as name',
                'kesmas_customers.customer_code as code',
            )
            ->get();
        //make pdf view
        return view('pages.laboratory.labelkm', compact('label'));
    }
    public function consent($id)
    {
        $consent = Consent::findOrFail($id);
        $mr = $consent->consent_patient_mr;
        //join table visits with patients by patient_mr
        $patient = DB::table('patients');
        $patient = $patient->where('patients.patient_mr', '=', $mr);
        $patient = $patient->first();
        $data = compact('consent', 'patient');
        // dd($data);
        //make pdf view
        return view('pages.consents.inform', compact('consent', 'patient'));
    }
    
    public function verifynafza($encoded)
    {

        $regnapza = DB::table('register_napza')
            ->join('visits', 'register_napza.letter_napza_lhu', '=', 'visits.visit_registration_id')
            ->where('register_napza.letter_napza_encode', $encoded)
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
}
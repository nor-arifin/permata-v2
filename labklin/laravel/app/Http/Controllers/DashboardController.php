<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $menu = 'dashboard';
        $submenu = 'general';
        //TOTAL
        $patients = DB::table('patients')->get();
        $visits = DB::table('visits')->get();
        $laboratories = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')->get();
        $reports = DB::table('visits')
            ->where('visit_status_timeline', 'Finished')->get();

        //MONTH
        $patient = DB::table('patients')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')->get();
        $visit = DB::table('visits')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')->get();
        $report = DB::table('visits')
            ->where('visit_status_timeline', 'Finished')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')->get();
        $laboratory = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->get();
        $laboratorydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_result')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->get();
        $revenue = DB::table('visits')
            ->whereNotNull('visit_payment_amount')
            ->where('updated_at', 'like', '%' . date('Y-m') . '%')->get();
        $amount = $revenue->sum('visit_payment_amount');


        //TODAY
        $patientd = DB::table('patients')
            ->where('created_at', 'like', '%' . date('Y-m-d') . '%')->get();
        $visitd = DB::table('visits')
            ->where('created_at', 'like', '%' . date('Y-m-d') . '%')->get();
        $laboratoryd = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->where('created_at', 'like', '%' . date('Y-m-d') . '%')
            ->get();
        $revenued = DB::table('visits')
            ->whereNotNull('visit_payment_amount')
            ->where('updated_at', 'like', '%' . date('Y-m-d') . '%')->get();
        $amountd = $revenued->sum('visit_payment_amount');

        //LAB
        $collection = DB::table('visits')
            ->whereNull('visit_time_sampling')
            ->get()->count();
        $collectiondone = DB::table('visits')
            ->whereNotNull('visit_time_sampling')
            ->where('visit_time_sampling', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $receive = DB::table('visits')
            ->whereNotNull('visit_time_sampling')
            ->whereNull('visit_time_receive')
            ->get()->count();
        $receivedone = DB::table('visits')
            ->whereNotNull('visit_time_sampling')
            ->whereNotNull('visit_time_receive')
            ->where('visit_time_receive', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $test = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNull('service_time_result')
            ->get()->count();
        $testdone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_result')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $validation = DB::table('visits')
            ->whereNull('visit_time_validation')
            ->get()->count();
        $validationdone = DB::table('visits')
            ->whereNotNull('visit_time_validation')
            ->where('visit_time_validation', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();

        //CHART
        $data = DB::table('visits')
            ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(visit_registration_id) as totalvisit, SUM(visit_payment_amount) as totalrevenue'))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->orderBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
            ->get();

        $months = [];
        $totalvisits = [];
        $totalrevenues = [];

        foreach ($data as $row) {
            $months[] = $row->month . '/' . $row->year;
            $totalvisits[] = $row->totalvisit;
            $totalrevenues[] = $row->totalrevenue;
        }

        return view('dashboard', compact
        (
            'patients',
            'visits',
            'laboratories',
            'reports',
            'patient',
            'visit',
            'laboratory',
            'laboratoryd',
            'laboratorydone',
            'report',
            'patientd',
            'visitd',
            'amount',
            'amountd',
            'collection',
            'collectiondone',
            'receive',
            'receivedone',
            'test',
            'testdone',
            'validation',
            'validationdone',
            'months',
            'totalvisits',
            'totalrevenues',
            'menu',
            'submenu'
        ));
    }
    public function dashboardlab(Request $request)
    {
        $menu = 'dashboard';
        $submenu = 'dashboardlab';

        //LAB
        $collection = DB::table('visits')
            ->whereNull('visit_time_sampling')
            ->get()->count();
        $collectiondone = DB::table('visits')
            ->whereNotNull('visit_time_sampling')
            ->where('visit_time_sampling', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $receive = DB::table('visits')
            ->whereNotNull('visit_time_sampling')
            ->whereNull('visit_time_receive')
            ->get()->count();
        $receivedone = DB::table('visits')
            ->whereNotNull('visit_time_sampling')
            ->whereNotNull('visit_time_receive')
            ->where('visit_time_receive', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $test = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNull('service_time_result')
            ->get()->count();
        $testdone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_result')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $validation = DB::table('visits')
            ->whereNull('visit_time_validation')
            ->get()->count();
        $validationdone = DB::table('visits')
            ->whereNotNull('visit_time_validation')
            ->where('visit_time_validation', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();

        //GROUPTEST
        $hematology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Hematology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $hematologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Hematology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $biochemistry = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Biochemistry%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $biochemistrydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Biochemistry%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $immunology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Immunology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $immunologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Immunology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $microbiology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Microbiology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $microbiologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Microbiology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $genomics = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Genomics%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $genomicsdone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Genomics%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $toxicology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Toxicology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $toxicologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Toxicology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $serology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Serology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $serologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Serology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $urinology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Urinology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $urinologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Urinology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $bacteriology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Bacteriology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $bacteriologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Bacteriology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $parasitology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Parasitology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $parasitologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Parasitology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $virology = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Virology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $virologydone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Virology%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $other = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Other%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->get()->count();
        $otherdone = DB::table('services_detail')
            ->whereNotNull('service_loinc_code')
            ->whereNotNull('service_price')
            ->where('service_group', 'like', '%Other%')
            ->where('created_at', 'like', '%' . date('Y-m') . '%')
            ->where('service_reference', '!=', 'Terlampir')
            ->where('service_time_result', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();

        //CHART
        // $data = DB::table('services_detail')
        // ->select(DB::raw('MONTH(created_at) as month, YEAR(created_at) as year, COUNT(service_visit_registration_id) as totalorder', ))
        // ->whereYear('created_at', date('Y'))
        // ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
        // ->get();

        //GET DATA SERVICE_GROUP TO CHART
        $data = DB::table('services_detail')
            ->select(DB::raw('service_group, COUNT(service_visit_registration_id) as totalorder', ))
            ->whereYear('created_at', date('Y'))
            ->groupBy(DB::raw('service_group'))
            ->get();

        $group = [];
        $totalorder = [];

        foreach ($data as $row) {
            $group[] = $row->service_group;
            $totalorder[] = $row->totalorder;
        }

        //GET DATA SERVICE_GROUP TO CHART
        $data2 = DB::table('services_detail')
            ->select(DB::raw('service_group as service_groupmonth, COUNT(service_visit_registration_id) as monthtotalorder', ))
            ->whereYear('created_at', date('Y'))
            ->whereMonth('created_at', date('m'))
            ->groupBy(DB::raw('service_group'))
            ->get();

        $monthgroup = [];
        $monthtotalorder = [];

        foreach ($data2 as $row2) {
            $monthgroup[] = $row2->service_groupmonth;
            $monthtotalorder[] = $row2->monthtotalorder;
        }

        return view('dashboardlab', compact
        (
            'collection',
            'collectiondone',
            'receive',
            'receivedone',
            'test',
            'testdone',
            'validation',
            'validationdone',
            'hematology',
            'hematologydone',
            'biochemistry',
            'biochemistrydone',
            'immunology',
            'immunologydone',
            'microbiology',
            'microbiologydone',
            'genomics',
            'genomicsdone',
            'toxicology',
            'toxicologydone',
            'serology',
            'serologydone',
            'urinology',
            'urinologydone',
            'bacteriology',
            'bacteriologydone',
            'parasitology',
            'parasitologydone',
            'virology',
            'virologydone',
            'other',
            'otherdone',
            'group',
            'totalorder',
            'monthgroup',
            'monthtotalorder',
            'menu',
            'submenu'
        ));
    }
    public function dashboardkm(Request $request)
    {
        $menu = 'dashboard';
        $submenu = 'dashboardkm';

        //LAB
        $receive = DB::table('kesmas_orders')
            ->whereNotNull('order_collect')
            ->whereNull('order_receive')
            ->get()->count();
        $receivedone = DB::table('kesmas_orders')
            ->whereNotNull('order_collect')
            ->whereNotNull('order_receive')
            ->where('order_receive', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $test = DB::table('kesmas_orders')
            ->whereNotNull('order_receive')
            ->whereNull('order_process')
            ->get()->count();
        $testdone = DB::table('kesmas_orders')
            ->whereNotNull('order_receive')
            ->whereNotNull('order_process')
            ->where('order_process', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $verify = DB::table('kesmas_orders')
            ->whereNotNull('order_process')
            ->whereNull('order_verify')
            ->get()->count();
        $verifydone = DB::table('kesmas_orders')
            ->whereNotNull('order_process')
            ->whereNotNull('order_verify')
            ->where('order_verify', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();
        $validation = DB::table('kesmas_orders')
            ->whereNotNull('order_verify')
            ->whereNull('order_validate')
            ->get()->count();
        $validationdone = DB::table('kesmas_orders')
            ->whereNotNull('order_verify')
            ->whereNotNull('order_validate')
            ->where('order_validate', 'like', '%' . date('Y-m-d') . '%')
            ->get()->count();

        //STATISTICS KIMIA
        $kimia = DB::table('kesmas_orders')
            ->where('order_type', 'Kimia')
            ->whereNull('order_validate')
            ->get()->count();
        $kimiadone = DB::table('kesmas_orders')
            ->where('order_type', 'Kimia')
            ->where('order_validate', 'like', '%' . date('Y') . '%')
            ->get()->count();
        $kimiareceive = DB::table('kesmas_orders')
            ->where('order_type', 'Kimia')
            ->whereNotNull('order_collect')
            ->whereNull('order_receive')
            ->get()->count();
        $kimiareceived = DB::table('kesmas_orders')
            ->where('order_type', 'Kimia')
            ->whereNotNull('order_collect')
            ->whereNotNull('order_receive')
            ->where('order_receive', 'like', '%' . date('Y') . '%')
            ->get()->count();
        $kimiatest = DB::table('kesmas_orders')
            ->join('kesmas_order_samples', 'kesmas_orders.id', '=', 'kesmas_order_samples.order_code')
            ->where('kesmas_orders.order_type', 'Kimia')
            ->whereNull('kesmas_orders.order_process')
            ->get('kesmas_order_samples.id')->count();
        $kimiatestdone = DB::table('kesmas_orders')
            ->join('kesmas_order_samples', 'kesmas_orders.id', '=', 'kesmas_order_samples.order_code')
            ->where('kesmas_orders.order_type', 'Kimia')
            ->whereNotNull('kesmas_orders.order_process')
            ->where('kesmas_orders.order_process', 'like', '%' . date('Y') . '%')
            ->get('kesmas_order_samples.id')->count();
        $kimiaverify = DB::table('kesmas_orders')
            ->where('order_type', 'Kimia')
            ->whereNotNull('order_process')
            ->whereNull('order_verify')
            ->get()->count();
        $kimiaverifydone = DB::table('kesmas_orders')
            ->where('order_type', 'Kimia')
            ->whereNotNull('order_process')
            ->whereNotNull('order_verify')
            ->where('order_verify', 'like', '%' . date('Y') . '%')
            ->get()->count();
        //STATISTICS MIKRO
        $mikro = DB::table('kesmas_orders')
            ->where('order_type', 'Mikrobiologi')
            ->whereNull('order_validate')
            ->get()->count();
        $mikrodone = DB::table('kesmas_orders')
            ->where('order_type', 'Mikrobiologi')
            ->where('order_validate', 'like', '%' . date('Y') . '%')
            ->get()->count();
        $mikroreceive = DB::table('kesmas_orders')
            ->where('order_type', 'Mikrobiologi')
            ->whereNotNull('order_collect')
            ->whereNull('order_receive')
            ->get()->count();
        $mikroreceived = DB::table('kesmas_orders')
            ->where('order_type', 'Mikrobiologi')
            ->whereNotNull('order_collect')
            ->whereNotNull('order_receive')
            ->where('order_receive', 'like', '%' . date('Y') . '%')
            ->get()->count();
        $mikrotest = DB::table('kesmas_orders')
            ->join('kesmas_order_samples', 'kesmas_orders.id', '=', 'kesmas_order_samples.order_code')
            ->where('kesmas_orders.order_type', 'Mikrobiologi')
            ->whereNull('kesmas_orders.order_process')
            ->get('kesmas_order_samples.id')->count();
        $mikrotestdone = DB::table('kesmas_orders')
            ->join('kesmas_order_samples', 'kesmas_orders.id', '=', 'kesmas_order_samples.order_code')
            ->where('kesmas_orders.order_type', 'Mikrobiologi')
            ->whereNotNull('kesmas_orders.order_process')
            ->where('kesmas_orders.order_process', 'like', '%' . date('Y') . '%')
            ->get('kesmas_order_samples.id')->count();
        $mikroverify = DB::table('kesmas_orders')
            ->where('order_type', 'Mikrobiologi')
            ->whereNotNull('order_process')
            ->whereNull('order_verify')
            ->get()->count();
        $mikroverifydone = DB::table('kesmas_orders')
            ->where('order_type', 'Mikrobiologi')
            ->whereNotNull('order_process')
            ->whereNotNull('order_verify')
            ->where('order_verify', 'like', '%' . date('Y') . '%')
            ->get()->count();

        return view('dashboardkm', compact(
            'receive',
            'receivedone',
            'test',
            'testdone',
            'verify',
            'verifydone',
            'validation',
            'validationdone',
            'kimia',
            'kimiadone',
            'kimiareceive',
            'kimiareceived',
            'kimiatest',
            'kimiatestdone',
            'kimiaverify',
            'kimiaverifydone',
            'mikro',
            'mikrodone',
            'mikroreceive',
            'mikroreceived',
            'mikrotest',
            'mikrotestdone',
            'mikroverify',
            'mikroverifydone',
            'menu',
            'submenu'
        ));
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Visit;
use App\Models\Service;
use App\Exports\ExportLab;
use App\Exports\ExportVisit;
use Illuminate\Http\Request;
use App\Exports\ExportRevenue;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\ExportLabDetail;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
// use App\Imports\SalesImport;

class ReportController extends Controller
{
    public function reportvisit(Request $request)
    {

        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        $sales = Visit::whereYear('visit_date', $year)
                ->whereMonth('visit_date', operator: $month)
                ->orderBy('id', 'desc')
                ->limit(200)
                ->paginate(10);
                // ->get();
                //PERHATIKAN INI JIKA NANTI ADA ERROR PAGINATION
        $totalRevenue = $sales->sum('visit_payment_amount');
        $totalCharge = $sales->sum('visit_payment_charge');
        $totalDiscount = $sales->sum('visit_payment_discount');

        $menu = 'report';
        $submenu = 'reportvisit';

        return view('pages.report.visit', compact('sales','totalRevenue', 'totalCharge', 'totalDiscount', 'menu', 'submenu', 'month', 'year'));
    }

    public function exportExcel(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        return Excel::download(new ExportVisit($month, $year), 'sales_report_'.$month.'_'.$year.'.xlsx');
    }

    public function exportPDF(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        $sales = Visit::whereYear('visit_date', $year)
                ->whereMonth('visit_date', $month)
                ->get();

        $totalRevenue = $sales->sum('visit_payment_amount');
        $totalItemsSold = $sales->sum('visit_payment_charge');
        $pdf = PDF::loadView('pages.report.monthly_pdf', compact('sales', 'totalRevenue', 'totalItemsSold', 'month', 'year'));

        return $pdf->download('visit_report_'.$month.'_'.$year.'.pdf');
    }

    public function reportrevenue(Request $request)
    {

        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        // Ambil data revenue per hari dalam bulan yang dipilih
        $sales = Visit::selectRaw('DATE(visit_date) as date, SUM(visit_payment_charge) as totalcharge, SUM(visit_payment_amount) as totalrevenue, SUM(visit_payment_discount) as totaldiscount')
            ->whereYear('visit_date', $year)
            ->whereMonth('visit_date', $month)
            ->groupBy('date')
            ->orderBy('date')
            ->limit(31)
            ->paginate(10);
        // ->get();
        //PERHATIKAN INI JIKA NANTI ADA ERROR PAGINATION

        $menu = 'report';
        $submenu = 'reportrevenue';

        return view('pages.report.revenue', compact('sales', 'menu', 'submenu', 'month', 'year'));
    }

    public function exportExcelRevenue(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        return Excel::download(new ExportRevenue($month, $year), 'revenue_report_'.$month.'_'.$year.'.xlsx');
    }

    public function exportPDFRevenue(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        $sales = Visit::selectRaw('DATE(visit_date) as date, SUM(visit_payment_charge) as totalcharge, SUM(visit_payment_amount) as totalrevenue, SUM(visit_payment_discount) as totaldiscount')
                ->whereYear('visit_date', $year)
                ->whereMonth('visit_date', $month)
                ->groupBy('date')
                ->orderBy('date')
                ->get();

        $pdf = PDF::loadView('pages.report.monthly_revenue', compact('sales', 'month', 'year'));

        return $pdf->download('revenue_report_'.$month.'_'.$year.'.pdf');
    }
    public function reportlaboratory(Request $request)
    {

        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        // Ambil data revenue per hari dalam bulan yang dipilih
        $labs = Service::selectRaw('DATE(created_at) as date, service_name as test, service_code as code, service_group as grouptest, service_subgroup as subgrouptest, service_price as price, SUM(service_quantity) as quantity')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('service_price')
            ->whereNotNull('service_time_result')
            ->groupBy('test')
            ->orderBy('quantity')
            ->paginate(10);
        // ->get();
        //PERHATIKAN INI JIKA NANTI ADA ERROR PAGINATION

        $menu = 'report';
        $submenu = 'reportlaboratory';

        //DATA FOR CHART
        $data = Service::selectRaw('service_group as datagrouptest, SUM(service_quantity) as dataquantity')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('service_price')
            ->whereNotNull('service_time_result')
            ->groupBy('datagrouptest')
            ->orderBy('dataquantity')
            ->get();

            $datagrouptest = [];
            $dataquantity = [];

        foreach ($data as $row) {
            $datagrouptest[] = $row->datagrouptest;
            $dataquantity[] = $row->dataquantity;
        }

        return view('pages.report.laboratory', compact('labs', 'menu', 'datagrouptest', 'dataquantity', 'submenu', 'month', 'year'));
    }

    public function exportExcelLab(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        return Excel::download(new ExportLab($month, $year), 'lab_report_'.$month.'_'.$year.'.xlsx');
    }

    public function exportPDFLab(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));

        $labs = Service::selectRaw('service_name as test, SUM(service_quantity) as quantity')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('service_price')
            ->whereNotNull('service_time_result')
            ->groupBy('test')
            ->orderBy('quantity')
            ->get();

        $pdf = PDF::loadView('pages.report.monthly_lab', compact('labs', 'month', 'year'));

        return $pdf->download('lab_report_'.$month.'_'.$year.'.pdf');
    }
    public function reportlaboratorydetail(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));
        $code = $request->input('code');

        $labs = DB::table('services_detail')
            ->select('service_code as code', 'services_detail.created_at as date',  'service_result as result',  'service_name as test', 'visits.visit_registration_id as noreg', 'visits.visit_patient_name as name', 'visits.visit_patient_mr as mr', 'service_reference as reference', 'laboratories.test_unit as unit')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('service_code', $code)
            ->whereYear('services_detail.created_at', $year)
            ->whereMonth('services_detail.created_at', $month)
            ->whereNotNull('service_price')
            ->whereNotNull('service_time_result')
            // ->groupBy('noreg')
            ->orderBy('noreg')
            ->paginate(10);
            // ->get();

        // dd($labs);
        $menu = 'report';
        $submenu = 'reportlaboratory';
        return view('pages.report.laboratorydetail', compact('labs', 'menu', 'submenu'));
    }

    public function exportExcelLabDetail(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));
        $coder = $request->input('code');

        return Excel::download(new ExportLabDetail($month, $year, $coder), $coder.'_test_report_'.$month.'_'.$year.'.xlsx');
    }
    public function exportPDFLabDetail(Request $request)
    {
        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));
        $coder = $request->input('code');

        $labs = DB::table('services_detail')
            ->select('services_detail.created_at as date',  'service_result as result',  'service_name as test', 'visits.visit_registration_id as noreg', 'visits.visit_patient_name as name', 'laboratories.test_unit as unit')
            ->join('visits', 'services_detail.service_visit_registration_id', '=', 'visits.visit_registration_id')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('service_code', $coder)
            ->whereYear('services_detail.created_at', $year)
            ->whereMonth('services_detail.created_at', $month)
            ->whereNotNull('service_price')
            ->whereNotNull('service_time_result')
            ->orderBy('noreg')
            ->get();

        $pdf = PDF::loadView('pages.report.monthly_test', compact('labs', 'coder', 'month', 'year'));

        return $pdf->download($coder.'_test_report_'.$month.'_'.$year.'.pdf');
    }
    public function reportpersonel(Request $request)
    {

        $monthYear = $request->input('month', date('Y-m'));
        $month = date('m', strtotime($monthYear));
        $year = date('Y', strtotime($monthYear));
        $personel = $request->input('personel');

        // Ambil data revenue per hari dalam bulan yang dipilih
        $labs = Service::selectRaw('DATE(created_at) as date, service_name as test, service_code as code, service_group as grouptest, service_subgroup as subgrouptest, service_price as price, SUM(service_quantity) as quantity')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('service_price')
            ->whereNotNull('service_time_result')
            ->groupBy('test')
            ->orderBy('quantity')
            ->paginate(10);
        // ->get();
        //PERHATIKAN INI JIKA NANTI ADA ERROR PAGINATION

        $menu = 'report';
        $submenu = 'reportpersonel';
        //LOAD USER NAME
        // $personels = User::all();
        $personels = DB::table('services_detail')
                    ->select('service_handler as handler')
                    ->where('service_handler', '!=', 'Terlampir')
                    ->groupBy('handler')
                    ->orderBy('handler')
                    ->get();
        // SALES
        $sales = Visit::whereYear('visit_date', $year)
        ->whereMonth('visit_date', $month)
        ->where('visit_registered_by', $personel)
        ->orderBy('id', 'desc')
        ->get();

        $totalRevenue = $sales->sum('visit_payment_amount');
        $totalCharge = $sales->sum('visit_payment_charge');
        $totalDiscount = $sales->sum('visit_payment_discount');

        //COLLECTION SPECIMEN
        $collection = Visit::whereYear('visit_date', $year)
                    ->whereMonth('visit_date', $month)
                    ->where('visit_sampling_by', $personel)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->count();

        //RECEIVE SPECIMEN
        $receive = Visit::whereYear('visit_date', $year)
                    ->whereMonth('visit_date', $month)
                    ->where('visit_receive_by', $personel)
                    ->orderBy('id', 'desc')
                    ->get()
                    ->count();

        //TEST LAB
        $tester = DB::table('services_detail')
                    ->whereYear('updated_at', $year)
                    ->whereMonth('updated_at', $month)
                    ->where('service_handler', $personel)
                    ->get()
                    ->count();

        //VALIDATED
        $validated = Visit::whereYear('visit_date', $year)
                    ->whereMonth('visit_date', $month)
                    ->where('visit_validation_by', $personel)
                    ->get()
                    ->count();

        //DATA FOR CHART
        $data = Service::selectRaw('service_group as datagrouptest, SUM(service_quantity) as dataquantity')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->whereNotNull('service_price')
            ->whereNotNull('service_time_result')
            ->groupBy('datagrouptest')
            ->orderBy('dataquantity')
            ->get();

            $datagrouptest = [];
            $dataquantity = [];

        foreach ($data as $row) {
            $datagrouptest[] = $row->datagrouptest;
            $dataquantity[] = $row->dataquantity;
        }

        return view('pages.report.personel', compact('validated','receive','tester','collection','personels','sales', 'totalRevenue', 'totalCharge', 'totalDiscount','labs', 'menu', 'datagrouptest', 'dataquantity', 'submenu', 'month', 'year'));
    }
}

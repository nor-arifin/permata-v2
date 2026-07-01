<?php

namespace App\Http\Controllers;

use App\Models\Kesmas;
use App\Models\Parameter;
use App\Services\FonnteService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KesmasController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'administration-km';
        $submenu = 'order-km';
        $orders = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.kesmas.index', compact('orders', 'menu', 'submenu'));
    }
    public function create()
    {
        $menu = 'administration-km';
        $submenu = 'order-km';
        $customers = DB::table('kesmas_customers')
            ->orderBy('customer_code', 'asc')
            ->get();
        $lastcode = DB::table('kesmas_orders')->orderBy('id', 'desc')->get('order_code')->first();
        $lastnumber = ($lastcode) ? (int) substr($lastcode->order_code, 0, 4) : 0;
        $nextnumber = str_pad($lastnumber + 1, 4, '0', STR_PAD_LEFT);
        $month = date('m');
        $romanMonths = [
            '01' => 'I',
            '02' => 'II',
            '03' => 'III',
            '04' => 'IV',
            '05' => 'V',
            '06' => 'VI',
            '07' => 'VII',
            '08' => 'VIII',
            '09' => 'IX',
            '10' => 'X',
            '11' => 'XI',
            '12' => 'XII'
        ];
        $month = $romanMonths[date('m')];


        $nextcode = $nextnumber . '/FPPS/LKK-PKY/KESMAS/' . $month . '/' . date('Y');

        return view('pages.kesmas.create', compact('menu', 'submenu', 'customers', 'nextcode'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'order_code' => 'required|unique:kesmas_orders,order_code',
            'order_date' => 'required|date',
            'customer_code' => 'required|exists:kesmas_customers,customer_code',
            'order_total' => 'required',
            'order_user' => 'required',
        ]);
        $encode = md5($request->order_code);

        DB::table('kesmas_orders')->insert([
            'order_code' => $request->order_code,
            'order_date' => $request->order_date,
            'order_customer' => $request->customer_code,
            'order_total' => $request->order_total,
            'order_user' => $request->order_user,
            'order_encode' => $encode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('kesmas.index')->with('success', 'Draft FPPS created successfully.');
    }

    public function sample($id)
    {
        $menu = 'administration-km';
        $submenu = 'order-km';
        $order = DB::table('kesmas_orders')->where('kesmas_orders.id', $id)
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.id as idcode', 'kesmas_orders.*', 'kesmas_customers.*')
            ->first();
        $samplers = DB::table('users')->where('stage', 'kesmas')->get();
        return view('pages.kesmas.sample', compact('order', 'menu', 'submenu', 'samplers'));
    }
    public function getSampler($id)
    {
        $datasampler = DB::table('users')->where('id', $id)->first();
        return response()->json($datasampler);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'order_id' => 'required|exists:kesmas_orders,id',
            'order_collector' => 'required|in:customer,laboratory',
            'timesampling' => 'required',
            'timereceived' => 'required',
            'division' => 'required|in:Kimia,Mikrobiologi',
            'quantity' => 'required|numeric',
            'type' => 'required|array',
            'type.*' => 'required|string',
            'sampleid' => 'required|array',
            'sampleid.*' => 'required|string',
            'container' => 'required|array',
            'container.*' => 'required|string',
            'description' => 'required|array',
            'description.*' => 'required|string',
            'samplecode' => 'required|array',
            'samplecode.*' => 'required|string',
        ]);
        // dd($request->all());
        if ($request->order_collector == 'laboratory') {
            $sampler = DB::table('users')->where('id', $request->labnamesampler)->first();
            $sampling_name = $sampler->name;
            $sampling_phone = $sampler->phone;
            $sampling_user = $sampler->id;
        } else if ($request->order_collector == 'customer') {
            $sampling_name = $request->cusnamesampler;
            $sampling_phone = $request->cusphonesampler;
            $sampling_user = null;
        }
        $order = DB::table('kesmas_orders')->where('id', $id)->first();
        // dd($order);
        $order_id = $order->id;
        $encode = $order->order_encode;

        //Update Kesmas Order
        DB::table('kesmas_orders')->where('id', $order_id)->update([
            'order_type' => $request->division,
            'order_num_sample' => $request->quantity,
            'order_status' => 'registered',
            'order_collector' => $request->order_collector,
            'order_sampling_name' => $sampling_name,
            'order_sampling_phone' => $sampling_phone,
            'order_collect' => $request->timesampling,
            'order_collect_user' => $sampling_user,
            'order_receive' => $request->timereceived,
            'updated_at' => now(),
        ]);
        //Store Kesmas Order Samples
        $samples = [];
        for ($i = 0; $i < count($request->type); $i++) {
            $sample_code = $request->samplecode[$i] . '/' . date('m') . '/' . date('Y');
            $samples[] = [
                'order_code' => $order_id,
                'sample_type' => $request->type[$i],
                'sample_division' => $request->samplecode[$i],
                'sample_code' => $sample_code,
                'sample_id' => $request->sampleid[$i],
                'sample_note' => $request->sample_note[$i],
                'sample_container' => $request->container[$i],
                'sample_description' => $request->description[$i],
                'sample_charge' => 0,
                'sample_volume' => 1,
                'sample_collect_time' => $request->timesampling,
                'sample_receive_time' => $request->timereceived,
                'order_encode' => $encode,
                'created_at' => now(),
                'updated_at' => now(),
            ];

        }
        // dd($samples);
        DB::table('kesmas_order_samples')->insert($samples);

        return redirect()->route('kesmas.index')->with('success', 'Input sample successfully.');
    }
    public function parameter($id)
    {
        $menu = 'administration-km';
        $submenu = 'order-km';
        $order = DB::table('kesmas_orders')->where('kesmas_orders.id', $id)
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.id as idcode', 'kesmas_orders.*', 'kesmas_customers.*')
            ->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $id)->get();
        $allparameters = DB::table('kesmas_parameters')
            ->where('parameter_status', 'active')
            ->get();
        // dd($samples);
        return view('pages.kesmas.parameter', compact('order', 'menu', 'submenu', 'samples', 'allparameters'));
    }
    public function getParameters($id)
    {
        $sample = DB::table('kesmas_order_samples')->where('id', $id)->first();
        $sampletype = $sample->sample_type;
        $group = $sample->sample_division;
        if ($group == 'KA') {
            $samplegroup = 'KA';
        } else {
            $samplegroup = 'MK';
        }

        $parameters = DB::table('kesmas_parameters')
            ->where('parameter_status', 'active')
            ->where('parameter_group', $samplegroup)
            ->where('parameter_subgroup', $sampletype)
            ->orderBy('parameter_name', 'asc')
            ->get();

        $selectedParameters = DB::table('kesmas_orders_detail')->where('order_sample_id', $id)->pluck('order_parameter_code')->toArray();
        return response()->json(['parameters' => $parameters, 'selectedParameters' => $selectedParameters]);
    }

    public function saveParameters(Request $request)
    {
        $sampleId = $request->input('sample_id');
        $sampleCode = $request->input('sample_code');
        $parameters = $request->input('parameters');

        // Pastikan parameters selalu berupa array
        if (!is_array($parameters)) {
            $parameters = [$parameters];
        }

        //Load Data by Sample ID
        $encode = DB::table('kesmas_order_samples')->where('id', $sampleId)->first();

        // Update sample_code and reset sample_charge
        DB::table('kesmas_order_samples')->where('id', $sampleId)->update([
            'sample_code' => $sampleCode,
            'sample_number' => substr($sampleCode, 0, 4),
            'sample_charge' => 0,
        ]);


        // Hapus parameter yang ada untuk sample_id tertentu
        DB::table('kesmas_orders_detail')->where('order_sample_id', $sampleId)->delete();


        // Tambahkan parameter yang baru
        $newParameters = [];
        foreach ($parameters as $parameter) {
            //Load parameter data by parameter_code
            $parameterData = Parameter::where('parameter_code', $parameter)->first();
            if (!$parameterData) {
                return response()->json(['error' => 'Parameter not found.']);
            }
            $newParameters[] = [
                'order_code' => $encode->order_code,
                'order_sample_id' => $sampleId,
                'order_parameter_code' => $parameter,
                'order_parameter_name' => $parameterData->parameter_name,
                'order_parameter_method' => $parameterData->parameter_method,
                'order_parameter_unit' => $parameterData->parameter_unit,
                'order_parameter_reference_value' => $parameterData->parameter_reference_value,
                'order_parameter_group' => $parameterData->parameter_group,
                'order_parameter_subgroup' => $parameterData->parameter_subgroup,
                'order_parameter_parent' => $parameterData->parameter_parent,
                'order_parameter_price' => $parameterData->parameter_price,
                'order_parameter_acreditation' => $parameterData->parameter_acreditation,
                'order_parameter_encode' => $encode->order_encode,
                'created_at' => now(),
                'updated_at' => now(),
            ];
            //Update Kesmas Order Samples Charge
            $totalCharge = array_sum(array_column($newParameters, 'order_parameter_price'));
            DB::table('kesmas_order_samples')->where('id', $sampleId)->update([
                'sample_charge' => $totalCharge,
            ]);
        }

        DB::table('kesmas_orders_detail')->insert($newParameters);

        return response()->json(['success' => 'Input parameter successfully.']);
    }

    public function show($id)
    {
        $menu = 'administration-km';
        $submenu = 'order-km';
        $order = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.*', 'kesmas_orders.id as idcode')
            ->where('kesmas_orders.id', $id)->first();
        if (!$order) {
            return redirect()->route('kesmas.index')->with('error', 'Order not found.');
        }
        $samples = DB::table('kesmas_order_samples')->where('order_code', $order->idcode)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $order->idcode)->orderBy('order_parameter_group', 'asc')->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $order->idcode)->first();
        $data = compact('order', 'samples', 'parameters', 'additional', 'menu', 'submenu');
        return view('pages.kesmas.show', $data);
    }
    public function checkCode($id)
    {
        $sample = DB::table('kesmas_order_samples')->where('id', $id)->first();
        $division = $sample->sample_division;
        //Check Number of Character from sample_code
        $strlenCode = strlen($sample->sample_code);
        if ($strlenCode == 15) {
            $samplecode = $sample->sample_code;
        } else {
            //Get Max Sample Number by Division
            $maxnumber = DB::table('kesmas_order_samples')->max('sample_number');
            if ($maxnumber === null) {
                $max = str_pad(0, 4, '0', STR_PAD_LEFT);
            } else {
                $max = $maxnumber;
            }
            $nextnumber = str_pad($max + 1, 4, '0', STR_PAD_LEFT);
            $samplecode = $nextnumber . '/' . $division . '/' . date('m') . '/' . date('Y');
        }
        return response()->json(['generatedCode' => $samplecode]);
    }
    public function createfpps(Request $request, $id)
    {
        //Validate Request
        $request->validate([
            'idcode' => 'required|exists:kesmas_orders,id',
            'order_total' => 'required|integer',
        ]);
        //Get Order Data
        $order = DB::table('kesmas_orders')->where('id', $id)->first();
        //Update Order
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_total' => $request->order_total,
            'order_status' => 'review',
            'updated_at' => now(),
        ]);
        //Check $request->addcharge is null or not
        if ($request->addcharge != 0) {
            //Create Additional Task
            DB::table('kesmas_orders_additional')->insert([
                'add_order_id' => $id,
                'add_order_code' => $order->order_code,
                'add_order_type' => $order->order_type,
                'add_order_customer_id' => $order->order_customer,
                'add_order_task' => $request->addtask,
                'add_order_status' => 'On Scheduled',
                'add_order_charge' => $request->addcharge,
                'add_order_user' => auth()->user()->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return redirect()->route('kesmas.index')->with('success', 'FPPS created successfully.');
    }
    public function destroy($id)
    {

        // Delete Review
        DB::table('kesmas_reviews')->where('review_code', $id)->delete();

        // Delete Additional Task
        DB::table('kesmas_orders_additional')->where('add_order_id', $id)->delete();

        // Delete Order Parameters
        DB::table('kesmas_orders_detail')->where('order_code', $id)->delete();

        // Delete Order Samples
        DB::table('kesmas_order_samples')->where('order_code', $id)->delete();

        // Delete Order
        $order = DB::table('kesmas_orders')->where('id', $id)->whereIn('order_status', ['draft', 'registered', 'review', 'payment'])->first();
        if (!$order) {
            return redirect()->route('kesmas.index')->with('error', 'Order not found or finished.');
        }
        DB::table('kesmas_orders')->where('id', $id)->delete();

        // Return to Index
        return redirect()->route('kesmas.index')->with('success', 'FPPS order deleted successfully.');
    }

    public function reject($id)
    {

        // Delete Additional Task
        DB::table('kesmas_orders_additional')->where('add_order_id', $id)->delete();

        // Delete Order Parameters
        DB::table('kesmas_orders_detail')->where('order_code', $id)->delete();

        // Delete Order Samples
        DB::table('kesmas_order_samples')->where('order_code', $id)->delete();

        // Delete Order
        $order = DB::table('kesmas_orders')->where('id', $id)->whereIn('order_status', ['draft', 'registered', 'review', 'payment'])->first();
        if (!$order) {
            return redirect()->route('kesmas.index')->with('error', 'Order not found or finished.');
        }
        DB::table('kesmas_orders')->where('id', $id)->delete();

        // Return to Index
        return redirect()->route('kesmas.index')->with('success', 'FPPS order deleted successfully.');
    }

    public function review($id)
    {

        $menu = 'administration-km';
        $submenu = 'order-km';
        $order = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.*', 'kesmas_orders.id as idcode')
            ->where('kesmas_orders.id', $id)->first();
        if (!$order) {
            return redirect()->route('kesmas.index')->with('error', 'Order not found.');
        }
        $samples = DB::table('kesmas_order_samples')->where('order_code', $order->idcode)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $order->idcode)->orderBy('order_parameter_group', 'asc')->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $order->idcode)->first();
        $data = compact('order', 'samples', 'parameters', 'additional', 'menu', 'submenu');
        return view('pages.kesmas.review', $data);
    }

    public function savereview(Request $request, $id)
    {
        //abnormality_expired, abnormality_preservatives, abnormality_outlab, abnormality_outpreservatives, abnormality_other

        $request->validate([
            'review_personnel' => 'required',
            'review_accomodation' => 'required',
            'review_workload' => 'required',
            'review_equipment' => 'required',
            'review_method' => 'required',
            'review_conclution' => 'required|in:Accept,Reject',

        ]);
        // dd($request->all());
        $review_note = $request->review_note ?? '-';
        //Store Review
        DB::table('kesmas_reviews')->insert([
            'review_code' => $id,
            'review_date' => now(),
            'review_personnel' => $request->review_personnel,
            'review_accomodation' => $request->review_accomodation,
            'review_workload' => $request->review_workload,
            'review_equipment' => $request->review_equipment,
            'review_method' => $request->review_method,
            'review_note' => $review_note,
            'review_conclution' => $request->review_conclution,
            'review_by' => auth()->user()->id,
            'abnormality_expired' => $request->expired ?? 'off',
            'abnormality_preservatives' => $request->preservatives ?? 'off',
            'abnormality_outlab' => $request->outlab ?? 'off',
            'abnormality_outpreservatives' => $request->outpreservatives ?? 'off',
            'abnormality_other' => $request->abnormality_other ?? 'off',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        //Update Order Status
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_status' => 'payment',
            'order_review' => now(),
            'order_review_user' => auth()->user()->id,
            'updated_at' => now(),
        ]);
        return redirect()->route('kesmas.index')->with('success', 'FPPS order reviewed successfully.');
    }
    public function fpps($id)
    {
        $kesmas = Kesmas::findOrFail($id);
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
        $data = compact('kesmas', 'customers', 'samples', 'parameters', 'additional', 'payment', 'review');
        // dd($data);
        //make pdf view
        // dd($data);
        return view('pages.kesmas.fpps', $data);
    }
    public function print($id)
    {
        $kesmas = Kesmas::findOrFail($id);
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
    public function printkan($id)
    {
        $kesmas = Kesmas::findOrFail($id);
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

    function sendOrder($id)
    {

        $kesmas = Kesmas::findOrFail($id);
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $kesmas->id)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $kesmas->id)->first();
        $payment = DB::table('payment_details')->where('payment_order_id', $kesmas->id)->first();
        $target = $customers->customer_phone;
        if ($kesmas->order_payment_method == 'PKS') {
            $order_payment_amount = '0';
            $remaining = $kesmas->order_total;
            $due_date = "Jatuh Tempo " . date('d-m-Y', strtotime($payment->payment_mou_duedate));
        } else {
            $order_payment_amount = $kesmas->order_payment_amount;
            $remaining = $kesmas->order_total - $order_payment_amount;
            $due_date = date('d-m-Y', strtotime($kesmas->order_payment_date));
        }
        $order_date = date('d-m-Y', strtotime($kesmas->order_date));
        $order_total = number_format($kesmas->order_total, 0, ',', '.');
        $order_payment_amount = number_format($order_payment_amount, 0, ',', '.');
        $remaining = number_format($remaining, 0, ',', '.');

        $message =
            "*NOTIFIKASI LABORATORIUM*
            
Yth. *" . $customers->customer_name . "*,
Permintaan pemeriksaan laboratorium Anda telah berhasil didaftarkan dengan rincian sebagai berikut.

*Detail Order*
No. FPPS : " . $kesmas->order_code . "
Tanggal Permintaan : " . $order_date . "
Instansi/Perusahaan : " . $kesmas->order_customer . " - " . $customers->customer_name . "
Jenis Pemeriksaan : " . $kesmas->order_type . "
Jumlah Sampel : " . $kesmas->order_num_sample . "

*Detail Billing*
Total Tagihan : Rp. " . $order_total . "
Jumlah Pembayaran : Rp. " . $order_payment_amount . "
Metode Pembayaran : " . $kesmas->order_payment_method . "
Tanggal Pembayaran : " . $due_date . "
Sisa Tagihan : Rp. " . $remaining . "

Untuk informasi lebih lanjut, silakan hubungi :
085824184658
layanan@labkesmas-kalteng.id

Terima kasih telah menggunakan layanan Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.

_Pesan ini dibuat otomatis oleh sistem_";

        FonnteService::send($target, $message);
    }


}
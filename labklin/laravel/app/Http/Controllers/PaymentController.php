<?php

namespace App\Http\Controllers;

use App\Models\Kesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function kesmas(Request $request)
    {
        $menu = 'administration-km';
        $submenu = 'payment-km';
        $unpaids = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNull('order_payment_date')
            ->whereIn('order_status', ['Payment'])
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('id')
            ->paginate(10);

        $paids = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNot('order_payment_method', 'PKS')
            ->whereNotNull('order_payment_date')
            ->whereNotIn('order_status', ['Payment'])
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('order_payment_date')
            ->paginate(10);

        $pkss = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->join('payment_details', 'kesmas_orders.id', '=', 'payment_details.payment_order_id')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name', 'payment_details.payment_mou_number', 'payment_details.payment_mou_duedate', 'payment_details.payment_status')
            ->where('order_payment_method', 'PKS')
            ->whereNotNull('order_payment_date')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('payment_mou_duedate')
            ->paginate(10);

        $countunpaids = DB::table('kesmas_orders')
            ->whereIn('order_status', ['Payment'])
            ->whereNull('order_payment_date')
            ->count();

        $countpaids = DB::table('kesmas_orders')
            ->whereNot('order_payment_method', 'PKS')
            ->whereNotNull('order_payment_date')
            ->whereNotIn('order_status', ['Payment'])
            ->count();

        $countpkss = DB::table('kesmas_orders')
            ->where('order_payment_method', 'PKS')
            ->whereNotNull('order_payment_date')
            ->count();
        $data = compact('unpaids', 'paids', 'pkss', 'menu', 'submenu', 'countunpaids', 'countpaids', 'countpkss');
        return view('pages.kesmas.payment', $data);
    }

    public function inputkm($id)
    {
        $menu = 'administration-km';
        $submenu = 'payment-km';
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
        $review = DB::table('kesmas_reviews')
            ->join('users', 'kesmas_reviews.review_by', '=', 'users.id')
            ->select('kesmas_reviews.*', 'users.name as review_name')
            ->where('review_code', $order->idcode)->first();
        $data = compact('order', 'samples', 'parameters', 'additional', 'review', 'menu', 'submenu');
        // dd($data);
        return view('pages.kesmas.inputkm', $data);

    }
    public function inputpks($id)
    {
        $menu = 'administration-km';
        $submenu = 'payment-km';
        $order = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->join('payment_details', 'kesmas_orders.id', '=', 'payment_details.payment_order_id')
            ->select('kesmas_orders.*', 'kesmas_customers.*', 'kesmas_orders.id as idcode', 'payment_details.payment_mou_number', 'payment_details.payment_mou_duedate', 'payment_details.payment_status')
            ->where('payment_details.payment_status', 'pending')
            ->where('kesmas_orders.id', $id)
            ->first();
        if (!$order) {
            return redirect()->route('kesmas.index')->with('error', 'Order not found.');
        }
        $samples = DB::table('kesmas_order_samples')->where('order_code', $order->idcode)->get();
        $parameters = DB::table('kesmas_orders_detail')->where('order_code', $order->idcode)->orderBy('order_parameter_group', 'asc')->get();
        $additional = DB::table('kesmas_orders_additional')->where('add_order_id', $order->idcode)->first();
        $review = DB::table('kesmas_reviews')
            ->join('users', 'kesmas_reviews.review_by', '=', 'users.id')
            ->select('kesmas_reviews.*', 'users.name as review_name')
            ->where('review_code', $order->idcode)->first();
        $data = compact('order', 'samples', 'parameters', 'additional', 'review', 'menu', 'submenu');
        // dd($data);
        return view('pages.kesmas.inputpks', $data);

    }

    public function paykm(Request $request, $id)
    {
        $order = DB::table('kesmas_orders')->where('id', $id)->first();
        if (!$order) {
            return redirect()->route('kesmas.payment')->with('error', 'Order not found.');
        }
        //Validate the request
        $request->validate([
            'order_total' => 'required|numeric',
            'order_payment_method' => 'required',
            'order_payment_amount' => 'required|numeric',
            'order_payment_remaining' => 'required|numeric|in:0',
        ]);
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_status' => 'On Process',
            'order_payment_date' => now(),
            'order_payment_method' => $request->order_payment_method,
            'order_payment_amount' => $request->order_payment_amount,
            'order_payment_user' => auth()->user()->id,
            'updated_at' => now(),
        ]);
        if ($request->order_payment_method == 'Transfer') {
            $bank_name = $request->transfer_bank_name;
            $payment_date = $request->transfer_transaction_date;
        } elseif ($request->order_payment_method == 'Debit') {
            $bank_name = $request->debit_bank_name;
            $payment_date = $request->debit_transaction_date;
        } elseif ($request->order_payment_method == 'PKS') {
            $bank_name = null;
            $payment_date = $request->mou_transaction_date;
        } else {
            $bank_name = null;
            $payment_date = now();
        }
        if ($request->order_payment_method == 'PKS') {
            $status = 'pending';
        } else {
            $status = 'paid';
        }
        //Create a new payment detail
        DB::table('payment_details')->insert([
            'payment_order_type' => 'kesmas',
            'payment_order_id' => $id,
            'payment_method' => $request->order_payment_method,
            'payment_bank' => $bank_name,
            'payment_card_number' => $request->card_number,
            'payment_card_cvc' => $request->card_cvc,
            'payment_card_holder' => $request->card_holder,
            'payment_card_month' => $request->card_month,
            'payment_card_year' => $request->card_year,
            'payment_ref_number' => $request->debit_ref_number,
            'payment_account_name' => $request->transfer_account_name,
            'payment_mou_number' => $request->mou_number,
            'payment_mou_duedate' => $request->mou_duedate,
            'payment_date' => $payment_date,
            'payment_status' => $status,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        //Send notification to customer
        $this->sendOrder($id);
        //Redirect to payment page
        return redirect()->route('payment.kesmas')->with('success', 'Payment Succesfully.');
    }

    //Notifikasi Pembayaran All
    function sendOrder($id)
    {

        $kesmas = Kesmas::findOrFail($id);
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $payment = DB::table('payment_details')->where('payment_order_id', $kesmas->id)->first();
        $target = $customers->customer_phone;
        if ($kesmas->order_payment_method == 'PKS') {
            $order_payment_amount = '0';
            $remaining = $kesmas->order_total;
            $due_date = "Jatuh Tempo " . date('d-m-Y', strtotime($payment->payment_mou_duedate));
            $catatan = "Mohon untuk melakukan pembayaran sesuai dengan PKS yang telah disepakati, dan mengirimkan bukti pembayaran ke nomor layanan pelanggan kami.";
        } else {
            $order_payment_amount = $kesmas->order_payment_amount;
            $remaining = $kesmas->order_total - $order_payment_amount;
            $due_date = date('d-m-Y', strtotime($kesmas->order_payment_date));
            $catatan = "";
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

*Catatan : *" . $catatan . "

Untuk informasi lebih lanjut, silakan hubungi :
085824184658
layanan@labkesmas-kalteng.id

Terima kasih telah menggunakan layanan Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.

_Pesan ini dibuat otomatis oleh sistem_";

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . env('FONNTE_API_TOKEN')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response; //log response fonnte
    }
    //Notifikasi Pembayaran PKS
    function sendBillpks($id)
    {

        $kesmas = Kesmas::findOrFail($id);
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
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
Pembayaran Anda telah kami terima dengan rincian sebagai berikut.

*Detail Order*
No. FPPS : " . $kesmas->order_code . "
Tanggal Permintaan : " . $order_date . "
Instansi/Perusahaan : " . $kesmas->order_customer . " - " . $customers->customer_name . "
Jenis Pemeriksaan : " . $kesmas->order_type . "
Jumlah Sampel : " . $kesmas->order_num_sample . "

*Detail Billing*
Nomor PKS : Rp. " . $payment->payment_mou_number . "
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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $target,
                'message' => $message,
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . env('FONNTE_API_TOKEN')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response; //log response fonnte
    }

    public function paypks(Request $request, $id)
    {
        $order = DB::table('kesmas_orders')->where('id', $id)->first();
        if (!$order) {
            return redirect()->route('kesmas.payment')->with('error', 'Order not found.');
        }
        //Validate the request
        $request->validate([
            'order_total' => 'required|numeric',
            'order_payment_method' => 'required',
            'order_payment_amount' => 'required|numeric',
            'order_payment_remaining' => 'required|numeric|in:0',
        ]);
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_payment_date' => now(),
            'order_payment_method' => $request->order_payment_method,
            'order_payment_amount' => $request->order_payment_amount,
            'order_payment_user' => auth()->user()->id,
            'updated_at' => now(),
        ]);
        if ($request->order_payment_method == 'Transfer') {
            $bank_name = $request->transfer_bank_name;
            $payment_date = $request->transfer_transaction_date;
        } elseif ($request->order_payment_method == 'Debit') {
            $bank_name = $request->debit_bank_name;
            $payment_date = $request->debit_transaction_date;
        } else {
            $bank_name = null;
            $payment_date = now();
        }
        $status = 'paid';
        //Update payment_details
        DB::table('payment_details')->where('payment_order_id', $id)->update([
            'payment_method' => 'PKS-' . $request->order_payment_method,
            'payment_card_number' => $request->card_number,
            'payment_card_cvc' => $request->card_cvc,
            'payment_card_holder' => $request->card_holder,
            'payment_card_month' => $request->card_month,
            'payment_card_year' => $request->card_year,
            'payment_ref_number' => $request->debit_ref_number,
            'payment_account_name' => $request->transfer_account_name,
            'payment_date' => $payment_date,
            'payment_status' => $status,
            'updated_at' => now(),
        ]);
        //Send notification to customer
        $this->sendBillpks($id);
        //Redirect to payment page
        return redirect()->route('payment.kesmas')->with('success', 'Payment Succesfully.');
    }
    public function clinic(Request $request)
    {
        $menu = 'visit';
        $submenu = 'payment';
        $unpaids = DB::table('visits')
            ->select('id', 'visit_registration_id', 'visit_date', 'visit_patient_name', 'visit_patient_dept', 'visit_status_timeline', 'visit_payment_remaining', 'visit_payment_status', 'visit_payment_time')
            ->whereNull('visit_payment_amount')
            ->where('visit_payment_status', 'unpaid')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('visit_patient_name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('id')
            ->paginate(10);

        $paids = DB::table('visits')
            ->select('id', 'visit_registration_id', 'visit_date', 'visit_patient_name', 'visit_patient_dept', 'visit_status_timeline', 'visit_payment_amount', 'visit_payment_method', 'visit_payment_status', 'visit_payment_time')
            ->whereNotNull('visit_payment_amount')
            ->where('visit_payment_status', 'paid')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('visit_patient_name', 'like', '%' . $name . '%');
            })
            ->orderByDesc('id')
            ->paginate(10);

        $countunpaids = DB::table('visits')
            ->where('visit_payment_status', 'unpaid')
            ->whereNull('visit_payment_amount')
            ->count();

        $countpaids = DB::table('visits')
            ->where('visit_payment_status', 'paid')
            ->whereNotNull('visit_payment_amount')
            ->count();

        $data = compact('unpaids', 'paids', 'menu', 'submenu', 'countunpaids', 'countpaids');
        // dd($data);
        return view('pages.visits.paymentlist', $data);
    }

    public function inputcl($id)
    {
        $menu = 'administration-km';
        $submenu = 'payment-km';
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
        $review = DB::table('kesmas_reviews')
            ->join('users', 'kesmas_reviews.review_by', '=', 'users.id')
            ->select('kesmas_reviews.*', 'users.name as review_name')
            ->where('review_code', $order->idcode)->first();
        $data = compact('order', 'samples', 'parameters', 'additional', 'review', 'menu', 'submenu');
        // dd($data);
        return view('pages.kesmas.inputkm', $data);

    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
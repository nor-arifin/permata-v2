<?php

namespace App\Http\Controllers;

use App\Models\Kesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LabkesmasController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    //index
    public function status(Request $request)
    {
        $menu = 'labkesmas';
        $submenu = 'status-km';
        $orders = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);


        return view('pages.kesmas.status', compact('orders', 'menu', 'submenu'));
    }

    public function receive(Request $request)
    {
        $menu = 'labkesmas';
        $submenu = 'receive-km';
        $kimias = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull('order_payment_date')
            ->where('order_status', 'On Process')
            ->where('order_type', 'Kimia')
            ->where('order_receive_user', null)
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_collect')
            ->paginate(10);
        $mikros = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull('order_payment_date')
            ->where('order_status', 'On Process')
            ->where('order_type', 'Mikrobiologi')
            ->where('order_receive_user', null)
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_collect')
            ->paginate(10);

        $countkimia = DB::table('kesmas_orders')
            ->where('order_status', 'On Process')
            ->where('order_type', 'Kimia')
            ->where('order_receive_user', null)
            ->count();
        $countmikro = DB::table('kesmas_orders')
            ->where('order_status', 'On Process')
            ->where('order_type', 'Mikrobiologi')
            ->where('order_receive_user', null)
            ->count();

        $data = compact('menu', 'submenu', 'kimias', 'countkimia', 'mikros', 'countmikro');
        // dd($data);
        return view('pages.kesmas.receive', $data);
    }

    public function updatereceive($id)
    {
        $order = DB::table('kesmas_orders')
            ->where('id', $id)
            ->where('order_status', 'On Process')
            ->where('order_receive_user', null)
            ->first();
        if (!$order) {
            return redirect()->route('labkesmas.receive')->with('error', 'Sample Order ID Not Found.');
        }
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_receive' => now(),
            'order_receive_user' => auth()->user()->id,
            'updated_at' => now(),
        ]);
        return redirect()->route('labkesmas.receive')->with('success', 'Sample Received Succesfully.');
    }

    public function entry(Request $request)
    {
        $menu = 'labkesmas';
        $submenu = 'entry-km';
        $kimias = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull(['order_payment_date', 'order_receive_user'])
            ->where('order_status', 'On Process')
            ->where('order_type', 'Kimia')
            ->whereNull('order_process_user')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_receive')
            ->paginate(10);
        $mikros = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull(['order_payment_date', 'order_receive_user'])
            ->where('order_status', 'On Process')
            ->where('order_type', 'Mikrobiologi')
            ->whereNull('order_process_user')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_receive')
            ->paginate(10);

        $countkimia = DB::table('kesmas_orders')
            ->where('order_status', 'On Process')
            ->where('order_type', 'Kimia')
            ->whereNotNull(['order_payment_date', 'order_receive_user'])
            ->whereNull('order_process_user')
            ->count();
        $countmikro = DB::table('kesmas_orders')
            ->where('order_status', 'On Process')
            ->where('order_type', 'Mikrobiologi')
            ->whereNotNull(['order_payment_date', 'order_receive_user'])
            ->whereNull('order_process_user')
            ->count();

        $data = compact('menu', 'submenu', 'kimias', 'countkimia', 'mikros', 'countmikro');
        // dd($data);
        return view('pages.kesmas.entry', $data);
    }
    public function entryresult($id)
    {
        $menu = 'labkesmas';
        $submenu = 'entry-km';
        $order = DB::table('kesmas_orders')->where('kesmas_orders.id', $id)
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.id as idcode', 'kesmas_orders.*', 'kesmas_customers.*')
            ->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $id)->get();
        $parameters = DB::table('kesmas_orders_detail')
            ->where('order_code', $order->idcode)
            ->orderBy('order_parameter_group', 'asc')
            ->orderBy('order_parameter_subgroup', 'asc')
            ->get();

        $rejections = DB::table('kesmas_order_rejection')->where('kesmas_order_id', $id)->get();
        // dd($samples);
        return view('pages.kesmas.entryresult', compact('order', 'menu', 'submenu', 'samples', 'parameters', 'rejections'));
    }

    public function saveresult(Request $request, $id)
    {
        $request->validate([
            'parameter_result' => 'required|string',
        ]);
        //Get order_code
        $order_code = DB::table('kesmas_orders_detail')->where('id', $id)->first();
        $idcode = $order_code->order_code;

        //Check order_status is Verification
        $order = DB::table('kesmas_orders')
            ->where('id', $idcode)
            ->where('order_status', 'Verification')
            ->first();
        if (!$order) {
            //Update the kesmas_orders_detail table
            DB::table('kesmas_orders_detail')
                ->where('id', $id)
                ->update([
                    'order_parameter_result' => $request->input('parameter_result'),
                    'order_parameter_registered' => now(),
                    'order_parameter_handler' => auth()->user()->id,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            return response()->json(['message' => 'Result Entry Successfully.']);
        } else {
            return response()->json(['error' => 'Result Entry Failed. This parameter result under verification process.'], 400);
        }
    }
    public function savereference(Request $request, $id)
    {
        $request->validate([
            'parameter_reference' => 'required|string',
        ]);
        //Get order_code
        $order_code = DB::table('kesmas_orders_detail')->where('id', $id)->first();
        $idcode = $order_code->order_code;

        //Check order_status is Verification
        $order = DB::table('kesmas_orders')
            ->where('id', $idcode)
            ->where('order_status', 'Verification')
            ->first();
        if (!$order) {
            //Update the kesmas_orders_detail table
            DB::table('kesmas_orders_detail')
                ->where('id', $id)
                ->update([
                    'order_parameter_reference_value' => $request->input('parameter_reference'),
                ]);
            return response()->json(['message' => 'Reference Changed Successfully.']);
        } else {
            return response()->json(['error' => 'Reference Change Failed. This parameter result under verification process.'], 400);
        }
    }
    public function saveunit(Request $request, $id)
    {
        $request->validate([
            'parameter_unit' => 'required|string',
        ]);
        //Get order_code
        $order_code = DB::table('kesmas_orders_detail')->where('id', $id)->first();
        $idcode = $order_code->order_code;

        //Check order_status is Verification
        $order = DB::table('kesmas_orders')
            ->where('id', $idcode)
            ->where('order_status', 'Verification')
            ->first();
        if (!$order) {
            //Update the kesmas_orders_detail table
            DB::table('kesmas_orders_detail')
                ->where('id', $id)
                ->update([
                    'order_parameter_unit' => $request->input('parameter_unit'),
                ]);
            return response()->json(['message' => 'Unit Changed Successfully.']);
        } else {
            return response()->json(['error' => 'Unit Change Failed. This parameter result under verification process.'], 400);
        }
    }

    public function savemethod(Request $request, $id)
    {
        $request->validate([
            'parameter_method' => 'required|string',
        ]);
        //Get order_code
        $order_code = DB::table('kesmas_orders_detail')->where('id', $id)->first();
        $idcode = $order_code->order_code;

        //Check order_status is Verification
        $order = DB::table('kesmas_orders')
            ->where('id', $idcode)
            ->where('order_status', 'Validation')
            ->first();
        if (!$order) {
            //Update the kesmas_orders_detail table
            DB::table('kesmas_orders_detail')
                ->where('id', $id)
                ->update([
                    'order_parameter_method' => $request->input('parameter_method'),
                ]);
            return response()->json(['message' => 'Method Changed Successfully.']);
        } else {
            return response()->json(['error' => 'Parameter Method Change Failed. This parameter result under verification process.'], 400);
        }
    }
    //Notifikasi Verifikasi
    function notifVerify($id)
    {

        $kesmas = Kesmas::findOrFail($id);
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $pjt = DB::table('users')->where('id', $kesmas->order_process_user)->first();
        if ($kesmas->order_type == 'Kimia') {
            $target = "081346240075"; //nomor tujuan notifikasi - kimia
        } else {
            $target = "082159072072"; //nomor tujuan notifikasi - mikro
        }
        $order_date = date('d-m-Y', strtotime($kesmas->order_date));
        $tat = now()->diffInDays($kesmas->order_date);

        $message =
            "*NOTIFIKASI VERIFIKASI*
            
Yth. *Verifikator*,
Tim laboratorium telah menyelesaikan pengujian dan menunggu verifikasi hasil uji laboratorium:

No. FPPS : " . $kesmas->order_code . "
Tanggal Permintaan : " . $order_date . "
Instansi/Perusahaan : " . $kesmas->order_customer . " - " . $customers->customer_name . "
Jenis Pemeriksaan : " . $kesmas->order_type . "
Jumlah Sampel : " . $kesmas->order_num_sample . "

Penanggungjawab : " . $pjt->name . "
Keterangan Pengujian : " . $kesmas->order_note . "
Turn Around Time (TAT) : " . $tat . " hari sejak sample diterima.

Mohon segera dilakukan verifikasi melalui LabKlin Systems.

*Terima Kasih*
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
        // echo $response; //log response fonnte
    }


    function notifCancelvalid($id)
    {

        $kesmas = Kesmas::findOrFail($id);
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $pjt = DB::table('users')->where('id', $kesmas->order_process_user)->first();
        if ($kesmas->order_type == 'Kimia') {
            $target = "081346240075"; //nomor tujuan notifikasi - kimia
        } else {
            $target = "082159072072"; //nomor tujuan notifikasi - mikro
        }
        $order_date = date('d-m-Y', strtotime($kesmas->order_date));
        $tat = now()->diffInDays($kesmas->order_date);

        $message =
            "*NOTIFIKASI VARIFIKASI ULANG*
            
Yth. *Verifikator*,
Validator telah melakukan validasi dan meminta untuk melakukan _verifikasi ulang_ hasil uji laboratorium :

No. FPPS : " . $kesmas->order_code . "
Tanggal Permintaan : " . $order_date . "
Instansi/Perusahaan : " . $kesmas->order_customer . " - " . $customers->customer_name . "
Jenis Pemeriksaan : " . $kesmas->order_type . "
Jumlah Sampel : " . $kesmas->order_num_sample . "

Penanggungjawab : " . $pjt->name . "
Keterangan Pengujian : " . $kesmas->order_note . "
Turn Around Time (TAT) : " . $tat . " hari sejak sample diterima.

Catatan dari Validator terdapat pada lembar kerja verifikasi.
Mohon segera dilakukan verifikasi ulang melalui LabKlin Systems.

*Terima Kasih*
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
        // echo $response; //log response fonnte
    }

    public function saveprocess($id)
    {
        $order = DB::table('kesmas_orders')
            ->where('id', $id)
            ->where('order_status', 'On Process')
            ->whereNotNull(['order_payment_date', 'order_receive_user'])
            ->whereNull('order_process_user')
            ->first();
        if (!$order) {
            return response()->json(['message' => 'Sample Order ID Not Found.']);
        }
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_status' => 'Verification',
            'order_process' => now(),
            'order_process_user' => auth()->user()->id,
            'updated_at' => now(),
        ]);
        //Send Notification to Verificator
        $this->notifVerify($id);

        return response()->json(['message' => 'Result Saved Succesfully.']);
    }

    public function verify(Request $request)
    {
        $menu = 'labkesmas';
        $submenu = 'verify-km';
        $kimias = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user'])
            ->where('order_status', 'Verification')
            ->where('order_type', 'Kimia')
            ->whereNull('order_verify_user')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_verify')
            ->paginate(10);
        $mikros = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user'])
            ->where('order_status', 'Verification')
            ->where('order_type', 'Mikrobiologi')
            ->whereNull('order_verify_user')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_verify')
            ->paginate(10);

        $countkimia = DB::table('kesmas_orders')
            ->where('order_status', 'Verification')
            ->where('order_type', 'Kimia')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user'])
            ->whereNull('order_verify_user')
            ->count();
        $countmikro = DB::table('kesmas_orders')
            ->where('order_status', 'Verification')
            ->where('order_type', 'Mikrobiologi')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user'])
            ->whereNull('order_verify_user')
            ->count();

        $data = compact('menu', 'submenu', 'kimias', 'countkimia', 'mikros', 'countmikro');
        // dd($data);
        return view('pages.kesmas.verify', $data);
    }

    public function verification($id)
    {
        $menu = 'labkesmas';
        $submenu = 'verify-km';
        $order = DB::table('kesmas_orders')->where('kesmas_orders.id', $id)
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.id as idcode', 'kesmas_orders.*', 'kesmas_customers.*')
            ->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $id)->get();
        $parameters = DB::table('kesmas_orders_detail')
            ->where('order_code', $order->idcode)
            ->orderBy('order_parameter_group', 'asc')
            ->orderBy('order_parameter_subgroup', 'asc')
            ->get();
        $rejections = DB::table('kesmas_order_rejection')->where('kesmas_order_id', $id)->get();
        // dd($rejections);
        return view('pages.kesmas.verification', compact('order', 'menu', 'submenu', 'samples', 'parameters', 'rejections'));
    }
    //Notifikasi Validasi
    function notifValidate($id)
    {

        $kesmas = Kesmas::findOrFail($id);
        //Get kesmas_orders Data join kesmas_customers
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $verificator = DB::table('users')->where('id', $kesmas->order_verify_user)->first();
        $target = "081349632201"; //nomor tujuan notifikasi - validator
        $order_date = date('d-m-Y', strtotime($kesmas->order_date));
        $tat = now()->diffInDays($kesmas->order_date);

        $message =
            "*NOTIFIKASI VALIDASI*
            
Yth. *Validator*,
Terdapat Lembar Hasil Uji Laboratorium menunggu validasi:

No. FPPS : " . $kesmas->order_code . "
Tanggal Permintaan : " . $order_date . "
Instansi/Perusahaan : " . $kesmas->order_customer . " - " . $customers->customer_name . "
Jenis Pemeriksaan : " . $kesmas->order_type . "
Jumlah Sampel : " . $kesmas->order_num_sample . "

Verifikator : " . $verificator->name . "
Keterangan Pengujian : " . $kesmas->order_note . "
Turn Around Time (TAT) : " . $tat . " hari sejak sample diterima.

Mohon segera dilakukan validasi melalui LabKlin Systems.

*Terima Kasih*
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
        // echo $response; //log response fonnte
    }

    public function updateverify(Request $request, $id)
    {
        $order = DB::table('kesmas_orders')
            ->where('id', $id)
            ->where('order_status', 'Verification')
            ->whereNotNull(['order_payment_date', 'order_process_user'])
            ->whereNull('order_verify_user')
            ->first();
        if (!$order) {
            return response()->json(['message' => 'Sample Order ID Not Found.']);
        }
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_status' => 'Validation',
            'order_verify' => now(),
            'order_verify_user' => auth()->user()->id,
            'order_note' => $request->input('note'),
            'updated_at' => now(),
        ]);
        //Send Notification to Validator
        $this->notifValidate($id);

        return response()->json(['message' => 'Result Verifeid Succesfully.']);
    }

    public function rerun($id)
    {
        $order = DB::table('kesmas_orders')
            ->where('id', $id)
            ->where('order_status', 'Verification')
            ->whereNotNull(['order_payment_date', 'order_process_user'])
            ->whereNull('order_verify_user')
            ->first();
        if (!$order) {
            return response()->json(['message' => 'Sample Order ID Not Found.']);
        }
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_status' => 'On Process',
            'order_process' => null,
            'order_process_user' => null,
            'updated_at' => now(),
        ]);


        return response()->json(['message' => 'Result Canceled Succesfully.']);
    }
    public function cancel(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
        ]);

        $order = DB::table('kesmas_orders')
            ->where('id', $id)
            ->where('order_status', 'Validation')
            ->whereNotNull(['order_payment_date', 'order_process_user', 'order_verify_user'])
            ->whereNull('order_validate_user')
            ->first();
        if (!$order) {
            return response()->json(['message' => 'Sample Order ID Not Found.']);
        }
        //Create a new kesmas_order_rejection
        DB::table('kesmas_order_rejection')->insert([
            'kesmas_order_id' => $id,
            'rejection_reason' => $request->input('reason'),
            'rejection_user' => auth()->user()->name,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($order->order_reject = null) {
            $stamp = 0;
        } else {
            $stamp = $order->order_reject;
        }
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_status' => 'Verification',
            //ON PROCESS
            'order_verify' => null,
            'order_verify_user' => null,
            'order_reject' => $stamp + 1,
            'updated_at' => now(),
        ]);
        
        //Send Notification to Verificator
        $this->notifCancelvalid($id);

        return response()->json(['message' => 'Result Canceled Succesfully.']);
    }

    public function validity(Request $request)
    {
        $menu = 'labkesmas';
        $submenu = 'validation-km';
        $kimias = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user', 'order_verify_user'])
            ->where('order_status', 'Validation')
            ->where('order_type', 'Kimia')
            ->whereNull('order_validate_user')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_verify')
            ->paginate(10);
        $mikros = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user', 'order_verify_user'])
            ->where('order_status', 'Validation')
            ->where('order_type', 'Mikrobiologi')
            ->whereNull('order_validate_user')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('order_verify')
            ->paginate(10);

        $countkimia = DB::table('kesmas_orders')
            ->where('order_status', 'Validation')
            ->where('order_type', 'Kimia')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user', 'order_verify_user'])
            ->whereNull('order_validate_user')
            ->count();
        $countmikro = DB::table('kesmas_orders')
            ->where('order_status', 'Validation')
            ->where('order_type', 'Mikrobiologi')
            ->whereNotNull(['order_payment_date', 'order_receive_user', 'order_process_user', 'order_verify_user'])
            ->whereNull('order_validate_user')
            ->count();

        $data = compact('menu', 'submenu', 'kimias', 'countkimia', 'mikros', 'countmikro');
        // dd($data);
        return view('pages.kesmas.validity', $data);
    }
    public function validation($id)
    {
        $menu = 'labkesmas';
        $submenu = 'validation-km';
        $order = DB::table('kesmas_orders')->where('kesmas_orders.id', $id)
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.id as idcode', 'kesmas_orders.*', 'kesmas_customers.*')
            ->first();
        $samples = DB::table('kesmas_order_samples')->where('order_code', $id)->get();
        $parameters = DB::table('kesmas_orders_detail')
            ->where('order_code', $order->idcode)
            ->orderBy('order_parameter_group', 'asc')
            ->orderBy('order_parameter_subgroup', 'asc')
            ->get();
        $verificator = DB::table('users')->where('id', $order->order_verify_user)->first();
        $rejections = DB::table('kesmas_order_rejection')->where('kesmas_order_id', $id)->get();
        // dd($verificator);
        return view('pages.kesmas.validation', compact('order', 'menu', 'submenu', 'samples', 'parameters', 'verificator', 'rejections'));
    }

    //Notifikasi Hasil
    public function sendReport($id)
    {
        $kesmas = Kesmas::findOrFail($id);
        $customers = DB::table('kesmas_customers')->where('customer_code', $kesmas->order_customer)->first();
        $payment = DB::table('payment_details')->where('payment_order_id', $kesmas->id)->first();
        $target = $customers->customer_phone;
        if ($kesmas->order_payment_method == 'PKS') {
            $order_payment_amount = '0';
            $remaining = $kesmas->order_total;
            $due_date = "Jatuh Tempo " . date('d-m-Y', strtotime($payment->payment_mou_duedate));
            $link = "_link disembunyikan, menunggu pembayaran_";
        } else {
            $order_payment_amount = $kesmas->order_payment_amount;
            $remaining = $kesmas->order_total - $order_payment_amount;
            $due_date = date('d-m-Y', strtotime($kesmas->order_payment_date));
            $link = "https://labkesmas-kalteng.id/verify-km/lhu/" . $kesmas->order_encode;
        }
        $order_date = date('d-m-Y', strtotime($kesmas->order_date));
        $order_total = number_format($kesmas->order_total, 0, ',', '.');
        $order_payment_amount = number_format($order_payment_amount, 0, ',', '.');
        $remaining = number_format($remaining, 0, ',', '.');

        $message =
            "*NOTIFIKASI HASIL*
            
Yth. *" . $customers->customer_name . "*,
Uji Laboratorium Anda dengan nomor No. FPPS : " . $kesmas->order_code . " telah selesai dilakukan.

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

Anda dapat mengunduh dan mencetak Lembar Hasil Uji Laboratorium pada tautan berikut ini:
" . $link . "

Untuk informasi lebih lanjut, silakan hubungi :
085824184658
layanan@labkesmas-kalteng.id

Terima kasih telah menggunakan layanan Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.

_Pesan ini dibuat otomatis oleh sistem_";

        //START PENDING SCHEDULE NOTIFICATION +1 Day (AKTIFKAN JIKA INGIN MENJADWALKAN NOTIFIKASI)
        //Convert timestamp to epoch
        $date = date('Y-m-d H:i:s');
        $schedule = strtotime($date . '+23 hours');
        //END - PENDING SCHEDULE NOTIFICATION +1 Day

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
                'schedule' => $schedule, //Schedule notification (AKTIFKAN JIKA INGIN MENJADWALKAN NOTIFIKASI)
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . env('FONNTE_API_TOKEN')
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response; //log response fonnte
    }


    public function updatevalidate(Request $request, $id)
    {
        $order = DB::table('kesmas_orders')
            ->where('id', $id)
            ->where('order_status', 'Validation')
            ->whereNotNull(['order_payment_date', 'order_process_user', 'order_verify_user'])
            ->whereNull('order_validate_user')
            ->first();
        if (!$order) {
            return response()->json(['message' => 'Sample Order ID Not Found.']);
        }
        //Update the kesmas_orders table
        DB::table('kesmas_orders')->where('id', $id)->update([
            'order_status' => 'Completed',
            'order_validate' => now(),
            'order_validate_user' => auth()->user()->id,
            'updated_at' => now(),
        ]);
        //Send Notification to Customer
        // $this->sendReport($id);

        return response()->json(['message' => 'Result Validated Succesfully.']);
    }

    public function draft($id)
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
        return view('pages.kesmas.draft', $data);
    }
    public function draftverify($id)
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
        return view('pages.kesmas.draftverify', $data);
    }
    public function report(Request $request)
    {
        $menu = 'labkesmas';
        $submenu = 'report-km';
        $orders = DB::table('kesmas_orders')
            ->join('kesmas_customers', 'kesmas_orders.order_customer', '=', 'kesmas_customers.customer_code')
            ->select('kesmas_orders.*', 'kesmas_customers.customer_name as customer_name')
            ->where('order_status', 'Completed')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        $data = compact('menu', 'submenu', 'orders');
        return view('pages.kesmas.report', $data);
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
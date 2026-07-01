<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProvinceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'registration-km';
        $submenu = 'customers';
        $customers = DB::table('kesmas_customers')
            ->when($request->input('name'), function ($query, $name) {
                return $query->where('customer_name', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.customers.index', compact('customers', 'menu', 'submenu'));
    }
    public function create()
    {
        $menu = 'registration-km';
        $submenu = 'customers';
        $lastCustomer = DB::table('kesmas_customers')->get('customer_code')->last();
        $lastcode = $lastCustomer ? $lastCustomer->customer_code : 'C-0000';
        $autoid = 'C-' . str_pad((int) substr($lastcode, 2) + 1, 4, '0', STR_PAD_LEFT);

        $provinsi = ProvinceModel::all();
        return view('pages.customers.create', compact('menu', 'submenu', 'autoid', 'provinsi'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required|string|max:255|unique:kesmas_customers,customer_code',
            'customer_name' => 'required|string|max:255',
            'customer_type' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'customer_address_detail' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'required|email|max:255',
            'customer_pic' => 'required|string|max:255',
            'customer_pic_phone' => 'required|string|max:15|starts_with:08',
            'customer_pic_nik' => 'required|string|max:16|min:16',
            'customer_pic_position' => 'required|string|max:255',
        ]);
        $status = 'active';
        $username = $request->customer_email;
        $password = Hash::make($request->customer_code);
        $date = date('Y-m-d');
        $encode = md5($request->customer_code);
        $named = $request->customer_name;

        DB::table('kesmas_customers')->insert([
            'customer_code' => $request->customer_code,
            'customer_name' => $request->customer_name,
            'customer_type' => $request->customer_type,
            'customer_address' => $request->customer_address,
            'customer_address_detail' => $request->customer_address_detail,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_pic' => $request->customer_pic,
            'customer_pic_phone' => $request->customer_pic_phone,
            'customer_pic_nik' => $request->customer_pic_nik,
            'customer_pic_position' => $request->customer_pic_position,
            'customer_status' => $status,
            'customer_username' => $username,
            'customer_password' => $password,
            'customer_registered' => $date,
            'customer_encode' => $encode,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer ' . $named . ' created successfully.');
    }
    public function edit($id)
    {
        $menu = 'registration-km';
        $submenu = 'customers';
        $customer = DB::table('kesmas_customers')->where('id', $id)->first();
        $provinsi = ProvinceModel::all();
        return view('pages.customers.edit', compact('customer', 'menu', 'submenu', 'provinsi'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_code' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'customer_type' => 'required|string|max:255',
            'customer_address' => 'required|string|max:255',
            'customer_address_detail' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:15',
            'customer_email' => 'required|email|max:255',
            'customer_status' => 'required|string|max:255',
            'customer_pic' => 'required|string|max:255',
            'customer_pic_phone' => 'required|string|max:15|starts_with:08',
            'customer_pic_nik' => 'required|string|max:16|min:16',
            'customer_pic_position' => 'required|string|max:255',

        ]);
        $named = $request->customer_name;

        DB::table('kesmas_customers')->where('id', $id)->update([
            'customer_name' => $request->customer_name,
            'customer_type' => $request->customer_type,
            'customer_address' => $request->customer_address,
            'customer_address_detail' => $request->customer_address_detail,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'customer_pic' => $request->customer_pic,
            'customer_pic_phone' => $request->customer_pic_phone,
            'customer_pic_nik' => $request->customer_pic_nik,
            'customer_pic_position' => $request->customer_pic_position,
            'customer_status' => $request->customer_status,
        ]);

        return redirect()->route('customers.index')->with('success', 'Customer ' . $named . ' updated successfully.');
    }
    public function destroy($id)
    {
        $customer = DB::table('kesmas_customers')->where('id', $id)->first();
        $named = $customer->customer_name;
        DB::table('kesmas_customers')->where('id', $id)->delete();
        return redirect()->route('customers.index')->with('success', 'Customer ' . $named . ' deleted successfully.');
    }
    public function getDetail($id)
    {
        $customer = DB::table('kesmas_customers')->where('customer_code', $id)->first();
        return response()->json($customer);
    }
}
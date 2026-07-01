<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    //index
    public function index(Request $request)
    {
        //get all
        $doctors = DB::table('doctors')
            ->when($request->input('name'), function ($query, $doctor_name) {
                return $query->where('doctor_name', 'like', '%' . $doctor_name . '%');
            })
            ->orderBy('id', 'desc')
            ->get();
        //return json 200
        return response([
            'data' => $doctors,
            'message' => 'success',
            'status' => 'OK'
        ], 200);
    }
}

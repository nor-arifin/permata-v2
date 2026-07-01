<?php

namespace App\Http\Controllers\Api;

use App\Models\Patients;
use App\Models\Visit;
use App\Models\Patient;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SelfserviceController extends Controller
{
    public function getVisit(Request $request)
    {
        $request->validate([
            'patient_nik' => 'required|string',
            'patient_mr' => 'required|string',
        ]);
        // return response()->json($request->all());
        $visit = DB::table('visits')
            ->join('patients', 'visits.visit_patient_mr', '=', 'patients.patient_mr')
            ->select('visits.*', 'patients.*')
            ->where('patients.patient_nik', $request->query('patient_nik'))
            ->where('patients.patient_mr', $request->query('patient_mr'))
            ->select(
                'visits.visit_date',
                'visits.visit_registration_id',
                'visits.visit_patient_name',
                'visits.visit_patient_mr',
                'visits.visit_doctor_name',
                'visits.visit_patient_dept',
                'visits.visit_status_timeline',
                'visits.visit_encoded',
            )
            ->orderBy('visits.visit_date', 'desc')
            ->get();

        if ($visit->isNotEmpty()) {
            return response()->json($visit);
        } else {
            return response()->json(['message' => 'Visit not found'], 404);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Visit::all());
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
        $visit = Visit::where('visit_registration_id', $id)->first();

        if ($visit) {
            return response()->json($visit);
        } else {
            return response()->json(['message' => 'Visit not found'], 404);
        }
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
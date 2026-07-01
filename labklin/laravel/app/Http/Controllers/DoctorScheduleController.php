<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DoctorScheduleController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'master';
        $submenu = 'doctorschedules';
        $doctorschedules = DoctorSchedule::with('doctor')
            ->when($request->input('name'), function ($query, $day) {
                return $query->where('day', 'like', '%' . $day . '%');
            })
            ->orderBy('day', 'asc')
            ->paginate(10);
        return view('pages.doctors_schedules.index', compact('doctorschedules', 'menu', 'submenu'));
    }

    //create
    public function create()
    {
        $menu = 'master';
        $submenu = 'doctorschedules';
        $doctors = DB::table('doctors')->orderBy('doctor_name', 'asc')->get();
        return view('pages.doctors_schedules.create', compact('menu', 'submenu', 'doctors'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required',
            'status' => 'enum:active,inactive',
        ]);

        //If monday is not empty
        if (!empty($request->monday) && $request->monday_status !== 'inactive') {
            $schedule = new DoctorSchedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = 'Monday';
            $schedule->start_time = $request->monday_start;
            $schedule->end_time = $request->monday_end;
            $schedule->status = $request->monday_status;
            $schedule->save();
        }
        //If tuesday is not empty
        if (!empty($request->tuesday) && $request->tuesday_status !== 'inactive') {
            $schedule = new DoctorSchedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = 'Tuesday';
            $schedule->start_time = $request->tuesday_start;
            $schedule->end_time = $request->tuesday_end;
            $schedule->status = $request->tuesday_status;
            $schedule->save();
        }
        //If wednesday is not empty
        if (!empty($request->wednesday) && $request->wednesday_status !== 'inactive') {
            $schedule = new DoctorSchedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = 'Wednesday';
            $schedule->start_time = $request->wednesday_start;
            $schedule->end_time = $request->wednesday_end;
            $schedule->status = $request->wednesday_status;
            $schedule->save();
        }
        //If thursday is not empty
        if (!empty($request->thursday) && $request->thursday_status !== 'inactive') {
            $schedule = new DoctorSchedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = 'Thursday';
            $schedule->start_time = $request->thursday_start;
            $schedule->end_time = $request->thursday_end;
            $schedule->status = $request->thursday_status;
            $schedule->save();
        }
        //If friday is not empty
        if (!empty($request->friday) && $request->friday_status !== 'inactive') {
            $schedule = new DoctorSchedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = 'Friday';
            $schedule->start_time = $request->friday_start;
            $schedule->end_time = $request->friday_end;
            $schedule->status = $request->friday_status;
            $schedule->save();
        }
        //If saturday is not empty
        if (!empty($request->saturday) && $request->saturday_status !== 'inactive') {
            $schedule = new DoctorSchedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = 'Saturday';
            $schedule->start_time = $request->saturday_start;
            $schedule->end_time = $request->saturday_end;
            $schedule->status = $request->saturday_status;
            $schedule->save();
        }
        //If sunday is not empty
        if (!empty($request->sunday) && $request->sunday_status !== 'inactive') {
            $schedule = new DoctorSchedule;
            $schedule->doctor_id = $request->doctor_id;
            $schedule->day = 'Sunday';
            $schedule->start_time = $request->sunday_start;
            $schedule->end_time = $request->sunday_end;
            $schedule->status = $request->sunday_status;
            $schedule->save();
        }

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor Schedule created successfully.');
    }
    //edit
    public function edit($id){
        $menu = 'master';
        $submenu = 'doctorschedules';
        // $doctor = Doctor::find($id);
        $doctorschedules = DoctorSchedule::with('doctor')->where('id', $id)->get();
        $doctors = DB::table('doctors')->orderBy('doctor_name', 'asc')->get();
        $sch = DoctorSchedule::find($id);
        return view('pages.doctors_schedules.edit', compact('doctorschedules','doctors','sch','menu', 'submenu'));
    }
    // Update
    public function update(Request $request, $id){
        $request->validate([
            'status' => 'required',
        ]);

        $sch = DoctorSchedule::find($id);
        $sch->start_time = $request->start_time;
        $sch->end_time = $request->end_time;
        $sch->status = $request->status;
        $sch->updated_at = now();
        $sch->save();

        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor Schedule updated successfully.');
    }

    //destroy
    public function destroy($id)
    {
        DB::table('doctor_schedules')->where('id', $id)->delete();
        return redirect()->route('doctor-schedules.index')->with('success', 'Doctor Schedule deleted successfully.');
    }
}

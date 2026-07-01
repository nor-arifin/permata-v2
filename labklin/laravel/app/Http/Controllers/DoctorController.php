<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'master';
        $submenu = 'doctors';
        $doctors = DB::table('doctors')
            ->when($request->input('name'), function ($query, $doctor_name) {
                return $query->where('doctor_name', 'like', '%' . $doctor_name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.doctors.index', compact('doctors', 'menu', 'submenu'));
    }

    //create
    public function create()
    {
        $menu = 'master';
        $submenu = 'doctors';
        return view('pages.doctors.create', compact('menu', 'submenu'));
    }

    //store
    public function store(Request $request)
    {
        $request->validate([
            'doctor_name' => 'required',
            // 'doctor_email' => 'required|email',
            'doctor_phone' => 'required',
            // 'doctor_sip' => 'required',
            'doctor_speciality' => 'required',
            // 'doctor_id' => 'required',
            'doctor_gender' => 'required',
            // 'doctor_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'doctor_nik' => 'required',
            'doctor_birthdate' => 'required',
        ]);

        $doctor = new Doctor;
        $doctor->doctor_name = $request->doctor_name;
        $doctor->doctor_speciality = $request->doctor_speciality;
        $doctor->doctor_phone = $request->doctor_phone;
        $doctor->doctor_email = $request->doctor_email;
        $doctor->doctor_sip = $request->doctor_sip;
        $doctor->doctor_id = $request->doctor_id;
        $doctor->doctor_gender = $request->doctor_gender;
        $doctor->doctor_nik = $request->doctor_nik;
        $doctor->doctor_birthdate = $request->doctor_birthdate;
        $doctor->save();

        //Save Doctor Photo
        if ($request->hasFile('doctor_photo')) {
            $image = $request->file('doctor_photo');
            $image->storeAs('public/doctors', $doctor->id . '.' . $image->getClientOriginalExtension());
            $doctor->doctor_photo = 'storage/doctors/' . $doctor->id . '.' . $image->getClientOriginalExtension();
            $doctor->save();
        }
        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    //show detail
    public function show($id)
    {
        $menu = 'master';
        $submenu = 'doctors';
        $doctor = Doctor::find($id);
        return view('pages.doctors.show', compact('doctor', 'menu', 'submenu'));
    }

    //edit
    public function edit($id)
    {
        $menu = 'master';
        $submenu = 'doctors';
        $doctor = Doctor::find($id);
        return view('pages.doctors.edit', compact('doctor', 'menu', 'submenu'));
    }
    //update
    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_name' => 'required',
            // 'doctor_email' => 'required|email',
            'doctor_phone' => 'required',
            // 'doctor_sip' => 'required',
            'doctor_speciality' => 'required',
            // 'doctor_id' => 'required',
            'doctor_gender' => 'required',
            // 'doctor_photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'doctor_nik' => 'required',
            'doctor_birthdate' => 'required',
        ]);

        $doctor = Doctor::find($id);
        $doctor->doctor_name = $request->doctor_name;
        $doctor->doctor_speciality = $request->doctor_speciality;
        $doctor->doctor_phone = $request->doctor_phone;
        $doctor->doctor_email = $request->doctor_email;
        $doctor->doctor_sip = $request->doctor_sip;
        $doctor->doctor_id = $request->doctor_id;
        $doctor->doctor_gender = $request->doctor_gender;
        $doctor->doctor_nik = $request->doctor_nik;
        $doctor->doctor_birthdate = $request->doctor_birthdate;
        $doctor->updated_at = now();
        $doctor->save();

        // UPLOAD PHOTO
        if ($request->hasFile('doctor_photo')) {
            //Delete last photo file if exists
            $file = $doctor->doctor_photo;
            if(File::exists(public_path($file))){
                File::delete(public_path($file));
            }
            //Upload new photo
            $image = $request->file('doctor_photo');
            $image->storeAs('public/doctors', $doctor->id . '.' . $image->getClientOriginalExtension());
            $doctor->doctor_photo = 'storage/doctors/' . $doctor->id . '.' . $image->getClientOriginalExtension();
            $doctor->save();
        }

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }
    public function destroy($id)
    {
        $doctor = Doctor::find($id);
        $file = $doctor->doctor_photo;
        if(File::exists(public_path($file))){
            File::delete(public_path($file));
        }
        DB::table('doctor_schedules')->where('doctor_id', $id)->delete();
        DB::table('doctors')->where('id', $id)->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}

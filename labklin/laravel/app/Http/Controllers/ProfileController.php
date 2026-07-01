<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfileClinic;
use App\Models\ProvinceModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    //index
    public function edit($id){
        $menu = 'setting';
        $submenu = 'profileclinic';
        $profiles = ProfileClinic::find($id);

        $provinsi = ProvinceModel::all();

        return view('pages.profile.edit', compact('profiles','provinsi', 'menu', 'submenu'));
    }
    //update
    public function update(Request $request, $id){

        //DEFAULT
        $country = "ID";
        $use = "work";
        $profiles = ProfileClinic::find($id);
        $profiles->name = $request->name;
        $profiles->address = $request->address;
        $profiles->phone = $request->phone;
        $profiles->email = $request->email;
        $profiles->description = $request->description;
        $profiles->logo = $request->logo;
        $profiles->website = $request->website;
        $profiles->pic = $request->pic;
        $profiles->acreditation = $request->acreditation;
        $profiles->status = $request->status;
        $profiles->faskes_id = $request->faskes_id;
        $profiles->organization_id = $request->organization_id;
        $profiles->client_id = $request->client_id;
        $profiles->client_secretkey = $request->client_secretkey;
        $profiles->base_address_longitude = $request->base_address_longitude;
        $profiles->base_address_latitude = $request->base_address_latitude;
        $profiles->base_address_altitude = $request->base_address_altitude;
        $profiles->base_address_use = $use;
        $profiles->base_address_line = $request->address;
        $profiles->base_address_city = $request->base_address_city;
        $profiles->base_address_country = $country;
        $profiles->base_address_postalcode = $request->base_address_postalcode;
        $profiles->base_address_extension = $request->base_address_extension;
        $profiles->base_code_province = $request->base_code_province;
        $profiles->base_code_city = $request->base_code_city;
        $profiles->base_code_district = $request->base_code_district;
        $profiles->base_code_village = $request->base_code_village;
        $profiles->base_code_rt = $request->base_code_rt;
        $profiles->base_code_rw = $request->base_code_rw;
        $profiles->updated_at = now();
        $profiles->save();

        // UPLOAD PHOTO
        if ($request->hasFile('logo')) {
            //Delete last photo file if exists
            $file = $profiles->logo;
            if(File::exists(public_path($file))){
                File::delete(public_path($file));
            }
            //Upload new photo
            $image = $request->file('logo');
            $image->storeAs('public/logo', $profiles->id . '.' . $image->getClientOriginalExtension());
            $profiles->logo = 'storage/logo/' . $profiles->id . '.' . $image->getClientOriginalExtension();
            $profiles->save();
        }

        return redirect()->route('profileclinic.edit', 1)->with('success', 'Profile Clinic updated successfully.');

    }
}

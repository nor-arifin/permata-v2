<?php

namespace App\Http\Controllers;

use App\Models\Locations;
use Illuminate\Http\Request;
use App\Models\Organizations;
use App\Models\ProfileClinic;
use Illuminate\Support\Facades\DB;
use Satusehat\Integration\FHIR\Location;

class LocationController extends Controller
{
    public function index(Request $request)
    {
        $menu = 'master';
        $submenu = 'locations';
        $locations = DB::table('locations')
            ->when($request->input('name'), function ($query, $location_name) {
                return $query->where('location_name', 'like', '%' . $location_name . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.locations.index', compact('locations', 'menu', 'submenu'));
    }

    //create
    public function create()
    {
        $menu = 'master';
        $submenu = 'locations';
        $organizations = Organizations::all();
        $profiles = ProfileClinic::find(1);
        return view('pages.locations.create', compact('organizations','profiles','menu', 'submenu'));
    }

    //store
    public function store(Request $request)
    {
        //VALIDATION INPUT
        $request->validate([
            'location_code' => 'required',
            'location_name' => 'required',
            'location_physical_type' => 'required',
            'location_description' => 'required',
            'location_position_longitude'=> 'required',
            'location_position_latitude'=> 'required',
            'location_position_altitude'=> 'required',
            'location_status'=> 'required',
        ]);
        //GENERATE JSON LOCATION
        $location_code = $request->location_code;
        $location_name = $request->location_name;
        $location_physical_type = $request->location_physical_type;
        $location_organization = $request->location_organization;
        $location = new Location;
        $location->addIdentifier($location_code); // unique string free text (increments / UUID / inisial)
        $location->setName($location_name); // string free text
        $location->addPhysicalType($location_physical_type); // ro = ruangan, bu = bangunan, wi = sayap gedung, ve = kendaraan, ho = rumah, ca = kabined, rd = jalan, area = area. Default bila tidak dideklarasikan = ruangan
        $location->setManagingOrganization($location_organization); // string free text
        $location->json();
        //POST LOCATION TO IHS
        [$statusCode, $response] = $location->post();
        //GET ID LOCATION AS UUID
        $location_uuid = $response->id;
        //CREAT LOCATION
        $locations = new Locations;
        $locations->location_code = $request->location_code;
        $locations->location_name = $request->location_name;
        $locations->location_uuid = $location_uuid;
        $locations->location_physical_type = $request->location_physical_type;
        $locations->location_description = $request->location_description;
        $locations->location_position_longitude = $request->location_position_longitude;
        $locations->location_position_latitude = $request->location_position_latitude;
        $locations->location_position_altitude = $request->location_position_altitude;
        $locations->location_status = $request->location_status;
        $locations->location_mode = $request->location_mode;
        $locations->location_address_use = $request->location_address_use;
        $locations->location_address_line = $request->location_address_line;
        $locations->location_address_city = $request->location_address_city;
        $locations->location_address_country = $request->location_address_country;
        $locations->location_organization = $request->location_organization;
        $locations->save();

        return redirect()->route('locations.index')->with('success', 'Location created successfully.');
    }

    //destroy
    public function destroy($id){
        $location = Locations::findOrFail($id);
        $location->delete();
        return redirect()->route('locations.index')->with('success', 'Location deleted successfully.');
    }

    //get location from IHS
    public function edit($id){
        $location = Locations::findOrFail($id);
        $menu = 'master';
        $submenu = 'locations';
        return view('pages.locations.edit', compact('location', 'menu', 'submenu'));
    }

    //update
    public function update(Request $request, $id){
        $request->validate([
            'location_code' => 'required',
            'location_name' => 'required',
            'location_physical_type' => 'required',
            'location_description' => 'required',
            'location_position_longitude'=> 'required',
            'location_position_latitude'=> 'required',
            'location_position_altitude'=> 'required',
            'location_status'=> 'required',
        ]);

        //GENERATE JSON LOCATION
        $location_code = $request->location_code;
        $location_name = $request->location_name;
        $location_physical_type = $request->location_physical_type;
        $location = new Location;
        $location->addIdentifier($location_code); // unique string free text (increments / UUID / inisial)
        $location->setName($location_name); // string free text
        $location->addPhysicalType($location_physical_type); // ro = ruangan, bu = bangunan, wi = sayap gedung, ve = kendaraan, ho = rumah, ca = kabined, rd = jalan, area = area. Default bila tidak dideklarasikan = ruangan
        $location->json();
        //SET UUID LOCATION
        $location_id = $request->location_uuid;
        //PUT LOCATION IHS DATABASE
        [$statusCode, $response] = $location->put($location_id);
        //PUT TO LOCAL DATABASE
        $locations = Locations::findOrFail($id);
        $locations->update($request->all());
        return redirect()->route('locations.index')->with('success', 'Location updated successfully.');
    }
}

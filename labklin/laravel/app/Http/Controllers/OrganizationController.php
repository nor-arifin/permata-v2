<?php

namespace App\Http\Controllers;
use App\Models\Organizations;
use Illuminate\Http\Request;
use App\Models\ProfileClinic;
use Illuminate\Support\Facades\DB;
use Satusehat\Integration\FHIR\Organization;

class OrganizationController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'master';
        $submenu = 'organizations';
        $profiles = ProfileClinic::find(1);
        $organizations = DB::table('organizations')
            ->when($request->input('name'), function ($query, $organization_name) {
                return $query->where('organization_name', 'like', '%' . $organization_name . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.organizations.index', compact('organizations','profiles', 'menu', 'submenu'));
    }
    //create
    public function create()
    {
        $menu = 'master';
        $submenu = 'organizations';
        return view('pages.organizations.create', compact('menu', 'submenu'));
    }
    //store
    public function store(Request $request)
    {
        //VALIDATION INPUT
        $request->validate([
            'organization_code' => 'required',
            'organization_name' => 'required',
            'organization_type' => 'required',
            'organization_status'=> 'required',
        ]);
        //GENERATE JSON ORGANIZATION
        $organization_code = $request->organization_code;
        $organization_name = $request->organization_name;
        $organization_physical_type = $request->organization_type;
        // CREATE JSON ORGANIZATION
        $organization = new Organization;
        $organization->addIdentifier($organization_code); // unique string free text (increments / UUID / inisial)
        $organization->setName($organization_name); // string free text
        $organization->json();
        //POST ORGANIZATION TO IHS
        [$statusCode, $response] = $organization->post();
        //GET ID ORGANIZATION AS UUID
        $organization_uuid = $response->id;
        //CREAT ORGANIZATION
        $organizations = new Organizations;
        $organizations->organization_code = $request->organization_code;
        $organizations->organization_name = $request->organization_name;
        $organizations->organization_uuid = $organization_uuid;
        $organizations->organization_type = $organization_physical_type;
        $organizations->organization_status = $request->organization_status;
        $organizations->organization_address_use = $request->organization_address_use;
        $organizations->organization_address_line = $request->organization_address_line;
        $organizations->organization_address_city = $request->organization_address_city;
        $organizations->organization_address_country = $request->organization_address_country;
        $organizations->organization_address_postalcode = $request->organization_address_postalcode;
        $organizations->organization_code_province = $request->organization_code_province;
        $organizations->organization_code_city = $request->organization_code_city;
        $organizations->organization_code_district = $request->organization_code_district;
        $organizations->organization_code_village = $request->organization_code_village;
        $organizations->organization_telecom = $request->organization_telecom;
        $organizations->organization_email = $request->organization_email;
        $organizations->save();

        return redirect()->route('organizations.index')->with('success', 'Organization created successfully.');
    }

    //get organization from IHS
    public function edit($id){
        $organization = Organizations::findOrFail($id);
        $menu = 'master';
        $submenu = 'organizations';
        return view('pages.organizations.edit', compact('organization', 'menu', 'submenu'));
    }

    //update
    public function update(Request $request, $id){
        $request->validate([
            'organization_code' => 'required',
            'organization_name' => 'required',
            'organization_type' => 'required',
            'organization_status'=> 'required',
        ]);

        //GENERATE JSON ORGANIZATION
        $organization_code = $request->organization_code;
        $organization_name = $request->organization_name;
        $organization_physical_type = $request->organization_type;
        // CREATE JSON ORGANIZATION
        $organization = new Organization;
        $organization->addIdentifier($organization_code); // unique string free text (increments / UUID / inisial)
        $organization->setName($organization_name); // string free text
        $organization->json();
        //SET UUID LOCATION
        $organization_id = $request->organization_uuid;
        //PUT LOCATION IHS DATABASE
        [$statusCode, $response] = $organization->put($organization_id);
        //PUT TO LOCAL DATABASE
        $organizations = Organizations::findOrFail($id);
        $organizations->update($request->all());
        return redirect()->route('organizations.index')->with('success', 'Organization updated successfully.');
    }

    //destroy
    public function destroy($id){
        $organizations = Organizations::findOrFail($id);
        $organizations->delete();
        return redirect()->route('organizations.index')->with('success', 'Sub Organization deleted successfully.');
    }

}

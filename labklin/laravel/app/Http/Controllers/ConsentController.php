<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\Models\Consent;
use Illuminate\Http\Request;
use App\Models\ProfileClinic;
use Illuminate\Support\Facades\DB;
use Satusehat\Integration\OAuth2Client;

class ConsentController extends Controller
{
    //index
    public function index(Request $request)
    {
        $menu = 'registration';
        $submenu = 'consents';
        $consents = DB::table('consents')
            ->when($request->input('name'), function ($query, $consent_patient_name) {
                return $query->where('consent_patient_name', 'like', '%' . $consent_patient_name . '%');
            })
            ->orderBy('id', 'asc')
            ->paginate(10);
        return view('pages.consents.index', compact('consents', 'menu', 'submenu'));
    }
    //create
    public function create()
    {
        $menu = 'registration';
        $submenu = 'consents';
        $profiles = ProfileClinic::find(1);
        return view('pages.consents.create', compact('profiles', 'menu', 'submenu'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'consent_patient_id' => 'required',
            'consent_patient_mr' => 'required',
            'consent_patient_name' => 'required',
            'consent_action' => 'required',
            'consent_agent' => 'required',
            'environment' => 'required',
        ]);
        $patient_id = $request->consent_patient_id;
        $action = $request->consent_action;
        $agent = $request->consent_agent;
        $environment = $request->environment;
        // Membuat client baru
        $client = new Client();
        //Auth IHS get Token
        $gettoken = new OAuth2Client;
        $token = $gettoken->token();
        // Header request
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json'
        ];
        //JSON Data
        $consent = [
            'patient_id' => $patient_id,
            'action' => $action,
            'agent' => $agent,
        ];
        //URL
        if ($environment == "PROD") {
            $url = "https://api-satusehat.kemkes.go.id/consent/v1/Consent";
        } elseif ($environment == "STG") {
            $url = "https://api-satusehat-stg.dto.kemkes.go.id/consent/v1/Consent";
        } else {
            $url = "https://api-satusehat-dev.dto.kemkes.go.id/consent/v1/Consent";
        }
        // Melakukan request POST
        $response = $client->post($url, [
            'headers' => $headers,
            'json' => $consent
        ]);
        // Mendapatkan isi response
        $body = $response->getBody();
        // Decode JSON response menjadi array PHP
        $data = json_decode($body, true);
        // Mengambil nilai consent id
        $consent_uuid = $data['id'];
        //Save ke DB
        $consents = new Consent;
        $consents->consent_uuid = $consent_uuid;
        $consents->consent_patient_id = $request->consent_patient_id;
        $consents->consent_patient_mr = $request->consent_patient_mr;
        $consents->consent_patient_name = $request->consent_patient_name;
        $consents->consent_action = $request->consent_action;
        $consents->consent_agent = $request->consent_agent;
        $consents->save();
        return redirect()->route('consents.index')->with('success', 'Consent created successfully.');
    }

    //destroy
    public function destroy($id)
    {
        $consents = Consent::findOrFail($id);
        $consents->delete();
        return redirect()->route('consents.index')->with('success', 'Consent deleted successfully.');
    }
}
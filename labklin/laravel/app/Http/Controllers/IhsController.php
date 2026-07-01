<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Location;

class IhsController extends Controller
{
    //Patient
    public function getbynik($id)
    {
        $nik = $id;
        // SETTING API KEY DI OAUTH2 CLIENT TERLEBIH DAHULU
        $client = new OAuth2Client;
        $response = $client->get_by_nik('Patient', $nik);
        $data = $response; //JIKA AMBIL SEMUA JSON
        return $data;
    }

    // Practitioner
    public function getdoctorbynik($id)
    {
        $nik = $id;
        // SETTING API KEY DI OAUTH2 CLIENT TERLEBIH DAHULU
        $client = new OAuth2Client;
        $response = $client->get_by_nik('Practitioner', $nik);
        $data = $response; //JIKA AMBIL SEMUA JSON
        return $data;
    }

    // Location
    public function getorganization($id)
    {
        $client = new OAuth2Client;
        $response = $client->get_organization('Organization', $id);
        $data = $response; // JIKA AMBIL SEMUA JSON
        if ($response) {
            return response()->json(['message' => 'LabKlin Connected to SATUSEHAT.', 'data' => $response], 200);
        } else {
            return response()->json(['message' => 'Connecting Failed'], 400);
        }
    }
}
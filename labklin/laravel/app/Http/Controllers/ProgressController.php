<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FonnteService;

class ProgressController extends Controller
{
    public function development()
    {
        $module = 'Verifikasi SATUSEHAT KYC';
        return view('errors.development', compact('module'));
    }
    function testfonnte($target)
    {
        $response = FonnteService::send($target, 'test message labklin');
        echo $response; //log response fonnte
    }

}
<?php

namespace App\Http\Controllers;

use App\Models\Visit;
use App\Models\Anamnesis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Satusehat\Integration\OAuth2Client;
use Satusehat\Integration\FHIR\Condition;
use Satusehat\Integration\FHIR\Observation;

class AnamnesesController extends Controller
{
    //function store
    public function store(Request $request){


        $request->validate([
            'visit_encounter_id' => 'required',
            'visit_registration_id' => 'unique:anamneses,visit_registration_id',
            'condition_clinicalstatus' => 'required',
            'condition_category' => 'required',
            'visit_icd10_code' => 'required',
            'visit_icd10_display' => 'required',
            'condition_subject_id' => 'required',
            'condition_subject_name' => 'required',
            'condition_onset' => 'required',
            'condition_recorded' => 'required',
            'observation_heartrate' => 'required',
            'observation_respiratory' => 'required',
            'observation_systolic' => 'required',
            'observation_diastolic' => 'required',
            'observation_temperature' => 'required',
        ]);

        $idvisit = $request->idvisit;
        $addClinicalStatus = $request->condition_clinicalstatus;
        $addCategory = $request->condition_category;
        $addCode = $request->visit_icd10_code;
        $condition_display = $request->visit_icd10_display;
        $setSubjectId = $request->condition_subject_id;
        $setSubjectName = $request->condition_subject_name;
        $setOnsetDateTime = $request->condition_onset;
        $setRecordedDate = $request->condition_recorded;
        $setEncounter = $request->visit_encounter_id;
        $setPerformerId = $request->doctor_id;
        $setPerformerName = $request->doctor_name;
        $valueHeartRate = $request->observation_heartrate;
        $valueSystolic = $request->observation_systolic;
        $valueDiastolic = $request->observation_diastolic;
        $valueTemperature = $request->observation_temperature;
        $valueRespiratory = $request->observation_respiratory;

        $time = date('Y-m-d\TH:i:sP'); //DATETIME NOW

        //Update status visit
        $visit = Visit::findOrFail($idvisit);
        $visit->visit_status_timeline = "Waiting";
        $visit->visit_icd10_code = $request->visit_icd10_code;
        $visit->visit_icd10_display = $request->visit_icd10_display;
        $visit->visit_category = $request->condition_category;
        $visit->visit_date_progress = date('Y-m-d H:i:s');
        $visit->visit_clinical_status = $request->condition_clinicalstatus;
        $visit->visit_condition_onset = $request->condition_onset;
        $visit->visit_condition_recorded = $request->condition_recorded;
        $visit->save();

        $client = new OAuth2Client;
        // SEND FHIR CONDITION
        // Make Condition FHIR JSON
        $condition = new Condition;
        $condition->addClinicalStatus($addClinicalStatus); // active, inactive, resolved. Default bila tidak dideklarasi = active
        $condition->addCategory($addCategory); // Diagnosis, Keluhan. Default : Diagnosis
        $condition->addCode($addCode); // Kode ICD10
        $condition->setSubject($setSubjectId, $setSubjectName); // ID SATUSEHAT Pasien dan Nama SATUSEHAT
        $condition->setEncounter($setEncounter); // ID SATUSEHAT Encounter
        $condition->setOnsetDateTime($setOnsetDateTime); // timestamp onset. Timestamp sekarang
        $condition->setRecordedDate($setRecordedDate); // timestamp recorded. Timestamp sekarang
        $body = $condition->json(); //MAKE CONDITION JSON AS BODY
        // dd($body);
        // Type FHIR Resource
        $resource = "Condition"; //FHIR Resource (Bundle, Organization, Location, Patient, Practitioner, Encounter, Condition)
        //POST Agnostic
        [$statusCode, $response] = $client->ss_post($resource, $body);
        // dd($statusCode);
        if($statusCode == 201) {
            //GET ID CONDITION AS UUID
            $condition_id = $response->id;
            //STORE TO ANAMNESES TABLE WITH CONDITION ID
            $anamnesis = new Anamnesis;
            $anamnesis->visit_encounter_id = $request->visit_encounter_id;
            $anamnesis->visit_registration_id = $request->visit_registration_id;
            $anamnesis->condition_code = $request->visit_icd10_code;
            $anamnesis->condition_display = $request->visit_icd10_display;
            $anamnesis->condition_note = $request->condition_note;
            $anamnesis->condition_id = $condition_id;
            //condition
            $anamnesis->condition_clinicalstatus = $request->condition_clinicalstatus;
            $anamnesis->condition_category = $request->condition_category;
            $anamnesis->condition_subject_id = $request->condition_subject_id;
            $anamnesis->condition_subject = $request->condition_subject_name;
            $anamnesis->condition_onset = $request->condition_onset;
            $anamnesis->condition_recorded = $request->condition_recorded;
            //observation
            $anamnesis->observation_heartrate = $request->observation_heartrate;
            $anamnesis->observation_respiratory = $request->observation_respiratory;
            $anamnesis->observation_systolic = $request->observation_systolic;
            $anamnesis->observation_diastolic = $request->observation_diastolic;
            $anamnesis->observation_temperature = $request->observation_temperature;
            $anamnesis->save();

            //Update condition visit
            $visit = Visit::findOrFail($idvisit);
            $visit->visit_condition_id = $condition_id;
            $visit->save();

        }else{
            //STORE TO ANAMNESES TABLE WITHOUT CONDITION ID
            $anamnesis = new Anamnesis;
            $anamnesis->visit_encounter_id = $request->visit_encounter_id;
            $anamnesis->visit_registration_id = $request->visit_registration_id;
            $anamnesis->condition_code = $request->visit_icd10_code;
            $anamnesis->condition_display = $request->visit_icd10_display;
            $anamnesis->condition_note = $request->condition_note;
            //condition
            $anamnesis->condition_clinicalstatus = $request->condition_clinicalstatus;
            $anamnesis->condition_category = $request->condition_category;
            $anamnesis->condition_subject_id = $request->condition_subject_id;
            $anamnesis->condition_subject = $request->condition_subject_name;
            $anamnesis->condition_onset = $request->condition_onset;
            $anamnesis->condition_recorded = $request->condition_recorded;
            //observation
            $anamnesis->observation_heartrate = $request->observation_heartrate;
            $anamnesis->observation_respiratory = $request->observation_respiratory;
            $anamnesis->observation_systolic = $request->observation_systolic;
            $anamnesis->observation_diastolic = $request->observation_diastolic;
            $anamnesis->observation_temperature = $request->observation_temperature;
            $anamnesis->save();
        }
        // Type FHIR Resource
        $ResourceObservation = "Observation"; //FHIR Resource (Bundle, Organization, Location, Patient, Practitioner, Encounter, Condition)
        // SEND FHIR OBSERVATION
        //HeartRate FHIR JSON
        $observation = new Observation;
        $observation->setStatus("final");
        $observation->addCategory("vital-signs"); //VitalSigns
        $observation->addCode("8867-4"); //Code LOINC
        $observation->setSubject($setSubjectId, $setSubjectName); //Patient ID, Patient Name
        $observation->setPerformer($setPerformerId, $setPerformerName); //Practitioner ID, Practitioner Name
        $observation->setEncounter($setEncounter, $setSubjectName); //Encounter ID
        $observation->effectiveDateTime($time);
        $observation->issued($time);
        $observation->setValueQuantity($valueHeartRate, "beats/min", "/min"); //value, unit, code
        $bodyHeartRate = $observation->json();
        //POST
        [$statusCodeHeartRate, $responseHeartRate] = $client->ss_post($ResourceObservation, $bodyHeartRate);
        // if($statusCodeObs == 201){
        //     //GET ID OBSERVATION AS UUID
        //     $observation_heartrate_id = $responseObs->id;
        //     //Update observation anamneses
        //     // $anamnesis = Anamnesis::where('visit_encounter_id', $setEncounter);
        //     // $anamnesis->observation_heartrate_id = $observation_heartrate_id;
        //     // $anamnesis->save();
        //     DB::table('anamneses')
        //     ->where('visit_encounter_id', $setEncounter)
        //     ->update(['observation_heartrate_id' =>  $observation_heartrate_id]);
        // }
        // dd($statusCodeObs);

        //RespiratoryRate FHIR JSON
        $observation1 = new Observation;
        $observation1->setStatus("final");
        $observation1->addCategory("vital-signs"); //VitalSigns
        $observation1->addCode("9279-1"); //Code LOINC
        $observation1->setSubject($setSubjectId, $setSubjectName); //Patient ID, Patient Name
        $observation1->setPerformer($setPerformerId, $setPerformerName); //Practitioner ID, Practitioner Name
        $observation1->setEncounter($setEncounter, $setSubjectName); //Encounter ID
        $observation1->effectiveDateTime($time);
        $observation1->issued($time);
        $observation1->setValueQuantity($valueRespiratory, "breaths/min", "/min");//value, unit, code
        $bodyRespiratoryRate = $observation1->json();
        //POST
        [$statusCodeRespiratoryRate, $responseRespiratoryRate] = $client->ss_post($ResourceObservation, $bodyRespiratoryRate);

        //Systolic FHIR JSON
        $observation2 = new Observation;
        $observation2->setStatus("final");
        $observation2->addCategory("vital-signs"); //VitalSigns
        $observation2->addCode("8480-6"); //Code LOINC
        $observation2->setSubject($setSubjectId, $setSubjectName); //Patient ID, Patient Name
        $observation2->setPerformer($setPerformerId, $setPerformerName); //Practitioner ID, Practitioner Name
        $observation2->setEncounter($setEncounter, $setSubjectName); //Encounter ID
        $observation2->effectiveDateTime($time);
        $observation2->issued($time);
        $observation2->setValueQuantity($valueSystolic, "mm[Hg]", "mm[Hg]");//value, unit, code
        $bodySystolic = $observation2->json();
        //POST
        [$statusCodeSystolic, $responseSystolic] = $client->ss_post($ResourceObservation, $bodySystolic);

        //Diastolic FHIR JSON
        $observation3 = new Observation;
        $observation3->setStatus("final");
        $observation3->addCategory("vital-signs"); //VitalSigns
        $observation3->addCode("8462-4"); //Code LOINC
        $observation3->setSubject($setSubjectId, $setSubjectName); //Patient ID, Patient Name
        $observation3->setPerformer($setPerformerId, $setPerformerName); //Practitioner ID, Practitioner Name
        $observation3->setEncounter($setEncounter, $setSubjectName); //Encounter ID
        $observation3->effectiveDateTime($time);
        $observation3->issued($time);
        $observation3->setValueQuantity($valueDiastolic, "mm[Hg]", "mm[Hg]");//value, unit, code
        $bodyDiastolic = $observation3->json();//value, unit, code
        //POST
        [$statusCodeDiastolic, $responseDiastolic] = $client->ss_post($ResourceObservation, $bodyDiastolic);

        //Temperature FHIR JSON
        $observation4 = new Observation;
        $observation4->setStatus("final");
        $observation4->addCategory("vital-signs"); //VitalSigns
        $observation4->addCode("8310-5"); //Code LOINC
        $observation4->setSubject($setSubjectId, $setSubjectName); //Patient ID, Patient Name
        $observation4->setPerformer($setPerformerId, $setPerformerName); //Practitioner ID, Practitioner Name
        $observation4->setEncounter($setEncounter, $setSubjectName); //Encounter ID
        $observation4->effectiveDateTime($time);
        $observation4->issued($time);
        $observation4->setValueQuantity($valueTemperature, "C", "Cel");//value, unit, code
        $bodyTemperature = $observation4->json();
        //POST
        [$statusCodeTemperature, $responseTemperature] = $client->ss_post($ResourceObservation, $bodyTemperature);
        if($statusCodeTemperature == 201){
            //GET ID OBSERVATION AS UUID
            $observation_heartrate_id = $responseHeartRate->id;
            $observation_respiratoryrate_id = $responseRespiratoryRate->id;
            $observation_systolic_id = $responseSystolic->id;
            $observation_diastolic_id = $responseDiastolic->id;
            $observation_temperature_id = $responseTemperature->id;
            //Update observation anamneses
            DB::table('anamneses')
                ->where('visit_encounter_id', $setEncounter)
                ->update([
                    'observation_heartrate_id' => $observation_heartrate_id,
                    'observation_respiratory_id' => $observation_respiratoryrate_id,
                    'observation_systolic_id' => $observation_systolic_id,
                    'observation_diastolic_id' => $observation_diastolic_id,
                    'observation_temperature_id' => $observation_temperature_id,
                ]);
            DB::table('visits')
                ->where('visit_encounter_id', $setEncounter)
                ->update([
                    'visit_observation_id' => $observation_heartrate_id,
                ]);
            return redirect()->route('visits.index')->with('success', 'Anamneses & Observation FHIR Condition created successfully.');
        }else{
            return redirect()->route('visits.index')->with('warning', 'Anamneses & Observation FHIR Condition failed to created.');
        }
    }
}

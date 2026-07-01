<?php
//QRCode Library
require_once ("phpqrcode/qrlib.php");

// Hitung Umur
$age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align

Fpdf::SetMargins(10, 42, 10);
Fpdf::SetAutoPageBreak(true, 25);
Fpdf::AddPage();
Fpdf::SetTitle('Resume - ' . $patient->patient_name . ' - ' . $patient->patient_mr);
Fpdf::SetFont('Courier', 'B', 12);
Fpdf::SetAuthor('LabKlin Systems');
Fpdf::SetXY(10, 42);
Fpdf::Cell(190, 5, 'e-MEDICAL RECORD', 0, 1,'C');

//PATIENT DATA
fpdf::SetXY(10, 47);
fpdf::SetFont('Courier', '', 10);
fpdf::Cell(35, 6, 'Identity Number', 'TL', 0, 'L');
fpdf::Cell(5, 6, ':', 'T', 0, 'C');
fpdf::SetFont('Courier', 'B', 10);
fpdf::Cell(150, 6, $patient->patient_nik, 'TR', 1, 'L');
fpdf::SetFont('Courier', '', 10);
fpdf::Cell(35, 6, 'Medical Record', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(70, 6, $patient->visit_patient_mr . ' / ' . $patient->patient_ihs, 0, 0, 'L');
fpdf::Cell(80, 6, '', 'R', 1, 'L');
fpdf::Cell(35, 6, 'Patient Name', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::SetFont('Courier', 'B', 10);
fpdf::Cell(70, 6, $patient->patient_name . ' (' . ucfirst($patient->patient_gender) . ')', 0, 0, 'L');
fpdf::SetFont('Courier', '', 10);
fpdf::Cell(80, 6, '', 'R', 1, 'L');
fpdf::Cell(35, 6, 'Birth Date', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(70, 6, date('d-m-Y', strtotime($patient->patient_birthdate)) . ' (' . $age . ' Years )', 0, 0, 'L');
fpdf::Cell(80, 6, $patient->patient_mr, 'R', 1, 'C');
fpdf::Cell(35, 6, 'FHIR Status', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(70, 6, ucfirst($patient->patient_status), 0, 0, 'L');
fpdf::Cell(80, 6, '', 'R', 1, 'L');
fpdf::Cell(35, 6, 'Last Update', 'LB', 0, 'L');
fpdf::Cell(5, 6, ':', 'B', 0, 'C');
fpdf::Cell(70, 6, $patient->updated_at, 'B', 0, 'L');
fpdf::Cell(80, 6, '', 'BR', 1, 'L');
fpdf::Cell(190, 3, '', 'T', 1, 'C'); //TUTUP TABEL BAWAH
//CODE 128
$code= $patient->patient_mr;
fpdf::Code128(135,50,$code,50,15);
//CODE 128 IMAGE

//LOOP VISIT DATA
foreach ($visit as $visiting) {
    //make date format
    $date = $visiting->visit_date;
    $date = date('d - m - Y', strtotime($date));
    fpdf::SetFont('Arial', 'B', 8);
    fpdf::Cell(30, 6, $date, 1, 0, 'L');
    fpdf::Cell(55, 6, 'No. Reg : '.$visiting->visit_registration_id, 1, 0, 'L');
    fpdf::Cell(105, 6, 'Doctor : '.$visiting->visit_doctor_name, 1, 1, 'L');
    fpdf::SetFont('Arial', 'I', 8);
    fpdf::Cell(190, 6, 'ICD-10 : '.$visiting->visit_icd10_code.' - '.$visiting->visit_icd10_display, 1, 1, 'L');
    fpdf::SetFont('Arial', '', 8);
    fpdf::Cell(190, 6, 'Vital Sign : HeartRate = '.$visiting->observation_heartrate.' /Minutes, BloodPressure = '.$visiting->observation_systolic.'/'.$visiting->observation_diastolic.' mmHg, RespiratoryRate = '.$visiting->observation_respiratory.' /Minutes, Temperature = '.$visiting->observation_temperature.' ^C', 'LR', 1, 'L');

// GET X DAN Y
    fpdf::getX();
    fpdf::getY();
    fpdf::Cell(30, 6, 'Time Service', 1, 0, 'C');
    fpdf::Cell(55, 6, 'Laboratory Test', 1, 0, 'C');
    fpdf::Cell(35, 6, 'Result', 1, 0, 'C');
    fpdf::Cell(25, 6, 'Reference', 1, 0, 'C');
    fpdf::Cell(10, 6, 'Flag', 1, 0, 'C');
    fpdf::Cell(35, 6, 'Handler', 1, 1, 'C');
//QUERY GET DATA LABS
    $noreg = $visiting->visit_registration_id;
    $labdetail = DB::table('services_detail')
            ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
            ->where('service_visit_registration_id', $noreg)
            ->whereNotNull('services_detail.service_time_result')
            ->whereNotNull('services_detail.service_loinc_code')
            ->orderBy('service_group')
            ->orderBy('service_servicerequest_id')
            ->get();
//LOOP DATA
    foreach ($labdetail as $record) {
    //make date format
        $timeresult = $record->service_time_result;
        $timeresult = date('d-m-Y H:i:s', strtotime($timeresult));
        fpdf::Cell(30, 6, $timeresult, 'L', 0, 'L');
        if($record->test_category == 'Panel'){
            fpdf::SetFont('Arial', 'B', 8);
            fpdf::Cell(55, 6, $record->service_name, 'L', 0, 'L');
            fpdf::SetFont('Arial', '', 8);
        }elseif($record->test_category == 'Sub Panel'){
            fpdf::Cell(55, 6, '     '.$record->service_name, 'L', 0, 'L');
        }else{
            fpdf::Cell(55, 6, $record->service_name, 'L', 0, 'L');
        }
        fpdf::Cell(35, 6, $record->service_result.' '.$record->test_unit, 'L', 0, 'L');
        if($record->test_category == 'Panel'){
            fpdf::Cell(25, 6, '', 'L', 0, 'L');
        }else{
            fpdf::Cell(25, 6, $record->service_reference, 'L', 0, 'L');
        }
        fpdf::Cell(10, 6, $record->service_flag, 'L', 0, 'C');
        fpdf::Cell(35, 6, $record->service_handler, 'LR', 1, 'C');
    }
    fpdf::MultiCell(190, 6, 'Expertise : '.$visiting->visit_validation_impression, 'BLRT', 'L', 0);
    fpdf::Cell(190, 3, '', 0, 1, 'C'); //TUTUP TABEL BAWAH
}

$named = $patient->visit_patient_name;
$noreg = $patient->patient_mr;
// TOTAL PAGE
fpdf::AliasNbPages();
Fpdf::Output('Lab Report - ' . $named . ' - ' . $noreg . '.pdf', 'I');
exit();

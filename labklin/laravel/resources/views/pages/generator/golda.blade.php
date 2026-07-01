<?php

use Codedge\Fpdf\Facades\Fpdf;
//QRCode Library
// require_once ("phpqrcode/qrlib.php");
// Hitung Umur
$age = \Carbon\Carbon::parse($golda->patient_birthdate)->age;
Fpdf::SetTitle('Golda - ' . $golda->visit_registration_id);
Fpdf::SetMargins(10, 25, 1);
Fpdf::SetAutoPageBreak(true, 1);
if ($golda->patient_gender == 'male') {
    $gender = 'L';
} elseif ($golda->patient_gender == 'female') {
    $gender = 'P';
}
$date = date('d-m-Y', strtotime($golda->visit_date));
$datebirth = date('d-m-Y', strtotime($golda->patient_birthdate));
$tested = date('d-m-Y h:i:s', strtotime($golda->updated_at));

Fpdf::AddPageBlank('P', 'card', 0); //Orientation, Paper Size, Rotation
//LOAD TEMPLATE
Fpdf::Image('template/golda.png', 0, 0, -170);
Fpdf::SetFont('Arial', 'B', 16);
Fpdf::Cell(130, 10, 'KARTU GOLONGAN DARAH', 0, 1, 'C');
Fpdf::SetY(40);
Fpdf::SetFont('Arial', 'B', 14);
Fpdf::Cell(80, 8, $golda->visit_patient_name, 0, 1, 'L');
Fpdf::SetFont('Arial', '', 14);
Fpdf::Cell(80, 8, $golda->patient_nik, 0, 1, 'L');
Fpdf::Cell(80, 8, $datebirth . ' (' . $age . ' Tahun)', 0, 1, 'L');

//BARCODE
$code = $golda->visit_registration_id;
Fpdf::Code128(10, 65, $code, 65, 12);
Fpdf::SetFont('Courier', '', 12);
Fpdf::SetY(76);
Fpdf::Cell(65, 6, $code, 0, 1, 'C');
Fpdf::SetFont('Arial', '', 8);
Fpdf::SetY(81);
Fpdf::Cell(65, 6, 'Test Validated : ' . $tested, 0, 1, 'L');

if ($golda->service_result == 'Group AB') {
    $abo = 'AB';
    $rhesus = '';
} elseif ($golda->service_result == 'Group A') {
    $abo = 'A';
    $rhesus = '';
} elseif ($golda->service_result == 'Group B') {
    $abo = 'B';
    $rhesus = '';
} elseif ($golda->service_result == 'Group O') {
    $abo = 'O';
    $rhesus = '';
} elseif ($golda->service_result == 'AB Pos') {
    $abo = 'AB';
    $rhesus = 'Rh(+)';
} elseif ($golda->service_result == 'A Pos') {
    $abo = 'A';
    $rhesus = 'Rh(+)';
} elseif ($golda->service_result == 'B Pos') {
    $abo = 'B';
    $rhesus = 'Rh(+)';
} elseif ($golda->service_result == 'O Pos') {
    $abo = 'O';
    $rhesus = 'Rh(+)';
} elseif ($golda->service_result == 'AB Neg') {
    $abo = 'AB';
    $rhesus = 'Rh(-)';
} elseif ($golda->service_result == 'A Neg') {
    $abo = 'A';
    $rhesus = 'Rh(-)';
} elseif ($golda->service_result == 'B Neg') {
    $abo = 'B';
    $rhesus = 'Rh(-)';
} elseif ($golda->service_result == 'O Neg') {
    $abo = 'O';
    $rhesus = 'Rh(-)';
} else {
    $abo = '';
    $rhesus = '';
}


Fpdf::SetXY(100, 40);
Fpdf::SetFont('Arial', 'B', 50);
Fpdf::Cell(40, 20, $abo, 0, 1, 'C');

if ($golda->service_code == 'GDR') {
    Fpdf::SetXY(100, 60);
    Fpdf::SetFont('Arial', 'B', 30);
    Fpdf::Cell(40, 20, $rhesus, 0, 1, 'C');
}



Fpdf::Output('Kartu Golda - ' . $golda->visit_patient_name . '.pdf', 'I');
exit();
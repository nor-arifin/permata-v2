<?php
//QRCode Library
require_once("phpqrcode/qrlib.php");
// Hitung Umur
$age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align
Fpdf::AddPage();
Fpdf::SetTitle('Lab Report - ' . $visit->visit_patient_name . ' - ' . $visit->visit_registration_id);
Fpdf::SetFont('Arial', 'B', 12);
Fpdf::SetAuthor('LabKlin Systems');
Fpdf::SetXY(10, 42);
Fpdf::Cell(190, 5, 'Laboratory Report', 0, 1, 'C');

//PATIENT DATA
fpdf::SetXY(10, 47);
fpdf::SetFont('Arial', '', 10);
fpdf::Cell(30, 6, 'No. Registration', 'TL', 0, 'L');
fpdf::Cell(5, 6, ':', 'T', 0, 'C');
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(155, 6, $visit->visit_registration_id, 'TR', 1, 'L');
fpdf::SetFont('Arial', '', 10);
fpdf::Cell(30, 6, 'Medical Record', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(75, 6, $visit->visit_patient_mr . ' / ' . $patient->patient_ihs, 0, 0, 'L');
fpdf::Cell(20, 6, 'Doctor', 0, 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(55, 6, $visit->visit_doctor_name, 'R', 1, 'L');
fpdf::Cell(30, 6, 'Patient Name', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(75, 6, $visit->visit_patient_name . ' (' . ucfirst($patient->patient_gender) . ')', 0, 0, 'L');
fpdf::Cell(20, 6, 'Department', 0, 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(55, 6, $visit->visit_patient_dept, 'R', 1, 'L');
fpdf::Cell(30, 6, 'Birth Date', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(75, 6, date('d-m-Y', strtotime($patient->patient_birthdate)) . ' (' . $age . ' Years )', 0, 0, 'L');
fpdf::Cell(20, 6, 'Registered', 0, 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(55, 6, $visit->visit_date_arrived, 'R', 1, 'L');
fpdf::Cell(30, 6, 'Patient Status', 'LB', 0, 'L');
fpdf::Cell(5, 6, ':', 'B', 0, 'C');
fpdf::Cell(75, 6, $visit->visit_patient_status, 'B', 0, 'L');
fpdf::Cell(20, 6, 'Notes', 'B', 0, 'L');
fpdf::Cell(5, 6, ':', 'B', 0, 'C');
fpdf::Cell(55, 6, $visit->visit_method, 'BR', 1, 'L');
//HEADER TABLE
fpdf::SetY(80);
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(80, 6, 'Parameter', 'TB', 0, 'C');
fpdf::Cell(10, 6, '', 'TB', 0, 'C');
fpdf::Cell(40, 6, 'Result', 'TB', 0, 'C');
fpdf::Cell(40, 6, 'Reference Range', 'TB', 0, 'C');
fpdf::Cell(20, 6, 'Unit', 'TB', 1, 'C');
//LOOP DATA
fpdf::SetFont('Arial', '', 10);
foreach ($results as $result) {

    $gender = $patient->patient_gender;
    $resultvalue = $result->service_result;
    $resulttype = $result->test_resulttype;
    $reference = $result->service_reference;
    //CHECK MIN MAX RESULT
    if ($resulttype == "Qn") {
        if ($age > 12 && $age <= 200) {
            if ($gender == 'male') {
                $min = $result->test_min_male;
                $max = $result->test_max_male;
            } elseif ($gender == 'female') {
                $min = $result->test_min_female;
                $max = $result->test_max_female;
            }
        } elseif ($age <= 12 && $age > 1) {
            $min = $result->test_min_child;
            $max = $result->test_max_child;
        } elseif ($age <= 1) {
            $min = $result->test_min_baby;
            $max = $result->test_max_baby;
        } else {
            $min = $result->test_min_general;
            $max = $result->test_max_general;
        }
    } else {
        $min = $reference;
        $max = $reference;
    }
    // CHECK FLAG
    if ($resulttype == "Qn" && $reference != "Terlampir") {
        if ($resultvalue < $min && $resultvalue < $max) {
            $flag = "L";
        } elseif ($resultvalue > $min && $resultvalue > $max) {
            $flag = "H";
        } elseif ($resultvalue > $min && $resultvalue < $max) {
            $flag = "";
        } else {
            $flag = "";
        }
    } elseif ($resulttype != "Qn" && $reference != null) {
        if ($resultvalue != $reference) {
            $flag = "*";
        } else {
            $flag = "";
        }
    } else {
        $flag = "";
    }
    if ($result->test_category == "Panel") {
        fpdf::SetFont('Arial', 'B', 10);
        fpdf::Cell(80, 6, $result->service_name, 0, 0, 'L');
        fpdf::SetFont('Arial', '', 10);
    } elseif ($result->test_category == "Single") {
        fpdf::Cell(80, 6, $result->service_name, 0, 0, 'L');
    } else {
        fpdf::Cell(80, 6, '     ' . $result->service_name, 0, 0, 'L');
    }
    fpdf::SetFont('Arial', 'B', 8);
    fpdf::SetTextColor(255, 0, 0);
    fpdf::Cell(10, 6, $flag, 0, 0, 'C');
    fpdf::SetFont('Arial', '', 10);
    fpdf::SetTextColor(0, 0, 0);
    fpdf::Cell(40, 6, $result->service_result, 0, 0, 'C');
    if ($result->service_reference != "Terlampir") {
        fpdf::Cell(40, 6, $result->service_reference, 0, 0, 'C');
    } else {
        fpdf::Cell(40, 6, '', 0, 0, 'C');
    }
    fpdf::Cell(20, 6, $result->test_unit, 0, 1, 'C');
}
//IMPRESSION
if ($visit->visit_validation_impression != null) {
    fpdf::SetFont('Arial', 'B', 10);
    fpdf::Cell(190, 6, 'Expertise :', 'T', 1, 'L');
    fpdf::SetFont('Arial', '', 8);
    fpdf::setFillColor(255, 255, 255);
    fpdf::MultiCellNoFill(190, 4, $visit->visit_validation_impression, 0, 1, 'J');
}
// NOTES
$collected = date('d-m-Y H:i:s', strtotime($visit->visit_time_sampling));
$received = date('d-m-Y H:i:s', strtotime($visit->visit_time_receive));
$validated = date('d-m-Y H:i:s', strtotime($visit->visit_time_validation));
$reporting = date('d-m-Y', strtotime($visit->visit_time_validation));
$collector = $visit->visit_sampling_by;
$receiver = $visit->visit_receive_by;
$validator = $visit->visit_validation_by;
fpdf::Cell(190, 2, '', 'B', 1, 'L');
fpdf::SetFont('Arial', 'I', 8);
fpdf::Cell(30, 4, '# Specimen Collected', 0, 0, 'L');
fpdf::Cell(5, 4, ':', 0, 0, 'L');
fpdf::Cell(30, 4, $collected, 0, 0, 'L');
fpdf::Cell(60, 4, '| ' . $collector, 0, 1, 'L');
fpdf::Cell(30, 4, '# Specimen Received', 0, 0, 'L');
fpdf::Cell(5, 4, ':', 0, 0, 'L');
fpdf::Cell(30, 4, $received, 0, 0, 'L');
fpdf::Cell(60, 4, '| ' . $receiver, 0, 1, 'L');
fpdf::Cell(30, 4, '# Result Validated', 0, 0, 'L');
fpdf::Cell(5, 4, ':', 0, 0, 'L');
fpdf::Cell(30, 4, $validated, 0, 0, 'L');
fpdf::Cell(60, 4, '| ' . $validator, 0, 1, 'L');
fpdf::Cell(190, 4, '', 0, 1, 'L');
// IMAGE
$encode = $visit->visit_encoded;
$public = url('/verify/labreport/');
$qrlink = $public . "/" . $encode;
QRcode::png($qrlink, "qr.png");
$x = fpdf::GetX();
$y = fpdf::GetY();
fpdf::Image("qr.png", $x, $y - 5, 23, 23, "png");
//ENGLISH
fpdf::setX(35);
fpdf::Cell(155, 4, 'The results are numbers using a decimal system with a dot separator.', 0, 1, 'L');
fpdf::setX(35);
fpdf::Cell(155, 4, 'Mark H for results above normal values, mark L for results below normal values, and * for results requiring attention.', 0, 1, 'L');
fpdf::setX(35);
fpdf::Cell(155, 4, 'Interpretation of results is only carried out by doctors / clinicians.', 0, 1, 'L');
fpdf::setX(35);
fpdf::Cell(155, 4, 'For security your data, please do not post on public social media.', 0, 1, 'L');
//INDONESIA
// fpdf::Cell(190, 4, 'Hasil berupa angka menggunakan sistem desimal dengan separator titik.', 0, 1, 'L');
// fpdf::Cell(190, 4, 'Tanda H untuk hasil diatas nilai normal, tanda L untuk hasil dibawah nilai normal, dan * untuk hasil membutuhkan perhatian.', 0, 1, 'L');
// fpdf::Cell(190, 4, 'Interpretasi hasil hanya dilakukan oleh dokter / klinisi.', 0, 1, 'L');
// fpdf::Cell(190, 4, 'Demi menjaga kerahasiaan data Anda, harap tidak mengunggah pada media sosial publik.', 0, 1, 'L');


//Cek apakah sisa halaman > 280
if (Fpdf::GetY() > 280) {
    Fpdf::AddPage();
}
$yttd = Fpdf::GetY();
Fpdf::SetY($yttd + 3);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(190, 6, 'Palangka Raya, ' . date('d - m - Y', strtotime($reporting)), 0, 1, 'R');
Fpdf::SetY($yttd + 12);
Fpdf::Cell(95, 6, 'Penanggungjawab Teknis', 0, 0, 'C');
Fpdf::Cell(95, 6, 'Kepala Seksi', 0, 1, 'C');
Fpdf::Cell(95, 6, 'Penanggung Jawab Teknis Laboratorium Klinik', 0, 0, 'C');
Fpdf::Cell(95, 6, 'Laboratorium Kesehatan Masyarakat dan Klinik', 0, 1, 'C');
Fpdf::Cell(95, 20, '', 0, 0, 'C');
Fpdf::Cell(95, 20, '', 0, 1, 'C');
Fpdf::Cell(95, 5, 'dr. LESTARI, Sp.PK', 0, 0, 'C');
Fpdf::Cell(95, 5, 'AGUS, S.Si., M.MKes', 0, 1, 'C');
Fpdf::Cell(95, 5, 'NIP. 19810514 200904 2 003', 0, 0, 'C');
Fpdf::Cell(95, 5, 'NIP. 19700801 199803 1 009', 0, 1, 'C');

$named = $visit->visit_patient_name;
$noreg = $visit->visit_registration_id;
// TOTAL PAGE
fpdf::AliasNbPages();
Fpdf::Output('Lab Report - ' . $named . ' - ' . $noreg . '.pdf', 'I');
exit();
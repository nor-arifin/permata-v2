<?php
//QRCode Library
require_once("phpqrcode/qrlib.php");
// Hitung Umur
// $age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align
//Jenis Kelamin
// if ($patient->patient_gender === 'Female') {
//     $gender = 'P';
// } else {
//     $gender = 'L';
// }
$bitrhdate = date('d-m-Y', strtotime($patient->patient_birthdate));
$letterdate = date('d-m-Y', strtotime($regnapza->letter_napza_date));
$thisyear = date('Y');
$thismonth = date('m');
$thisdate = date('d-m-Y');
// Convert $thismonth to Roman numeral
function monthToRoman($month)
{
    $romans = [
        1 => 'I',
        2 => 'II',
        3 => 'III',
        4 => 'IV',
        5 => 'V',
        6 => 'VI',
        7 => 'VII',
        8 => 'VIII',
        9 => 'IX',
        10 => 'X',
        11 => 'XI',
        12 => 'XII'
    ];
    return $romans[(int) $month];
}
function convertToIndonesianDate($date)
{
    $months = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];

    $dateParts = explode('-', $date);
    $day = $dateParts[0];
    $month = $months[(int) $dateParts[1]];
    $year = $dateParts[2];

    return $day . ' ' . $month . ' ' . $year;
}

$thisdateIndonesian = convertToIndonesianDate($thisdate);

$thismonthRoman = monthToRoman($thismonth);
//gender to indonesian
if ($patient->patient_gender === 'male') {
    $gender = 'Laki-laki';
    $gendertitle = 'L';
} else {
    $gender = 'Perempuan';
    $gendertitle = 'P';
}

// IMAGE
$encode = $regnapza->letter_napza_encode;
$public = url('/verify-napza/sk/');
$qrlink = $public . "/" . $encode;
QRcode::png($qrlink, "napza.png");

Fpdf::AddPage();
Fpdf::SetMargins(20, 38, 15);
Fpdf::SetTitle('SK NAPZA - ' . $patient->patient_name . ' - ' . $regnapza->letter_napza_number);
Fpdf::SetFont('Arial', 'BU', 12);
Fpdf::SetAuthor('LabKlin Systems');
Fpdf::SetXY(20, 42);
Fpdf::Cell(170, 5, 'SURAT KETERANGAN PEMERIKSAAN NARKOBA', 0, 1, 'C');
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(170, 5, 'Nomor : ' . $regnapza->letter_napza_number, 0, 1, 'C');

Fpdf::SetY(50);
$text = '
Yang bertanda tangan dibawah ini dokter UPT. Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah, mengingat sumpah jabatan menerangkan :';
Fpdf::Justify($text, 170, 6);
Fpdf::Cell(50, 7, 'Nama', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, $patient->patient_name, 0, 1, 'L');
Fpdf::Cell(50, 7, 'NIK', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, $patient->patient_nik, 0, 1, 'L');
Fpdf::Cell(50, 7, 'Tempat, Tanggal Lahir', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, ucfirst($patient->patient_birthplace) . ', ' . convertToIndonesianDate($bitrhdate), 0, 1, 'L');
Fpdf::Cell(50, 7, 'Jenis Kelamin', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, $gender, 0, 1, 'L');
Fpdf::Cell(50, 7, 'Pekerjaan', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, $patient->patient_profession, 0, 1, 'L');
Fpdf::Cell(50, 7, 'Alamat', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, $patient->patient_address_line . ' ' . $patient->patient_address_city, 0, 1, 'L');
Fpdf::Cell(50, 7, 'No. Kontak', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, $patient->patient_telecom, 0, 1, 'L');
Fpdf::Cell(50, 7, 'Keperluan', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 1, 'L');
Fpdf::SetXY(73, 117.5);
$text = $regnapza->letter_napza_purpose;
// Fpdf::Write($text, 117, 7);
// MultiCell(float w, float h, string txt [, mixed border [, string align [, boolean fill]]])
Fpdf::MultiCellNoFill(117, 7, $text, 0, 0, 'C');
// Fpdf::Cell(170, 7, $regnapza->letter_napza_purpose, 0, 1, 'C');
$text = 'Bahwa SAAT INI ' . $regnapza->letter_napza_conclution . ' ADANYA BAHAN NARKOBA berdasarkan Laporan Hasil Uji (LHU) laboratorium dibawah ini :';
Fpdf::Justify($text, 170, 6);
// DATA LHU
Fpdf::Cell(50, 7, 'Nomor Sampel', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, $regnapza->letter_napza_lhu, 0, 1, 'L');
Fpdf::Cell(50, 7, 'Tanggal Pemeriksaan', 0, 0, 'L');
Fpdf::Cell(3, 7, ':', 0, 0, 'L');
Fpdf::Cell(117, 7, convertToIndonesianDate(date('d-m-Y', strtotime($regnapza->visit_time_validation))), 0, 1, 'L');
Fpdf::Cell(50, 7, 'Parameter yang diuji :', 0, 1, 'L');
// HASIL LHU
$yy = Fpdf::GetY();
Fpdf::SetXY(30, $yy);
Fpdf::SetFont('Arial', 'B', 10);
Fpdf::Cell(10, 7, 'No.', 1, 0, 'C');
Fpdf::Cell(70, 7, 'Parameter', 1, 0, 'C');
Fpdf::Cell(70, 7, 'Hasil', 1, 1, 'C');
Fpdf::SetFont('Arial', '', 10);
//Napza
$napza = array(
    '4MP',
    '4HC',
    '4OP',
    '4NZ',
    '4MT',
    'AMP',
    'MET',
    'BNZ',
    'THC',
    'MOP',
    'COC',
    'SOM',
);
//Get Results

$results = DB::table('services_detail')
    ->where('services_detail.service_visit_registration_id', $regnapza->letter_napza_lhu)
    ->whereIn('services_detail.service_code', $napza)
    ->select(
        'services_detail.service_name',
        'services_detail.service_result',
    )
    ->orderBy('services_detail.id', 'asc')
    ->get();

$no = 0;
foreach ($results as $data) {
    $no++;
    Fpdf::SetX(30);
    Fpdf::Cell(10, 7, $no . '.', 1, 0, 'C');
    Fpdf::Cell(70, 7, $data->service_name, 1, 0, 'L');
    Fpdf::Cell(70, 7, $data->service_result, 1, 1, 'C');
}

$text = 'Demikian surat keterangan ini dibuat untuk dipergunakan sebagaimana mestinya.';
Fpdf::Justify($text, 170, 6);
//TANDATANGAN
$y = Fpdf::GetY();
Fpdf::SetY($y + 3);
Fpdf::SetX(30);
Fpdf::Cell(80, 6, '', 0, 0, 'C');
Fpdf::Cell(30, 6, 'Dikeluarkan di', 0, 0, 'L');
Fpdf::Cell(5, 6, ':', 0, 0, 'C');
Fpdf::Cell(45, 6, 'Palangka Raya', 0, 1, 'L');
Fpdf::SetX(30);
Fpdf::Cell(80, 6, '', 0, 0, 'C');
Fpdf::Cell(30, 6, 'Pada tanggal', 0, 0, 'L');
Fpdf::Cell(5, 6, ':', 0, 0, 'C');
Fpdf::Cell(45, 6, convertToIndonesianDate($letterdate), 0, 1, 'L');
$yttd = Fpdf::GetY();
Fpdf::SetY($yttd + 3);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(85, 6, 'Mengetahui,', 0, 0, 'C');
Fpdf::Cell(85, 6, '', 0, 1, 'C');
Fpdf::Cell(85, 6, 'Kepala UPT. Laboratorium Kesehatan dan Kalibrasi', 0, 0, 'C');
Fpdf::Cell(85, 6, 'Dokter Pemeriksa,', 0, 1, 'C');
Fpdf::Cell(85, 6, 'Provinsi Kalimantan Tengah', 0, 0, 'C');
Fpdf::Cell(85, 6, '', 0, 1, 'C');
Fpdf::Cell(85, 15, '', 0, 0, 'C');
Fpdf::Cell(85, 15, '', 0, 1, 'C');
Fpdf::SetFont('Arial', 'B', 10);
Fpdf::Cell(85, 5, 'LAYUMUATULU, SKM., MAP', 0, 0, 'C');
Fpdf::Cell(85, 5, $regnapza->letter_napza_signed, 0, 1, 'C');
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(85, 5, 'NIP. 19671112 199002 2 003', 0, 0, 'C');

if ($regnapza->letter_napza_signed == 'dr. LESTARI, Sp.PK') {
    Fpdf::Cell(85, 5, 'NIP. 19810514 200904 2 003', 0, 1, 'C');
} else if ($regnapza->letter_napza_signed == 'dr. VALENCIA WILENTINE') {
    Fpdf::Cell(85, 5, 'NIP. 19811021 200903 2 001', 0, 1, 'C');
} else {
    Fpdf::Cell(85, 5, 'NIP. 19800313 200604 2 018', 0, 1, 'C');
}

//Barcode
$x = fpdf::GetX();
$y = fpdf::GetY();
fpdf::Image("napza.png", $x + 160, $y, 20, 20, "png");

$ynote = Fpdf::GetY();
Fpdf::SetY($ynote + 10);
Fpdf::SetFont('Arial', 'I', 8);
Fpdf::Cell(170, 4, 'Catatan :', 0, 1, 'L');
Fpdf::Cell(170, 4, 'Surat keterangan ini hanya berlaku untuk sampel urin yang diuji tersebut diatas.', 0, 1, 'L');

//LHU PAGE
Fpdf::AddPage();
Fpdf::SetMargins(10, 38, 15);
Fpdf::SetFont('Arial', 'B', 12);
Fpdf::SetXY(10, 42);
Fpdf::Cell(190, 5, 'HASIL LABORATORIUM', 0, 1, 'C');

//PATIENT DATA
fpdf::SetXY(10, 47);
fpdf::SetFont('Arial', '', 10);
fpdf::Cell(30, 6, 'No. Laboratorium', 'TL', 0, 'L');
fpdf::Cell(5, 6, ':', 'T', 0, 'C');
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(155, 6, $regnapza->letter_napza_lhu, 'TR', 1, 'L');
fpdf::SetFont('Arial', '', 9);
fpdf::Cell(30, 6, 'Rekam Medis', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(75, 6, $patient->patient_mr . ' / ' . $patient->patient_ihs, 0, 0, 'L');
fpdf::Cell(20, 6, 'Dokter', 0, 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(55, 6, $regnapza->visit_doctor_name, 'R', 1, 'L');
fpdf::Cell(30, 6, 'Nama Pasien', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(75, 6, $patient->patient_name . ' (' . $gendertitle . ')', 0, 0, 'L');
fpdf::Cell(20, 6, 'Pengirim', 0, 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(55, 6, $regnapza->visit_patient_dept, 'R', 1, 'L');
fpdf::Cell(30, 6, 'Tanggal Lahir', 'L', 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(75, 6, $bitrhdate, 0, 0, 'L');
fpdf::Cell(20, 6, 'Registrasi', 0, 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'C');
fpdf::Cell(55, 6, $regnapza->visit_date_arrived, 'R', 1, 'L');
fpdf::Cell(30, 6, 'Status Pasien', 'LB', 0, 'L');
fpdf::Cell(5, 6, ':', 'B', 0, 'C');
fpdf::Cell(75, 6, $regnapza->visit_patient_status, 'B', 0, 'L');
fpdf::Cell(20, 6, 'Catatan', 'B', 0, 'L');
fpdf::Cell(5, 6, ':', 'B', 0, 'C');
fpdf::Cell(55, 6, 'MCU', 'BR', 1, 'L');
//HEADER TABLE
fpdf::SetY(80);
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(80, 6, 'Parameter', 'TB', 0, 'C');
fpdf::Cell(40, 6, 'Hasil', 'TB', 0, 'C');
fpdf::Cell(70, 6, 'Metode', 'TB', 1, 'C');
//SERVICE DETAILS
$no = 0;
foreach ($results as $data) {
    $no++;
    Fpdf::SetX(10);
    fpdf::SetFont('Arial', '', 10);
    Fpdf::Cell(80, 6, $data->service_name, 0, 0, 'L');
    Fpdf::Cell(40, 6, $data->service_result, 0, 0, 'C');
    fpdf::SetFont('Arial', 'I', 10);
    Fpdf::Cell(70, 6, 'Rapid Diagnostic Test', 0, 1, 'C');
}

//IMPRESSION
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(190, 6, 'Expertise :', 'T', 1, 'L');
fpdf::SetFont('Arial', '', 8);
fpdf::setFillColor(255, 255, 255);
fpdf::MultiCellNoFill(190, 4, $regnapza->visit_validation_impression, 0, 1, 'J');
// fpdf::Cell(190, 6, '', 'T', 1, 'L');

// NOTES
$collected = date('d-m-Y H:i:s', strtotime($regnapza->visit_time_sampling));
$received = date('d-m-Y H:i:s', strtotime($regnapza->visit_time_receive));
$validated = date('d-m-Y H:i:s', strtotime($regnapza->visit_time_validation));
$reporting = date('d-m-Y', strtotime($regnapza->visit_time_validation));
$collector = $regnapza->visit_sampling_by;
$receiver = $regnapza->visit_receive_by;
$validator = $regnapza->visit_validation_by;
fpdf::Cell(190, 2, '', 'B', 1, 'L');
fpdf::SetFont('Arial', 'I', 8);
fpdf::Cell(30, 4, '# Pengambilan Sampel', 0, 0, 'L');
fpdf::Cell(5, 4, ':', 0, 0, 'L');
fpdf::Cell(30, 4, $collected, 0, 0, 'L');
fpdf::Cell(60, 4, '| ' . $collector, 0, 1, 'L');
fpdf::Cell(30, 4, '# Penerimaan Sampel', 0, 0, 'L');
fpdf::Cell(5, 4, ':', 0, 0, 'L');
fpdf::Cell(30, 4, $received, 0, 0, 'L');
fpdf::Cell(60, 4, '| ' . $receiver, 0, 1, 'L');
fpdf::Cell(30, 4, '# Validasi Hasil', 0, 0, 'L');
fpdf::Cell(5, 4, ':', 0, 0, 'L');
fpdf::Cell(30, 4, $validated, 0, 0, 'L');
fpdf::Cell(60, 4, '| ' . $validator, 0, 1, 'L');
fpdf::Cell(190, 4, '', 0, 1, 'L');
// IMAGE
$encode = $regnapza->visit_encoded;
$public = url('/verify/labreport/');
$qrlink = $public . "/" . $encode;
QRcode::png($qrlink, "qr.png");
$x = fpdf::GetX();
$y = fpdf::GetY();
fpdf::Image("qr.png", $x, $y - 5, 23, 23, "png");
fpdf::setX(35);
fpdf::Cell(155, 4, 'Hasil berupa angka menggunakan sistem desimal dengan separator titik.', 0, 1, 'L');
fpdf::setX(35);
fpdf::Cell(155, 4, 'Tanda H untuk hasil diatas nilai normal, tanda L untuk hasil dibawah nilai normal, dan * untuk hasil membutuhkan perhatian.', 0, 1, 'L');
fpdf::setX(35);
fpdf::Cell(155, 4, 'Interpretasi hasil hanya dilakukan oleh dokter / klinisi.', 0, 1, 'L');
fpdf::setX(35);
fpdf::Cell(155, 4, 'Demi menjaga kerahasiaan data Anda, harap tidak mengunggah pada media sosial publik.', 0, 1, 'L');


//Cek apakah sisa halaman > 280
if (Fpdf::GetY() > 280) {
    Fpdf::AddPage();
}
$yttd = Fpdf::GetY();
Fpdf::Image('template/stamp.png', 110, $yttd + 5, -190);
Fpdf::Image('template/ttd_kasie.png', 130, $yttd + 15, -140);
Fpdf::Image('template/ttd_clinic.png', 40, $yttd + 25, -240);
Fpdf::SetY($yttd + 3);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(190, 6, 'Palangka Raya, ' . date('d - m - Y', strtotime($reporting)), 0, 1, 'R');
Fpdf::SetY($yttd + 12);
Fpdf::Cell(95, 6, 'Penanggungjawab Teknis', 0, 0, 'C');
Fpdf::Cell(95, 6, 'Kepala Seksi', 0, 1, 'C');
Fpdf::Cell(95, 6, 'Laboratorium Klinik', 0, 0, 'C');
Fpdf::Cell(95, 6, 'Laboratorium Kesehatan Masyarakat dan Klinik', 0, 1, 'C');
Fpdf::Cell(95, 20, '', 0, 0, 'C');
Fpdf::Cell(95, 20, '', 0, 1, 'C');
Fpdf::Cell(95, 5, 'dr. LESTARI, Sp.PK', 0, 0, 'C');
Fpdf::Cell(95, 5, 'AGUS, S.Si., M.MKes., M. Si', 0, 1, 'C');
Fpdf::Cell(95, 5, 'NIP. 19810514 200904 2 003', 0, 0, 'C');
Fpdf::Cell(95, 5, 'NIP. 19700801 199803 1 009', 0, 1, 'C');
// TOTAL PAGE
fpdf::AliasNbPages();
Fpdf::Output('SK NAPZA - ' . $patient->patient_name . ' - ' . $regnapza->letter_napza_lhu . '.pdf', 'I');
exit();
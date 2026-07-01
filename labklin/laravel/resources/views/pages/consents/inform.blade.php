<?php
// Hitung Umur
$age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align

Fpdf::SetMargins(20, 38, 15);
Fpdf::AddPage();
Fpdf::SetTitle('Inform Consent - ' . $patient->patient_name);
Fpdf::SetFont('Arial', 'IB', 12);
// Fpdf::SetXY(10, 42);
Fpdf::Cell(170, 5, 'INFORM CONSENT', 0, 1, 'C');
Fpdf::Cell(170, 5, 'TINDAKAN FLEBOTOMI', 0, 1, 'C');
//PATIENT DATA
Fpdf::SetFont('Arial', '', 11);
Fpdf::SetXY(20, 55);
Fpdf::Cell(170, 6, 'Saya yang bertandatangan dibawah ini :', 0, 1, 'L');
Fpdf::Cell(50, 6, 'Nama', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::SetFont('Arial', 'B', 11);
Fpdf::Cell(117, 6, $patient->patient_name, 0, 1, 'L');
Fpdf::SetFont('Arial', '', 11);
Fpdf::Cell(50, 6, 'NIK', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $patient->patient_nik, 0, 1, 'L');
Fpdf::Cell(50, 6, 'Tanggal Lahir', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, date('d-m-Y', strtotime($patient->patient_birthdate)) . ' (' . $age . ' Tahun )', 0, 1, 'L');
Fpdf::Cell(50, 6, 'Alamat', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $patient->patient_address_line . ' - ' . $patient->patient_address_city, 0, 1, 'L');
Fpdf::Cell(50, 6, 'No. Kontak', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $patient->patient_telecom, 0, 1, 'L');
$text = 'Dengan ini menyatakan bahwa saya telah mendapatkan penjelasan yang cukup, jelas, dan dapat saya pahami mengenai prosedur pengambilan darah yang akan dilakukan oleh tenaga medis di Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.';
Fpdf::Justify($text, 170, 6);
Fpdf::Cell(170, 6, 'Saya memahami bahwa :', 0, 1, 'L');
Fpdf::Cell(10, 6, '1.', 0, 0, 'L');
Fpdf::SetMargins(30, 38, 15);
$text = 'Pengambilan darah dilakukan untuk keperluan pemeriksaan medis dan akan diambil oleh tenaga medis yang berkompeten.';
Fpdf::Justify($text, 160, 6);
Fpdf::SetX(20);
Fpdf::Cell(10, 6, '2.', 0, 0, 'L');
$text = 'Proses pengambilan darah dapat menyebabkan rasa tidak nyaman, nyeri ringan, atau risiko lain seperti lebam, infeksi, atau reaksi lain yang jarang terjadi.';
Fpdf::Justify($text, 160, 6);
Fpdf::SetX(20);
Fpdf::Cell(10, 6, '3.', 0, 0, 'L');
$text = 'Saya berhak untuk bertanya dan mendapatkan penjelasan lebih lanjut terkait prosedur ini sebelum memberikan persetujuan.';
Fpdf::Justify($text, 160, 6);
Fpdf::SetX(20);
Fpdf::Cell(10, 6, '4.', 0, 0, 'L');
$text = 'Saya berhak untuk menolak atau membatalkan persetujuan ini kapan saja sebelum prosedur dilakukan tanpa adanya tekanan.';
Fpdf::Justify($text, 160, 6);
Fpdf::SetX(20);
Fpdf::Cell(10, 6, '5.', 0, 0, 'L');
$text = 'Informasi pribadi dan hasil pemeriksaan saya akan dijaga kerahasiaannya sesuai dengan ketentuan perundang-undangan yang berlaku.';
Fpdf::Justify($text, 160, 6);
Fpdf::SetX(20);
Fpdf::Cell(10, 6, '6.', 0, 0, 'L');
$text = 'Persetujuan ini berlaku untuk seterusnya hingga saya mencabutnya secara tertulis.';
Fpdf::Justify($text, 160, 6);
Fpdf::SetMargins(20, 38, 15);
Fpdf::SetX(20);
$text = 'Dengan ini, saya memberikan izin untuk dilakukan pengambilan darah sesuai dengan prosedur medis yang berlaku di Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.';
Fpdf::Justify($text, 170, 6);
Fpdf::SetX(20);
$text = 'Demikian pernyataan ini saya buat dengan penuh kesadaran dan tanpa adanya paksaan dari pihak mana pun.';
Fpdf::Justify($text, 170, 6);
//TANDA TANGAN
$yttd = Fpdf::GetY();
Fpdf::SetY($yttd + 3);
Fpdf::SetFont('Arial', '', 11);
Fpdf::Cell(100, 6, '', 0, 0, 'L');
Fpdf::Cell(70, 6, 'Palangka Raya,                    ', 0, 1, 'L');
Fpdf::Cell(85, 6, 'Petugas,', 'LTR', 0, 'C');
Fpdf::Cell(85, 6, 'Pasien / Wali', 'LTR', 1, 'C');
Fpdf::Cell(85, 20, '', 'LR', 0, 'C');
Fpdf::Cell(85, 20, '', 'LR', 1, 'C');
Fpdf::Cell(85, 6, '(                                            )', 'LBR', 0, 'C');
Fpdf::Cell(85, 6, '(                                            )', 'LBR', 1, 'C');
Fpdf::SetFont('Arial', '', 8);
Fpdf::Cell(170, 20, 'ID FHIR : ' . $consent->consent_uuid, 0, 0, 'L');
// TOTAL PAGE
fpdf::AliasNbPages();
Fpdf::Output('Inform Consent - ' . $patient->patient_name . '.pdf', 'I');
exit();
<?php
//QRCode Library
require_once ("phpqrcode/qrlib.php");
// Hitung Umur
// $age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
Fpdf::AddPageBlank('P', 'a4', 0); //Orientation, Paper Size, Rotation

// Fpdf::headerVisible(false);
// $headerVisible="false";


// Output

// fpdf::AliasNbPagesBlank('');
Fpdf::AliasNbPages();
// Fpdf::Footer();
Fpdf::Output('Lab Report.pdf', 'I');
exit();

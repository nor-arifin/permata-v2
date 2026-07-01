<?php
//QRCode Library
// require_once ("phpqrcode/qrlib.php");
// Hitung Umur
$age = \Carbon\Carbon::parse($label[0]->patient_birthdate)->age;
Fpdf::SetTitle('Label - ' . $label[0]->visit_registration_id);
Fpdf::SetMargins(10, 5, 1);
Fpdf::SetAutoPageBreak(true, 1);

foreach ($label as $data) {
    if ($data->patient_gender == 'male') {
        $gender = 'M';
    } elseif ($data->patient_gender == 'female') {
        $gender = 'F';
    }
    $container = $data->test_container;
    $date = date('d-m-Y', strtotime($data->visit_date));
    $datebirth = date('d-m-Y', strtotime($data->patient_birthdate));
    Fpdf::AddPageBlank('P', 'label50x20', 0); //Orientation, Paper Size, Rotation
    Fpdf::SetFont('Arial', 'B', 30);
    Fpdf::Cell(160, 12, $data->visit_patient_name, 0, 1, 'L');
    Fpdf::SetFont('Arial', '', 20);
    Fpdf::Cell(160, 8, 'MR No : ' . $data->patient_mr . ' / ' . $datebirth . ' / ' . $age . ' Y' . ' (' . $gender . ')', 0, 1, 'L');
    Fpdf::Cell(30, 27, '', 0, 0, 'L');
    Fpdf::Cell(125, 27, '', 0, 0, 'L');
    Fpdf::Cell(30, 27, '', 0, 1, 'L');
    Fpdf::SetFont('Courier', 'B', 15);
    Fpdf::Cell(160, 4, $data->visit_registration_id, 0, 1, 'C');
    Fpdf::SetFont('Arial', '', 20);
    Fpdf::Cell(35, 12, $data->test_container, 0, 0, 'L');
    Fpdf::Cell(120, 12, $date, 0, 1, 'R');

    //BARCODE
    $code = $data->visit_registration_id;
    Fpdf::Code128(25, 27, $code, 120, 23);
}
// Fpdf::AliasNbPages();
Fpdf::Output('Label - ' . $label[0]->visit_registration_id . ' - ' . $label[0]->visit_patient_name . '.pdf', 'I');
exit();
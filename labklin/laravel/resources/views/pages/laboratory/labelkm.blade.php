<?php
//QRCode Library
// require_once ("phpqrcode/qrlib.php");
// Hitung Umur
Fpdf::SetTitle('Label - ' . $label[0]->fpps);
Fpdf::SetMargins(10, 5, 1);
Fpdf::SetAutoPageBreak(true, 1);

foreach ($label as $data) {

    $sample_types = [
        'AH' => 'Air Higiene dan Sanitasi',
        'AK' => 'Air Kolam Renang',
        'AT' => 'Air Laut',
        'AL' => 'Air Limbah',
        'AM' => 'Air Minum',
        'AU' => 'Air Pemandian Umum',
        'AP' => 'Air SPA',
        'AS' => 'Air Sungai/Danau',
        'LN' => 'Linen',
        'MS' => 'Alat Masak',
        'MM' => 'Makanan Minuman',
        'US' => 'Usap Swab',
        'MT' => 'Media Tanah',
        'KU' => 'Kualitas Udara',
        'OL' => 'Lainnya'
    ];
    $sample_type = $sample_types[$data->sample_type] ?? 'Unknown';

    $date = date('d-m-Y', strtotime($data->date));
    Fpdf::AddPageBlank('P', 'label50x20', 0); //Orientation, Paper Size, Rotation
    Fpdf::SetFont('Arial', 'B', 30);
    // Fpdf::MultiCellNoFill(160, 12, $data->name, 0, 'L');
    Fpdf::Cell(160, 12, $data->code, 0, 1, 'L');
    Fpdf::SetFont('Arial', '', 25);
    Fpdf::Cell(160, 8, $data->fpps, 0, 1, 'L');
    Fpdf::SetFont('Courier', 'B', 45);
    Fpdf::Cell(160, 20, $data->sample_code, 0, 1, 'C');
    Fpdf::SetFont('Arial', '', 25);
    Fpdf::Cell(35, 12, $data->volume . ' ' . $data->container, 0, 0, 'L');
    Fpdf::Cell(120, 12, $sample_type, 0, 1, 'R');
    Fpdf::SetFont('Arial', '', 25);
    Fpdf::Cell(35, 12, $data->date, 0, 0, 'L');
    Fpdf::Cell(120, 12, $data->desc, 0, 1, 'R');
}
// Fpdf::AliasNbPages();
Fpdf::Output('Label - ' . $label[0]->fpps . ' - ' . $label[0]->name . '.pdf', 'I');
exit();
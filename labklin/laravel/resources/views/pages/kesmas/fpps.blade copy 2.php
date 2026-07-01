<?php
// use Codedge\Fpdf\Fpdf\Fpdf;
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align

Fpdf::SetMargins(10, 38, 10);
Fpdf::SetAutoPageBreak(true, 30);
Fpdf::AddPage();
Fpdf::SetTitle('FPPS - ' . $kesmas->order_code);
Fpdf::SetFont('Arial', 'B', 12);
Fpdf::SetXY(10, 38);
Fpdf::Cell(190, 5, 'FORMULIR PERMINTAAN PENGUJIAN SAMPEL (FPPS)', 0, 1, 'C');
Fpdf::SetFont('Arial', '', 11);
Fpdf::Cell(190, 5, 'No. ' . $kesmas->order_code, 0, 1, 'C');
//Customer Data
Fpdf::SetXY(10, 50);
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Kode Pelanggan', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Customer code', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Nama Pelanggan', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Customer name', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Alamat', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Address', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Kontak Penghubung', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Contact person', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Telp / Fax / Email', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Phone / Fax / Email', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Pengambil Sampel', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Sampling by', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Tanggal Pengambilan Sampel', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Date of sampling', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Tanggal Penerimaan Sampel', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Date of receive', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Jenis Sampel', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Sample type', 'BLR', 1, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(50, 4, 'Jumlah Sampel', 'TLR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(50, 4, 'Number of sample', 'BLR', 1, 'L');

Fpdf::SetXY(60, 50);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');
Fpdf::SetX(60);
Fpdf::Cell(3, 8, ':', 1, 1, 'L');

Fpdf::SetXY(63, 50);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(137, 8, $customers->customer_code, 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::Cell(137, 8, $customers->customer_name, 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::Cell(137, 8, $customers->customer_address, 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::Cell(137, 8, $customers->customer_pic . ' / ' . $customers->customer_pic_phone, 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::Cell(137, 8, $customers->customer_phone . ' / ' . $customers->customer_email, 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::SetFont('Arial', 'U', 10); // ✔ (Tanda centang)
Fpdf::Cell(5, 4, '', 'LTR', 0, 'L');
Fpdf::Cell(60, 4, 'Pelanggan', 'TLR', 0, 'L');
Fpdf::Cell(5, 4, '', 'LTR', 0, 'L');
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(67, 4, 'Laboratorium', 'TLR', 1, 'L');
Fpdf::SetX(63);
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(5, 4, '', 'LBR', 0, 'L');
Fpdf::Cell(60, 4, 'Customer', 'BLR', 0, 'L');
Fpdf::Cell(5, 4, '', 'LBR', 0, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(67, 4, 'Laboratory', 'LBR', 1, 'L');
Fpdf::SetFont('Arial', '', 10);
Fpdf::SetX(63);
Fpdf::Cell(137, 8, date('d F Y H:i', strtotime($kesmas->order_collec)), 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::Cell(137, 8, date('d F Y H:i', strtotime($kesmas->order_receive)), 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::Cell(137, 8, $kesmas->order_type, 1, 1, 'L');
Fpdf::SetX(63);
Fpdf::Cell(137, 8, $kesmas->order_num_sample . ' Sampel', 1, 1, 'L');
$y0 = Fpdf::GetY();

Fpdf::SetFont('ZapfDingbats', '', 14);
if ($kesmas->order_collector === 'customer') {
    Fpdf::SetXY(63, 90);
    Fpdf::Cell(40, 10, chr(51)); // ✔ (Tanda centang)
    Fpdf::SetXY(128, 90);
    Fpdf::Cell(40, 10, chr(114)); // ❑ (Kotak kosong)
} else {
    Fpdf::SetXY(63, 90);
    Fpdf::Cell(40, 10, chr(114)); // ❑ (Kotak kosong)
    Fpdf::SetXY(128, 90);
    Fpdf::Cell(40, 10, chr(51)); // ✔ (Tanda centang)

}

Fpdf::SetFont('Arial', 'BU', 10);
Fpdf::SetY($y0 + 3);
Fpdf::Cell(190, 4, 'Parameter Pengujian', 0, 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(190, 4, 'Test Parameters', 0, 1, 'L');
//HEADER TABLE
Fpdf::SetY(143);
Fpdf::SetFont('Arial', 'B', 10);
Fpdf::Cell(10, 6, 'No.', 'TBL', 0, 'C');
Fpdf::Cell(25, 6, 'Kode Pelanggan', 'TB', 0, 'C');
Fpdf::Cell(40, 6, 'No. Laboratorium', 'TB', 0, 'C');
Fpdf::Cell(55, 6, 'Sampel', 'TB', 0, 'C');
Fpdf::Cell(60, 6, 'Parameter', 'TBR', 1, 'C');
//SAMPLE AND PARAMETER LOOP
$no = 0;
foreach ($samples as $sample) {
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
    $sample_type = $sample_types[$sample->sample_type] ?? 'Unknown';

    $no++;
    Fpdf::SetFont('Arial', 'B', 10);
    Fpdf::Cell(10, 6, $no, 'LT', 0, 'C');
    Fpdf::Cell(25, 6, $sample->sample_id, 'T', 0, 'L');
    Fpdf::Cell(40, 6, $sample->sample_code, 'T', 0, 'C');
    Fpdf::Cell(115, 6, $sample_type . ' dalam ' . $sample->sample_volume . ' ' . $sample->sample_container, 'TR', 1, 'L');
    Fpdf::SetFont('Arial', '', 10);
    $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->where('order_sample_id', $sample->id)->get();
    foreach ($parameters as $parameter) {
        Fpdf::Cell(125, 6, '', 'L', 0, 'C');
        Fpdf::SetFont('ZapfDingbats', '', 10);
        Fpdf::Cell(5, 6, chr(51), 0, 0, 'C');
        Fpdf::SetFont('Arial', '', 10);
        Fpdf::Cell(60, 6, $parameter->order_parameter_name, 'R', 1, 'L');
    }
}
Fpdf::Cell(190, 6, '', 'T', 1, 'C');
//Cek apakah sisa halaman > 250
if (Fpdf::GetY() > 280) {
    Fpdf::AddPage();
}
$y1 = Fpdf::GetY();
Fpdf::SetXY(10, $y1);
Fpdf::SetFont('Arial', 'U', 10);
Fpdf::Cell(190, 4, 'Kondisi abnormalitas atau penyimpangan dari sampel:', 'LTR', 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(190, 4, 'Conditions of abnormality or deviation from the sample:', 'LBR', 1, 'L');
Fpdf::SetFont('ZapfDingbats', '', 11);
if ($review->abnormality_expired == 'off') {
    Fpdf::Cell(5, 6, chr(114), 'L', 0, 'C');
} else {
    Fpdf::Cell(5, 6, chr(51), 'L', 0, 'C');
}
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(50, 6, 'Kadaluarsa', 0, 0, 'L');
Fpdf::SetFont('ZapfDingbats', '', 11);
if ($review->abnormality_outlab == 'off') {
    Fpdf::Cell(5, 6, chr(114), 0, 0, 'C');
} else {
    Fpdf::Cell(5, 6, chr(51), 0, 0, 'C');
}
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(130, 6, 'Parameter lapangan diukur di laboratorium', 'R', 1, 'L');
Fpdf::SetFont('ZapfDingbats', '', 11);
if ($review->abnormality_preservatives == 'off') {
    Fpdf::Cell(5, 6, chr(114), 'L', 0, 'C');
} else {
    Fpdf::Cell(5, 6, chr(51), 'L', 0, 'C');
}
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(50, 6, 'Tanpa pengawet', 0, 0, 'L');
Fpdf::SetFont('ZapfDingbats', '', 11);
if ($review->abnormality_outpreservatives == 'off') {
    Fpdf::Cell(5, 6, chr(114), 0, 0, 'C');
} else {
    Fpdf::Cell(5, 6, chr(51), 0, 0, 'C');
}
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(130, 6, 'Pengawet tidak sesuai', 'R', 1, 'L');
Fpdf::SetFont('ZapfDingbats', '', 11);
if ($review->abnormality_other == 'off') {
    Fpdf::Cell(5, 6, chr(114), 'LB', 0, 'C');
} else {
    Fpdf::Cell(5, 6, chr(51), 'LB', 0, 'C');
}
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(20, 6, 'Lainnya :', 'B', 0, 'L');
Fpdf::SetFont('Arial', 'I', 10);
if ($review->abnormality_other == 'off') {
    Fpdf::Cell(165, 6, '', 'BR', 1, 'L');
} else {
    Fpdf::Cell(165, 6, $review->abnormality_other, 'BR', 1, 'L');
}

$y2 = Fpdf::GetY();
Fpdf::SetY($y2 + 3);
//ADDITIONAL
if ($additional != null) {
    Fpdf::SetFont('Arial', 'BU', 10);
    Fpdf::Cell(190, 4, 'Tambahan', 0, 1, 'L');
    Fpdf::SetFont('Arial', 'I', 10);
    Fpdf::Cell(190, 4, 'Additional', 0, 1, 'L');
    Fpdf::SetFont('Arial', '', 10);
    Fpdf::Cell(190, 6, $additional->add_order_task, 0, 1, 'L');
    // SUM PRICE
    $total = $additional->add_order_charge;
    foreach ($samples as $sample) {
        $total += $sample->sample_charge;
    }
} else {
    $total = 0;
    foreach ($samples as $sample) {
        $total += $sample->sample_charge;
    }
}
//Cek apakah sisa halaman > 250
if (Fpdf::GetY() > 280) {
    Fpdf::AddPage();
}
//SAMPLES
Fpdf::SetFont('Arial', 'BU', 10);
Fpdf::Cell(190, 4, 'Deskripsi Sampel', 0, 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(190, 4, 'Sample Description', 0, 1, 'L');
$ysamples = Fpdf::GetY();
Fpdf::SetY($ysamples + 3);
Fpdf::SetFont('Arial', 'B', 10);
Fpdf::Cell(10, 6, 'No', 1, 0, 'C');
Fpdf::Cell(45, 6, 'Kode Pelanggan', 1, 0, 'C');
Fpdf::Cell(40, 6, 'No. Laboratorium', 1, 0, 'C');
Fpdf::Cell(30, 6, 'Volume', 1, 0, 'C');
Fpdf::Cell(65, 6, 'Note', 1, 1, 'C');

$no = 0;
foreach ($samples as $sample) {
    $no++;
    Fpdf::SetFont('Arial', '', 10);
    Fpdf::Cell(10, 6, $no, 1, 0, 'C');
    Fpdf::Cell(45, 6, $sample->sample_id, 1, 0, 'C');
    Fpdf::Cell(40, 6, $sample->sample_code, 1, 0, 'C');
    Fpdf::Cell(30, 6, $sample->sample_volume, 1, 0, 'C');
    Fpdf::Cell(65, 6, $sample->sample_note, 1, 1, 'C');
}

//Cek apakah sisa halaman > 280
if (Fpdf::GetY() > 270) {
    Fpdf::AddPage();
}
$y3 = Fpdf::GetY();
Fpdf::SetY($y3 + 3);
Fpdf::SetFont('Arial', 'BU', 10);
Fpdf::Cell(190, 4, 'Kaji Ulang Permintaan', 0, 1, 'L');
Fpdf::SetFont('Arial', 'I', 10);
Fpdf::Cell(190, 4, 'Review order', 0, 1, 'L');

//REVIEW
$personnel = $review->review_personnel == 'on' ? 'Mampu' : 'Tidak Mampu';
$accomodation = $review->review_accomodation == 'on' ? 'Baik' : 'Tidak Baik';
$workload = $review->review_workload == 'on' ? 'Tidak Overload' : 'Overload';
$equipment = $review->review_equipment == 'on' ? 'Tidak Rusak' : 'Rusak';
$method = $review->review_method == 'on' ? 'Sesuai' : 'Tidak Sesuai';
$conclution = $review->review_conclution == 'Accept' ? 'Dapat dilayani' : 'Tidak dapat dilayani';

$yreview = Fpdf::GetY();
Fpdf::SetXY(10, $yreview + 3);
Fpdf::SetFont('Arial', 'B', 10);
Fpdf::Cell(8, 6, 'No', 1, 0, 'C');
Fpdf::Cell(50, 6, 'Unsur Kaji Ulang', 1, 0, 'C');
Fpdf::Cell(42, 6, 'Hasil', 1, 1, 'C');
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(8, 6, '1', 1, 0, 'C');
Fpdf::Cell(50, 6, 'Kemampuan Personel', 1, 0, 'L');
Fpdf::Cell(42, 6, $personnel, 1, 1, 'L');
Fpdf::Cell(8, 6, '2', 1, 0, 'C');
Fpdf::Cell(50, 6, 'Kondisi Akomodasi', 1, 0, 'L');
Fpdf::Cell(42, 6, $accomodation, 1, 1, 'L');
Fpdf::Cell(8, 6, '3', 1, 0, 'C');
Fpdf::Cell(50, 6, 'Beban Kerja Laboratorium', 1, 0, 'L');
Fpdf::Cell(42, 6, $workload, 1, 1, 'L');
Fpdf::Cell(8, 6, '4', 1, 0, 'C');
Fpdf::Cell(50, 6, 'Kondisi Peralatan', 1, 0, 'L');
Fpdf::Cell(42, 6, $equipment, 1, 1, 'L');
Fpdf::Cell(8, 6, '5', 1, 0, 'C');
Fpdf::Cell(50, 6, 'Kesesuaian Metode', 1, 0, 'L');
Fpdf::Cell(42, 6, $method, 1, 1, 'L');
Fpdf::SetFont('Arial', 'B', 10);
Fpdf::Cell(58, 6, 'Kesimpulan', 1, 0, 'L');
Fpdf::Cell(42, 6, $conclution, 1, 1, 'L');
Fpdf::SetFont('Arial', 'I', 8);
Fpdf::SetX(10);
Fpdf::Cell(100, 8, 'Reviewed by : ' . $review->reviewer . ' at ' . $review->created_at, 1, 1, 'L');
//Cek apakah sisa halaman > 280
if (Fpdf::GetY() > 280) {
    Fpdf::AddPage();
}
$yttd = Fpdf::GetY();
Fpdf::SetY($yttd + 3);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(190, 6, 'Palangka Raya, ' . date('d F Y', strtotime($kesmas->order_date)), 0, 1, 'R');
Fpdf::Cell(95, 6, 'Diberikan Oleh,', 'LTR', 0, 'C');
Fpdf::Cell(95, 6, 'Diterima Oleh,', 'LTR', 1, 'C');
Fpdf::Cell(95, 20, '', 'LR', 0, 'C');
Fpdf::Cell(95, 20, '', 'LR', 1, 'C');
Fpdf::Cell(95, 6, '(                                            )', 'LBR', 0, 'C');
Fpdf::Cell(95, 6, '(                                            )', 'LBR', 1, 'C');

// TOTAL PAGE
Fpdf::AliasNbPages();
Fpdf::Output('FPPS.pdf', 'I');
exit();
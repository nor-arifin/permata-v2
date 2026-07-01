<?php
function indonesianDate($date)
{
    $months = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];
    $formattedDate = date('d F Y', strtotime($date));
    return strtr($formattedDate, $months);
}
function Terbilang($satuan)
{
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    if ($satuan < 12)
        return " " . $huruf[$satuan];
    elseif ($satuan < 20)
        return Terbilang($satuan - 10) . " Belas";
    elseif ($satuan < 100)
        return Terbilang($satuan / 10) . " Puluh" . Terbilang($satuan % 10);
    elseif ($satuan < 200)
        return " Seratus" . Terbilang($satuan - 100);
    elseif ($satuan < 1000)
        return Terbilang($satuan / 100) . " Ratus" . Terbilang($satuan % 100);
    elseif ($satuan < 2000)
        return " Seribu" . Terbilang($satuan - 1000);
    elseif ($satuan < 1000000)
        return Terbilang($satuan / 1000) . " Ribu" . Terbilang($satuan % 1000);
    elseif ($satuan < 1000000000)
        return Terbilang($satuan / 1000000) . " Juta" . Terbilang($satuan % 1000000);
    elseif ($satuan <= 1000000000)
        echo "Maaf Tidak Dapat di Proses Karena Jumlah Uang Terlalu Besar ";
}

//HEAD
Fpdf::SetMargins(20, 38, 15);
Fpdf::AddPage();
Fpdf::SetTitle('PKS - ' . $kesmas->order_code);

//TITLE
Fpdf::SetFont('Arial', 'BU', 12);
Fpdf::SetXY(20, 42);
Fpdf::Cell(170, 5, 'SURAT PERNYATAAN PIUTANG', 0, 1, 'C');
Fpdf::SetFont('Arial', '', 11);
Fpdf::Cell(170, 5, 'No.' . $payment->payment_mou_number, 0, 1, 'C');

//CONTENT
Fpdf::SetXY(20, 60);
Fpdf::Cell(170, 6, 'Saya yang bertandatangan dibawah ini :', 0, 1, 'L');
Fpdf::Cell(170, 6, '', 0, 1, 'L');
Fpdf::Cell(50, 6, 'Nama', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $customers->customer_pic, 0, 1, 'L');
Fpdf::Cell(50, 6, 'NIK', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $customers->customer_pic_nik, 0, 1, 'L');
Fpdf::Cell(50, 6, 'Instansi / Perusahaan', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $customers->customer_name, 0, 1, 'L');
Fpdf::Cell(50, 6, 'Alamat Kantor', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $customers->customer_address, 0, 1, 'L');
Fpdf::Cell(50, 6, 'No. Kontak', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $customers->customer_pic_phone . ' / ' . $customers->customer_phone, 0, 1, 'L');
Fpdf::Cell(170, 6, '', 0, 1, 'L');
$text = 'Sebagai penanggungjawab atas piutang permintaan pengujian sampel pada UPT Laboratorium Kesehatan dan Kalibrasi Kalimantan Tengah dengan rincian sebagai berikut.';
Fpdf::Justify($text, 170, 6);
Fpdf::Cell(170, 6, '', 0, 1, 'L');
Fpdf::Cell(50, 6, 'Nomor FPPS', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $kesmas->order_code, 0, 1, 'L');
Fpdf::Cell(50, 6, 'Tanggal', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, indonesianDate(date('d F Y', strtotime($kesmas->order_date))), 0, 1, 'L');
Fpdf::Cell(50, 6, 'Bidang Pengujian', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, ucfirst($kesmas->order_type), 0, 1, 'L');
Fpdf::Cell(50, 6, 'Jumlah Sampel', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, $kesmas->order_num_sample . ' Sampel', 0, 1, 'L');
Fpdf::Cell(50, 6, 'Total Tagihan', 0, 0, 'L');
Fpdf::Cell(3, 6, ':', 0, 0, 'L');
Fpdf::Cell(117, 6, 'Rp. ' . number_format($kesmas->order_total, 0, ',', '.') . ',-', 0, 1, 'L');
Fpdf::Cell(170, 6, '', 0, 1, 'L');
Fpdf::MultiCellNoFill(170, 6, 'Menyatakan bahwa saya memiliki utang kepada UPT Laboratorium Kesehatan dan Kalibrasi Kalimantan Tengah sebesar Rp. ' . number_format($kesmas->order_total, 0, ',', '.') . ' (' . Terbilang($kesmas->order_total) . ' Rupiah ). Saya bersedia dan sanggup untuk melunasi utang tersebut sebelum tanggal ' . indonesianDate(date('d F Y', strtotime($payment->payment_mou_duedate))) . ' (dibayar sekaligus).', 0, 1, 'L');
// $text = 'Menyatakan bahwa saya memiliki utang kepada UPT Laboratorium Kesehatan dan Kalibrasi Kalimantan Tengah sebesar Rp. ' . number_format($kesmas->order_total, 0, ',', '.') . ' (' . Terbilang($kesmas->order_total) . ' Rupiah ). Saya bersedia dan sanggup untuk melunasi utang tersebut sebelum tanggal ' . date('d F Y', strtotime($payment->payment_mou_duedate)) . ' (dibayar sekaligus).';
// Fpdf::Justify($text, 170, 6);
Fpdf::Cell(170, 6, '', 0, 1, 'L');
$text = 'Demikian surat pernyataan ini saya buat dengan sebenar-benarnya dan dapat dipertanggung jawabkan atau dituntut secara hukum apabila tidak memenuhi kewajiban diatas.';
Fpdf::Justify($text, 170, 6);

$yttd = Fpdf::GetY();
Fpdf::SetY($yttd + 3);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(100, 6, '', 0, 0, 'C');
Fpdf::Cell(70, 6, 'Palangka Raya, ' . indonesianDate(date('d F Y', strtotime($kesmas->order_date))), 0, 1, 'C');
Fpdf::Cell(100, 6, '', 0, 0, 'C');
Fpdf::Cell(70, 6, 'Pembuat Pernyataan,', 0, 1, 'C');
Fpdf::Cell(110, 20, '', 0, 0, 'C');
Fpdf::SetFont('Arial', '', 6);
Fpdf::Cell(60, 20, 'Materai', 0, 1, 'L');
Fpdf::Cell(100, 6, '', 0, 0, 'C');
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(70, 6, $customers->customer_pic, 0, 1, 'C');
Fpdf::Cell(170, 6, 'Diketahui oleh', 0, 1, 'L');
$yttd = Fpdf::GetY();
Fpdf::Image('template/paraf_bendahara.png', 70, $yttd - 8, -200);
Fpdf::Image('template/ttd_kasie.png', 75, $yttd + 5, -400);
Fpdf::Cell(50, 10, 'Bendahara Penerimaan', 1, 0, 'L');
Fpdf::Cell(20, 10, '', 1, 1, 'C');
Fpdf::Cell(50, 10, 'Kasie. Labkesmas dan Klinik', 1, 0, 'L');
Fpdf::Cell(20, 10, '', 1, 1, 'C');

// KWITANSI
Fpdf::SetMargins(10, 38, 10);
Fpdf::AddPage();

Fpdf::SetFont('Arial', 'B', 12);
Fpdf::SetXY(10, 42);
Fpdf::Cell(190, 5, 'Tagihan Pembayaran', 0, 1, 'C');
//Customer Data
Fpdf::SetXY(10, 50);
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(30, 6, 'Customer Code', 'TL', 0, 'L');
Fpdf::Cell(5, 6, ':', 'T', 0, 'C');
Fpdf::SetFont('Arial', 'B', 10);
Fpdf::Cell(155, 6, $customers->customer_code, 'TR', 1, 'L');
Fpdf::SetFont('Arial', '', 10);
Fpdf::Cell(30, 6, 'Customer Name', 'L', 0, 'L');
Fpdf::Cell(5, 6, ':', 0, 0, 'C');
Fpdf::Cell(155, 6, $customers->customer_name . ' / ' . $customers->customer_type, 'R', 1, 'L');
Fpdf::Cell(30, 6, 'Address', 'L', 0, 'L');
Fpdf::Cell(5, 6, ':', 0, 0, 'C');
Fpdf::Cell(155, 6, $customers->customer_address . ' / ' . $customers->customer_address_detail, 'R', 1, 'L');
Fpdf::Cell(30, 6, 'Person In Charge', 'L', 0, 'L');
Fpdf::Cell(5, 6, ':', 0, 0, 'C');
Fpdf::Cell(155, 6, $customers->customer_pic . ' / ' . $customers->customer_pic_phone, 'R', 1, 'L');
Fpdf::Cell(30, 6, 'Contact / Email', 'LB', 0, 'L');
Fpdf::Cell(5, 6, ':', 'B', 0, 'C');
Fpdf::Cell(155, 6, $customers->customer_phone . ' / ' . $customers->customer_email, 'RB', 1, 'L');
//FPPS DETAILS
Fpdf::SetXY(10, 85);
Fpdf::Cell(30, 6, 'FPPS No.', 0, 0, 'L');
Fpdf::Cell(5, 6, ':', 0, 0, 'C');
Fpdf::Cell(155, 6, $kesmas->order_code, 0, 1, 'L');
Fpdf::Cell(30, 6, 'Date Order', 0, 0, 'L');
Fpdf::Cell(5, 6, ':', 0, 0, 'C');
Fpdf::Cell(155, 6, $kesmas->created_at, 0, 1, 'L');
//HEADER TABLE
fpdf::SetY(100);
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(10, 6, 'No.', 'TB', 0, 'C');
fpdf::Cell(25, 6, 'Sample ID', 'TB', 0, 'C');
fpdf::Cell(40, 6, 'Laboratory Code', 'TB', 0, 'C');
fpdf::Cell(55, 6, 'Sample Description', 'TB', 0, 'C');
fpdf::Cell(30, 6, 'Charge', 'TB', 0, 'C');
fpdf::Cell(30, 6, 'Sub Total', 'TB', 1, 'C');
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
    fpdf::SetFont('Arial', 'B', 10);
    fpdf::Cell(10, 6, $no, 'T', 0, 'C');
    fpdf::Cell(25, 6, $sample->sample_id, 'T', 0, 'L');
    fpdf::Cell(40, 6, $sample->sample_code, 'T', 0, 'C');
    fpdf::Cell(85, 6, $sample_type . ' in ' . $sample->sample_volume . ' ' . $sample->sample_container, 'T', 0, 'L');
    fpdf::SetFont('Arial', '', 10);
    fpdf::Cell(30, 6, 'Rp. ' . number_format($sample->sample_charge, 0, ',', '.') . ',-', 'T', 1, 'R');
    $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->where('order_sample_id', $sample->id)->get();
    foreach ($parameters as $parameter) {
        fpdf::Cell(75, 6, '', 0, 0, 'C');
        fpdf::Cell(5, 6, '-', 0, 0, 'C');
        fpdf::Cell(50, 6, $parameter->order_parameter_name, 0, 0, 'L');
        fpdf::Cell(30, 6, 'Rp. ' . number_format($parameter->order_parameter_price, 0, ',', '.') . ',-', 0, 1, 'R');
    }
}
//ADDITIONAL
if ($additional != null) {
    fpdf::SetFont('Arial', 'B', 10);
    fpdf::Cell(190, 6, 'Additional', 'T', 1, 'L');
    fpdf::SetFont('Arial', '', 10);
    fpdf::Cell(160, 6, $additional->add_order_task, 'B', 0, 'L');
    fpdf::Cell(30, 6, 'Rp. ' . number_format($additional->add_order_charge, 0, ',', '.') . ',-', 'B', 1, 'R');
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

fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(160, 6, 'Total', 'TB', 0, 'R');
fpdf::Cell(30, 6, 'Rp. ' . number_format($total, 0, ',', '.') . ',-', 'TB', 1, 'R');
//TERBILANG
fpdf::SetFont('Arial', 'I', 10);
fpdf::Cell(190, 6, 'Terbilang : ' . Terbilang($total) . 'Rupiah', 0, 1, 'L');
fpdf::Cell(190, 6, '', 0, 1, 'L');
//PAYMENT
fpdf::SetFont('Arial', '', 8);
fpdf::Cell(30, 6, 'Payment Method', 0, 0, 'L');
fpdf::Cell(5, 6, ':', 0, 0, 'L');
fpdf::Cell(60, 6, $kesmas->order_payment_method . ' No.' . $payment->payment_mou_number . ' at ' . $kesmas->order_payment_date, 0, 0, 'L');
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(60, 6, 'Due Date :', 0, 0, 'R');
fpdf::Cell(30, 6, date('d-m-Y', strtotime($payment->payment_mou_duedate)), 0, 1, 'R');
//NOTES
fpdf::SetFont('Arial', 'I', 8);
fpdf::Cell(190, 6, 'Note: All types of payments can only be made at the cashier.', 0, 1, 'L');
fpdf::Cell(140, 6, '*Purchases that have been entered into LabKlin Systems cannot be cancelled.', 0, 1, 'L');//Cek apakah sisa halaman > 280
if (Fpdf::GetY() > 250) {
    Fpdf::AddPage();
}
fpdf::SetFont('Arial', '', 10);
fpdf::Cell(140, 6, '', 0, 0, 'L');
$yttd = Fpdf::GetY();
Fpdf::Image('template/stamp.png', 125, $yttd - 5, -190);
Fpdf::Image('template/ttd_bendahara.png', 160, $yttd + 8, -190);
fpdf::Cell(50, 6, 'Palangka Raya, ' . date('d - m - Y', strtotime($kesmas->order_payment_date)), 0, 1, 'R');
fpdf::Cell(140, 6, '', 0, 0, 'L');
fpdf::SetFont('Arial', '', 10);
fpdf::Cell(50, 6, 'Officer,', 0, 1, 'C');
fpdf::SetFont('Arial', '', 8);
fpdf::Cell(190, 15, '', 0, 1, 'L');
fpdf::Cell(140, 6, '', 0, 0, 'L');
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(50, 6, 'Fransiska R., SKM', 0, 1, 'C');
fpdf::Cell(140, 6, '', 0, 0, 'L');
fpdf::SetFont('Arial', '', 10);
fpdf::Cell(50, 6, 'NIP. 19820929 200604 2 026', 0, 1, 'C');

// TOTAL PAGE
fpdf::AliasNbPages();
Fpdf::Output('PKS - Receipt.pdf', 'I');
exit();
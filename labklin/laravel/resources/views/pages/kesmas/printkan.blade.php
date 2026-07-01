<?php
// use Codedge\Fpdf\Fpdf\Fpdf;
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align
function pangkat($text)
{
    if (preg_match('/^(.+?)\^(.+?)\^$/', $text, $matches)) {
        // Contoh input: "x^2^", "Volume^3^", "v^n^"
        $x = Fpdf::GetX();
        $y = Fpdf::GetY();
        Fpdf::SetXY($x + 115, $y);
        Fpdf::Write(5, $matches[1]);
        Fpdf::subWrite(5, $matches[2], '', 6, 4);
        Fpdf::SetXY($x, $y);
        return '';
    } else if (preg_match('/^(.+?)\^(.+?)\^(.+)$/', $text, $matches)) {
        // Contoh input: "C^o^C"
        $x = Fpdf::GetX();
        $y = Fpdf::GetY();
        Fpdf::SetXY($x + 115, $y);
        Fpdf::Write(5, $matches[1]);
        Fpdf::subWrite(5, $matches[2], '', 6, 4);
        Fpdf::Write(5, $matches[3]);
        Fpdf::SetXY($x, $y);
        return '';
    } else if (preg_match('/^\^(.+?)\^(.+)$/', $text, $matches)) {
        // Contoh input: "^o^C"
        $x = Fpdf::GetX();
        $y = Fpdf::GetY();
        Fpdf::SetXY($x + 115, $y);
        Fpdf::subWrite(5, $matches[1], '', 6, 4);
        Fpdf::Write(5, $matches[2]);
        Fpdf::SetXY($x, $y);
        return '';
    }

    return $text;
}
function indonesianDatefull($date)
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
    $formattedDate = date('d F Y H:i', strtotime($date));
    return strtr($formattedDate, $months);
}
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

require_once("phpqrcode/qrlib.php");
Fpdf::SetMargins(15, 38, 15);
Fpdf::SetAutoPageBreak(true, 30);
if ($kesmas->order_collector === 'laboratory') {
    $collector = 'Laboratorium';
} else {
    $collector = 'Pelanggan';
}

if ($kesmas->order_type === 'Kimia') {
    $pjt = 'DINA WAHYUNI, S.Si., M.Si';
    $nip = '19810128 200903 2 001';
    $bidang = 'Kimia Kesehatan dan Toksikologi';
    $dp = 'DP/7.8.1/LKK-PKY';
} else if ($kesmas->order_type === 'Mikrobiologi') {
    $pjt = 'ARTSONETA VIVANELI, S.Si';
    $nip = '19731116 199703 2 002';
    $bidang = 'Mikrobiologi Kesehatan Masyarakat';
    $dp = 'DP/7.8.2/LKK-PKY';
} else {
    $pjt = '(                                 )';
    $nip = '                             ';
    $dp = 'DP/     /LKK-PKY';
}
// IMAGE
$encode = $kesmas->order_encode;
$public = url('/verify-km/lhukan/');
$qrlink = $public . "/" . $encode;
QRcode::png($qrlink, "qr.png");

Fpdf::SetAuthor('LabKlin Systems');
Fpdf::SetTitle('LHU Final - ' . $kesmas->order_code);
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
    Fpdf::AddPageKan();
    //Haeder KAN
    Fpdf::Headerkan();
    Fpdf::SetFont('Arial', 'BU', 12);
    Fpdf::SetY(40);
    Fpdf::Cell(180, 5, 'LAPORAN HASIL UJI', 0, 1, 'C');
    Fpdf::SetFont('Arial', '', 10);
    Fpdf::Cell(180, 5, 'No. ' . $kesmas->order_code, 0, 1, 'C');
    //Customer Data
    Fpdf::SetY(55);
    Fpdf::Cell(45, 5, 'Kode Pelanggan', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $customers->customer_code, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Nama Pelanggan', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::SetFont('Arial', 'B', 10);
    Fpdf::Cell(130, 5, $customers->customer_name . ' / ' . $customers->customer_type, 0, 1, 'L');
    Fpdf::SetFont('Arial', '', 10);
    Fpdf::Cell(45, 5, 'Alamat', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $customers->customer_address . ' / ' . $customers->customer_address_detail, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Personel Penghubung', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $customers->customer_pic, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Jenis Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $kesmas->order_type, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Nama Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $sample_type, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Nomor Sampel Pelanggan', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $sample->sample_id, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Nomor Sampel Lab.', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $sample->sample_code, 0, 1, 'L');

    //Barcode
    $x = fpdf::GetX();
    $y = fpdf::GetY();
    fpdf::Image("qr.png", $x + 150, $y - 5, 23, 23, "png");


    Fpdf::Cell(45, 5, 'Pengambil Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $collector, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Waktu Pengambilan Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, indonesianDatefull($kesmas->order_collect), 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Waktu Penerimaan Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, indonesianDatefull($kesmas->order_receive), 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Periode Pengujian', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, indonesianDate($kesmas->order_receive) . ' - ' . indonesianDate($kesmas->order_verify), 0, 1, 'L');
    //Parameter Result

    $yparam = Fpdf::GetY();
    Fpdf::SetY($yparam + 5);
    Fpdf::SetFont('Arial', 'B', 10);
    Fpdf::Cell(7, 6, 'No', 1, 0, 'C');
    Fpdf::Cell(45, 6, 'Parameter', 1, 0, 'C');
    Fpdf::Cell(58, 6, 'Metode', 1, 0, 'C');
    Fpdf::Cell(20, 6, 'Satuan', 1, 0, 'C');
    if ($collector === 'Laboratorium') {
        Fpdf::Cell(30, 6, 'Nilai Rujukan', 1, 0, 'C');
        Fpdf::Cell(20, 6, 'Hasil', 1, 1, 'C');
    } else {
        Fpdf::Cell(50, 6, 'Hasil', 1, 1, 'C');
    }
    Fpdf::Cell(10, 6, '', 'L', 0, 'C');
    Fpdf::Cell(170, 6, $sample_type, 'R', 1, 'L');
    $no = 0;
    Fpdf::SetFont('Arial', '', 9);
    $parameters = DB::table('kesmas_orders_detail')->where('order_code', $kesmas->id)->where('order_sample_id', $sample->id)->get();
    // foreach ($parameters as $parameter) {
    //     $no++;
    //     Fpdf::Cell(7, 12, $no, 1, 0, 'C');
    //     Fpdf::Cell(45, 12, $parameter->order_parameter_name, 1, 0, 'L');
    //     Fpdf::Cell(58, 12, $parameter->order_parameter_method, 1, 0, 'L');
    //     Fpdf::Cell(20, 12, $parameter->order_parameter_unit, 1, 0, 'C');
    //     if ($collector === 'Laboratorium') {
    //         Fpdf::Cell(30, 12, $parameter->order_parameter_reference_value, 1, 0, 'C');
    //         Fpdf::Cell(20, 12, $parameter->order_parameter_result, 1, 1, 'C');
    //     } else {
    //         Fpdf::Cell(50, 12, $parameter->order_parameter_result, 1, 1, 'C');
    //     }
    // }
    // Table
    if ($collector === 'Laboratorium') {
        Fpdf::SetWidths(array(7, 45, 58, 20, 30, 20));
        Fpdf::SetAligns(array('C', 'L', 'C', 'C', 'C', 'C'));

        $no = 0;
        foreach ($parameters as $parameter) {
            $no++;
            Fpdf::Row([
                $no . '.',
                $parameter->order_parameter_name,
                $parameter->order_parameter_method,
                // $parameter->order_parameter_unit,
                pangkat($parameter->order_parameter_unit),
                $parameter->order_parameter_reference_value,
                $parameter->order_parameter_result
            ]);
        }
    } else {
        Fpdf::SetWidths(array(7, 45, 58, 20, 50));
        Fpdf::SetAligns(array('C', 'L', 'C', 'C', 'C'));
        $no = 0;
        foreach ($parameters as $parameter) {
            $no++;
            Fpdf::Row([
                $no,
                $parameter->order_parameter_name,
                $parameter->order_parameter_method,
                pangkat($parameter->order_parameter_unit),
                $parameter->order_parameter_result
            ]);
        }
    }

    Fpdf::MultiCellNoFill(180, 5, 'Keterangan Sampel : ' . $sample->sample_note, 1, 'L');
    Fpdf::MultiCellNoFill(180, 5, 'Keterangan Pengujian : ' . $kesmas->order_note, 1, 'L');
    //Cek apakah sisa halaman > 280
    if (Fpdf::GetY() > 280) {
        Fpdf::AddPage();
    }

    Fpdf::SetFont('Arial', '', 9);
    Fpdf::Cell(180, 5, 'Catatan :', 0, 1, 'L');
    if ($kesmas->order_type === 'Kimia') {
        //CATATAN KIMIA
        Fpdf::Cell(10, 5, '1.', 0, 0, 'L');
        Fpdf::Cell(170, 5, 'Hasil uji ini hanya berlaku untuk sampel yang diuji.', 0, 1, 'L');
        // Fpdf::Cell(10, 5, '2.', 0, 0, 'L');
        // Fpdf::Cell(170, 5, 'Parameter lapangan (#) diuji di Laboratorium.', 0, 1, 'L');
        // Fpdf::Cell(10, 5, '3.', 0, 0, 'L');
        // Fpdf::Cell(170, 5, 'Tanda (<) menunjukkan bahwa hasil dibawah batas deteksi metode (< MDL).', 0, 1, 'L');
        Fpdf::Cell(10, 5, '2.', 0, 0, 'L');
        $ynote = Fpdf::GetY();
        Fpdf::MultiCellNoFill(170, 5, 'Laporan Hasil Uji ini tidak boleh digandakan kecuali secara lengkap dan seizin tertulis dari UPT Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.', 0, 'L');
        Fpdf::Cell(10, 5, '3.', 0, 0, 'L');
        Fpdf::Cell(170, 5, 'Laboratorium melayani pengaduan / complaint maksimum 1 (satu) minggu terhitung dari tanggal penyerahan LHU.', 0, 1, 'L');
        // Fpdf::Cell(10, 5, '6.', 0, 0, 'L');
        // Fpdf::Cell(170, 5, 'Laboratorium tidak bertanggungjawab terhadap proses pengambilan dan transportasi sampel.', 0, 1, 'L');
        // Fpdf::Cell(10, 5, '7.', 0, 0, 'L');
        // Fpdf::Cell(170, 5, 'Tanda (*) menunjukkan parameter terakreditasi KAN Nomor LP-1794-IDN.', 0, 1, 'L');

        // 1. Hasil uji ini hanya berlaku untuk sampel yang diuji.
// 2. Laporan Hasil Uji ini tidak boleh digandakan kecuali secara lengkap dan seizin tertulis dari UPT Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.
// 3. Laboratorium melayani pengaduan / complaint maksimum 1 (satu) minggu terhitung dari tanggal penyerahan LHU.
    } else if ($kesmas->order_type === 'Mikrobiologi') {
        //CATATAN MIKROBIOLOGI
        if ($collector === 'Laboratorium') {
            Fpdf::Cell(10, 5, '1.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Metode Pengambilan contoh air untk pengujian mikrobiologi mengacu pada SNI 9063:2022.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '2.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Laporan Hasil Uji ini terdiri dari 1 (satu) halaman.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '3.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Laporan Hasil Uji ini terdiri dari 1 (satu) halaman.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '4.', 0, 0, 'L');
            $ynote = Fpdf::GetY();
            Fpdf::MultiCellNoFill(170, 5, 'Laporan Hasil Uji ini tidak boleh digandakan kecuali secara lengkap dan seizin tertulis dari UPT Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.', 0, 'L');
            Fpdf::Cell(10, 5, '5.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Laboratorium melayani pengaduan / complaint maksimum 1 (satu) minggu terhitung dari tanggal penyerahan LHU.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '6.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Tanda (*) menunjukkan parameter terakreditasi KAN Nomor LP-1794-IDN.', 0, 1, 'L');
        } else {
            Fpdf::Cell(10, 5, '1.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Hasil uji ini hanya berlaku untuk sampel yang diuji.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '2.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Laporan Hasil Uji ini terdiri dari 1 (satu) halaman.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '3.', 0, 0, 'L');
            $ynote = Fpdf::GetY();
            Fpdf::MultiCellNoFill(170, 5, 'Laporan Hasil Uji ini tidak boleh digandakan kecuali secara lengkap dan seizin tertulis dari UPT Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.', 0, 'L');
            Fpdf::Cell(10, 5, '4.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Laboratorium melayani pengaduan / complaint maksimum 1 (satu) minggu terhitung dari tanggal penyerahan LHU.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '5.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Laboratorium tidak bertanggungjawab terhadap proses pengambilan dan transportasi sampel.', 0, 1, 'L');
            Fpdf::Cell(10, 5, '6.', 0, 0, 'L');
            Fpdf::Cell(170, 5, 'Tanda (*) menunjukkan parameter terakreditasi KAN Nomor LP-1794-IDN.', 0, 1, 'L');
        }
    }
    //Cek apakah sisa halaman > 250
    if (Fpdf::GetY() > 250) {
        Fpdf::AddPage();
    }
    $yttd = Fpdf::GetY();
    Fpdf::Image('template/stamp.png', 110, $yttd + 5, -190);
    Fpdf::Image('template/ttd_kasie.png', 130, $yttd + 10, -140);
    if ($kesmas->order_type === 'Kimia') {
        Fpdf::Image('template/ttd_kimia.png', 40, $yttd + 18, -190);
    } else {
        Fpdf::Image('template/ttd_mikro.png', 40, $yttd + 23, -190);
    }
    //Cek Validasi 
    $validate_at = $kesmas->order_validate;
    if ($validate_at === null) {
        $validate_at = now();
    } else {
        $validate_at = $kesmas->order_validate;
    }
    Fpdf::SetY($yttd + 3);
    Fpdf::SetFont('Arial', '', 10);
    Fpdf::Cell(180, 6, 'Palangka Raya, ' . indonesianDate($validate_at), 0, 1, 'R');
    Fpdf::SetY($yttd + 12);
    Fpdf::Cell(90, 6, 'Penanggungjawab Teknis', 0, 0, 'C');
    Fpdf::Cell(90, 6, 'Kepala Seksi', 0, 1, 'C');
    Fpdf::Cell(90, 6, $bidang, 0, 0, 'C');
    Fpdf::Cell(90, 6, 'Laboratorium Kesehatan Masyarakat dan Klinik', 0, 1, 'C');
    Fpdf::Cell(90, 20, '', 0, 0, 'C');
    Fpdf::Cell(90, 20, '', 0, 1, 'C');
    Fpdf::Cell(90, 5, $pjt, 0, 0, 'C');
    Fpdf::Cell(90, 5, 'AGUS, S.Si., M.MKes., M. Si', 0, 1, 'C');
    Fpdf::Cell(90, 5, 'NIP. ' . $nip, 0, 0, 'C');
    Fpdf::Cell(90, 5, 'NIP. 19700801 199803 1 009', 0, 1, 'C');

    //DP
    Fpdf::SetFont('Arial', '', 8);
    Fpdf::TextWithDirection(15, 305, $dp, 'U');
}
// TOTAL PAGE
Fpdf::AliasNbPages();
// Fpdf::Output('FPPS.pdf', 'I');
Fpdf::Output('LHU Final - ' . $kesmas->order_code . '.pdf', 'I');
exit();
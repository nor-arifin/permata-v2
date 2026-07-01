<?php
// use Codedge\Fpdf\Fpdf\Fpdf;
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align

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
} else if ($kesmas->order_type === 'Mikrobiologi') {
    $pjt = 'ARTSONETA VIVANELI, S.Si';
    $nip = '19731116 199703 2 002';
    $bidang = 'Mikrobiologi Kesehatan Masyarakat';
} else {
    $pjt = '(                                 )';
    $nip = '                             ';
}
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
    Fpdf::AddPageBlank('P', 'f4', 0); //Orientation, Paper Size, Rotation

    Fpdf::SetTitle('DRAFT LHU - ' . $kesmas->order_code);
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
    Fpdf::Cell(45, 5, 'Pengambil Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, $collector, 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Waktu Pengambilan Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, date('d F Y H:i', strtotime($kesmas->order_collect)), 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Waktu Penerimaan Sampel', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, date('d F Y H:i', strtotime($kesmas->order_receive)), 0, 1, 'L');
    Fpdf::Cell(45, 5, 'Periode Pengujian', 0, 0, 'L');
    Fpdf::Cell(5, 5, ':', 0, 0, 'L');
    Fpdf::Cell(130, 5, date('d F Y H:i', strtotime($kesmas->order_receive)) . ' - ' . date('d F Y H:i'), 0, 1, 'L');
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
    foreach ($parameters as $parameter) {
        $no++;
        Fpdf::Cell(7, 12, $no, 1, 0, 'C');
        Fpdf::Cell(45, 12, $parameter->order_parameter_name, 1, 0, 'L');
        Fpdf::Cell(58, 12, $parameter->order_parameter_method, 1, 0, 'L');
        Fpdf::Cell(20, 12, $parameter->order_parameter_unit, 1, 0, 'C');
        if ($collector === 'Laboratorium') {
            Fpdf::Cell(30, 12, $parameter->order_parameter_reference_value, 1, 0, 'C');
            Fpdf::Cell(20, 12, $parameter->order_parameter_result, 1, 1, 'C');
        } else {
            Fpdf::Cell(50, 12, $parameter->order_parameter_result, 1, 1, 'C');
        }
    }
    Fpdf::MultiCellNoFill(180, 5, 'Keterangan Sampel : ' . $sample->sample_note, 1, 'L');
    Fpdf::MultiCellNoFill(180, 5, 'Keterangan Pengujian : ' . $kesmas->order_note, 1, 'L');
    //Cek apakah sisa halaman > 280
    if (Fpdf::GetY() > 280) {
        Fpdf::AddPageBlank('P', 'f4', 0);
    }
    Fpdf::SetFont('Arial', '', 9);
    Fpdf::Cell(180, 5, 'Catatan :', 0, 1, 'L');
    Fpdf::Cell(10, 5, '1.', 0, 0, 'L');
    Fpdf::Cell(170, 5, 'Metode pengambilan contoh air untuk pengujian fisika dan kimia mengacu pada SNI 8995:2021 (terakreditasi).', 0, 1, 'L');
    Fpdf::Cell(10, 5, '2.', 0, 0, 'L');
    Fpdf::Cell(170, 5, 'Hasil uji ini hanya berlaku untuk sampel yang diuji.', 0, 1, 'L');
    Fpdf::Cell(10, 5, '3.', 0, 0, 'L');
    Fpdf::Cell(170, 5, 'Tanda (<) menunjukkan bahwa hasil dibawah batas deteksi metode (< MDL).', 0, 1, 'L');
    Fpdf::Cell(10, 5, '4.', 0, 0, 'L');
    $ynote = Fpdf::GetY();
    Fpdf::MultiCellNoFill(170, 5, 'Hasil uji ini tidak boleh digandakan, kecuali secara lengkap dan seizin tertulis dari UPT Laboratorium Kesehatan dan Kalibrasi Provinsi Kalimantan Tengah.', 0, 'L');
    Fpdf::Cell(10, 5, '5.', 0, 0, 'L');
    Fpdf::Cell(170, 5, 'Laboratorium melayani pengaduan / complaint maksimum 1 (satu) minggu terhitung dari tanggal penyerahan LHU.', 0, 1, 'L');
    Fpdf::Cell(10, 5, '6.', 0, 0, 'L');
    Fpdf::Cell(170, 5, 'Tanda (*) menunjukkan parameter terakreditasi KAN Nomor LP-1794-IDN.', 0, 1, 'L');

}

// TOTAL PAGE
Fpdf::AliasNbPages();
Fpdf::Output('FPPS.pdf', 'I');
exit();
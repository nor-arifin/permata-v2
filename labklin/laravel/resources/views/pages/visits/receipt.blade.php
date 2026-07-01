<?php
// Hitung Umur
$age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
// FUNGSI MENAMPILKAN TERBILANG
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
// SetFont( Font Name['Courier','Arial'], Font Style['','B','I','U'], Font Size )
// Font style empty string: regular, B: bold, I: italic, U: underline
// Title or Header Page cell( Cell width, Cell height, String text value, border[0,1], Indicates [0,1,3], Text align['L','C','R'] )
// Text align L or empty string, C: center, R: right align
Fpdf::SetMargins(10, 38, 15);
Fpdf::SetAutoPageBreak(true, 30);
Fpdf::AddPage();
Fpdf::SetTitle('Receipt - ' . $visit->visit_patient_name . ' - ' . $visit->visit_registration_id);
Fpdf::SetFont('Arial', 'B', 12);
Fpdf::SetXY(10, 42);
Fpdf::Cell(190, 5, 'Payment Receipt', 0, 1, 'C');

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
fpdf::Cell(10, 6, 'No.', 'TB', 0, 'C');
fpdf::Cell(60, 6, 'Service Item', 'TB', 0, 'C');
fpdf::Cell(40, 6, 'Group', 'TB', 0, 'C');
fpdf::Cell(20, 6, 'Qty', 'TB', 0, 'C');
fpdf::Cell(30, 6, 'Price', 'TB', 0, 'C');
fpdf::Cell(30, 6, 'Sub Total', 'TB', 1, 'C');
//SERVICE DETAILS
//Loop Tabel
fpdf::SetFont('Arial', '', 10);
$no = 0;
foreach ($services as $service) {

    $date = $service->created_at;
    $date = date('d-m-Y', strtotime($date));
    if ($service->service_loinc_code == null) {
        $type = "Service - ";
    } else {
        $type = "Lab - ";
    }
    $price = $service->service_price;
    $qty = $service->service_quantity;
    $subtotal = $price * $qty;
    $no++;
    fpdf::Cell(10, 6, $no, 'B', 0, 'C');
    fpdf::Cell(60, 6, $service->service_name, 'B', 0, 'L');
    fpdf::Cell(40, 6, $type . $service->service_group, 'B', 0, 'L');
    fpdf::Cell(20, 6, $service->service_quantity, 'B', 0, 'C');
    fpdf::Cell(30, 6, 'Rp. ' . number_format($service->service_price, 0, ',', '.') . ',-', 'B', 0, 'R');
    fpdf::Cell(30, 6, 'Rp. ' . number_format($subtotal, 0, ',', '.') . ',-', 'B', 1, 'R');
}
//SUM PRICE
$total = 0;
foreach ($services as $service) {
    $price = $service->service_price;
    $qty = $service->service_quantity;
    $subtotal = $price * $qty;
    $total += $subtotal;
}
$discount = $visit->visit_payment_discount;
$payment = $total - $discount;
fpdf::SetFont('Arial', '', 10);
fpdf::Cell(160, 6, 'Sub Total', 'B', 0, 'R');
fpdf::Cell(30, 6, 'Rp. ' . number_format($total, 0, ',', '.') . ',-', 'B', 1, 'R');
fpdf::Cell(160, 6, 'Discount', 'B', 0, 'R');
fpdf::Cell(30, 6, 'Rp. ' . number_format($visit->visit_payment_discount, 0, ',', '.') . ',-', 'B', 1, 'R');
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(160, 6, 'Total', 'B', 0, 'R');
fpdf::Cell(30, 6, 'Rp. ' . number_format($payment, 0, ',', '.') . ',-', 'B', 1, 'R');
//TERBILANG
fpdf::SetFont('Arial', 'IB', 10);
fpdf::Cell(190, 6, Terbilang($payment) . 'Rupiah', 0, 1, 'L');
fpdf::Cell(190, 6, '', 0, 1, 'L');
//PAYMENT
fpdf::SetFont('Arial', '', 8);
fpdf::Cell(30, 6, 'Payment Method', 0, 0, 'L');
fpdf::Cell(10, 6, ':', 0, 0, 'L');
fpdf::Cell(60, 6, $visit->visit_payment_method, 0, 0, 'L');
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(60, 6, 'Payment Amount', 0, 0, 'R');
fpdf::Cell(30, 6, 'Rp. ' . number_format($visit->visit_payment_amount, 0, ',', '.') . ',-', 0, 1, 'R');
//PAYMENT STATUS
fpdf::SetFont('Arial', '', 8);
fpdf::Cell(30, 6, 'Payment Status', 0, 0, 'L');
fpdf::Cell(10, 6, ':', 0, 0, 'L');
fpdf::Cell(60, 6, $visit->visit_payment_notes . '/' . ucfirst($visit->visit_payment_status), 0, 0, 'L');
fpdf::SetFont('Arial', 'B', 10);
fpdf::Cell(60, 6, 'Payment Remaining', 0, 0, 'R');
fpdf::Cell(30, 6, 'Rp. ' . number_format($visit->visit_payment_remaining, 0, ',', '.') . ',-', 0, 1, 'R');
//NOTES
fpdf::SetFont('Arial', 'I', 8);
fpdf::Cell(190, 6, 'Note: All types of payments can only be made at the cashier.', 0, 1, 'L');
fpdf::Cell(140, 6, '*Purchases that have been entered into LabKlin Systems cannot be cancelled.', 0, 0, 'L');

if ($visit->visit_payment_officer != null) {
    //Cek apakah sisa halaman > 280
    if (Fpdf::GetY() > 280) {
        Fpdf::AddPage();
    }
    $yttd = Fpdf::GetY();

    fpdf::SetFont('Arial', '', 10);
    fpdf::Cell(50, 6, 'Palangka Raya, ' . date('d - m - Y', strtotime($visit->visit_payment_time)), 0, 1, 'C');
    fpdf::Cell(140, 6, '', 0, 0, 'L');
    fpdf::SetFont('Arial', '', 10);
    fpdf::Cell(50, 6, 'Officer,', 0, 1, 'C');
    fpdf::SetFont('Arial', '', 8);
    fpdf::Cell(190, 15, '', 0, 1, 'L');
    fpdf::Cell(140, 6, '', 0, 0, 'L');
    fpdf::SetFont('Arial', 'B', 10);
    fpdf::Cell(50, 6, auth()->user()->name, 0, 1, 'C');
}

$named = $visit->visit_patient_name;
$noreg = $visit->visit_registration_id;
// TOTAL PAGE
fpdf::AliasNbPages();
Fpdf::Output('Receipt - ' . $named . ' - ' . $noreg . '.pdf', 'I');
exit();
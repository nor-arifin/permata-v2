<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Bulanan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .noBorder {
        border:none !important;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center;">Monthly Visit Report</h1>
    <h2 style="text-align: center;">{{ $month }} - {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th style="text-align: center;">No.</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">No Reg</th>
                <th style="text-align: center;">Name</th>
                <th style="text-align: center;">Department</th>
                <th style="text-align: center;">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $visit)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: center;">{{ $visit->visit_date }}</td>
                <td style="text-align: center;">{{ $visit->visit_registration_id }}</td>
                <td>{{ $visit->visit_patient_name }} ( {{ $visit->visit_patient_mr }} )</td>
                <td style="text-align: center;">{{ $visit->visit_patient_dept }}</td>
                <td style="text-align: center;">
                    @if($visit->visit_status_timeline == 'Registered')
                    <div>Registered</div>
                    @elseif($visit->visit_status_timeline == 'Arrived')
                    <div>Arrived</div>
                    @elseif($visit->visit_status_timeline == 'Waiting')
                    <div>Waiting</div>
                    @elseif($visit->visit_status_timeline == 'Sampling')
                    <div>Sampling</div>
                    @elseif($visit->visit_status_timeline == 'Examination')
                    <div>Examination</div>
                    @elseif($visit->visit_status_timeline == 'Validation')
                    <div>Validation</div>
                    @elseif($visit->visit_status_timeline == 'Reporting')
                    <div>Reporting</div>
                    @elseif($visit->visit_status_timeline == 'Finished')
                    <div>Finished</div>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @php
        $totalRevenue = $sales->sum('visit_payment_amount');
        $totalCharge = $sales->sum('visit_payment_charge');
        $totalDiscount = $sales->sum('visit_payment_discount');
        $charge = number_format($totalCharge,0,',','.');
        $discount = number_format($totalDiscount,0,',','.');
        $revenue = number_format($totalRevenue,0,',','.');
    @endphp
    <h3>Summary Report</h3>
    <table style="border-style:none;">
        <tr>
            <td style="width: 75%;">Total Patient</td>
            <td style="width: 5%;">:</td>
            <td style="width: 20%;"><b>{{ $sales->count() }} Patient</b></td>
        </tr>
        <tr>
            <td style="width: 75%;">Total Charge</td>
            <td style="width: 5%;">:</td>
            <td style="width: 20%;"><b>Rp. {{ $charge }}</b></td>
        </tr>
        <tr>
            <td style="width: 75%;">Total Discount</td>
            <td style="width: 5%;">:</td>
            <td style="width: 20%;"><b>Rp. {{ $discount }}</b></td>
        </tr>
        <tr>
            <td style="width: 75%;">Total Revenue</td>
            <td style="width: 5%;">:</td>
            <td style="width: 20%;"><b>Rp. {{ $revenue }}</b></td>
        </tr>
    </table>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Revenue Bulanan</title>
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
    <h1 style="text-align: center;">Monthly Revenue Report</h1>
    <h2 style="text-align: center;">{{ $month }} - {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th style="text-align: center;">No.</th>
                <th style="text-align: center;">Date</th>
                <th style="text-align: center;">Charge</th>
                <th style="text-align: center;">Discount</th>
                <th style="text-align: center;">Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $visit)
            @php
                $sumcharge = number_format($visit->totalcharge,0,',','.');
                $sumdiscount = number_format($visit->totaldiscount,0,',','.');
                $sumrevenue = number_format($visit->totalrevenue,0,',','.');
            @endphp
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: center;">{{ $visit->date }}</td>
                <td style="text-align: center;">Rp. {{ $sumcharge }}</td>
                <td style="text-align: center;">Rp. {{ $sumdiscount }}</td>
                <td style="text-align: center;">Rp. {{ $sumrevenue }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @php
        $charge = number_format($sales->sum('totalcharge'),0,',','.');
        $discount = number_format($sales->sum('totaldiscount'),0,',','.');
        $revenue = number_format($sales->sum('totalrevenue'),0,',','.');
    @endphp
    <h3>Summary Report</h3>
    <table style="border-style:none;">
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

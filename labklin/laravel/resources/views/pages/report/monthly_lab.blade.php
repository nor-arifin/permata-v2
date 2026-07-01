<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Laboratory Bulanan</title>
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
    <h1 style="text-align: center;">Monthly Laboratory Report</h1>
    <h2 style="text-align: center;">{{ $month }} - {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th style="text-align: center;">No.</th>
                <th style="text-align: center;">Test Name</th>
                <th style="text-align: center;">Total Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labs as $lab)
            @php
                $sumquantity = number_format($lab->quantity,0,',','.');
            @endphp
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: left;">{{ $lab->test }}</td>
                <td style="text-align: center;">{{ $sumquantity }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

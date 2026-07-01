<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Test Bulanan</title>
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
    <h1 style="text-align: center;">Monthly Test Report</h1>
    <h2 style="text-align: center;">{{$labs[0]->test}} - {{ $month }} - {{ $year }}</h2>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 5%;">No.</th>
                <th style="text-align: center; width: 20%;">Date</th>
                <th style="text-align: center; width: 10%;">No Reg</th>
                <th style="text-align: center; width: 35%;">Name</th>
                <th style="text-align: center; width: 20%;">Result</th>
                <th style="text-align: center; width: 10%;">Unit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($labs as $lab)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td style="text-align: left;">{{ $lab->date }}</td>
                <td style="text-align: center;">{{ $lab->noreg }}</td>
                <td style="text-align: left;">{{ $lab->name }}</td>
                <td style="text-align: center;">{{ $lab->result }}</td>
                <td style="text-align: center;">{{ $lab->unit }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

@extends('layouts.app')

@section('title', 'LOINC')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Report Visit</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Report</a></div>
                <div class="breadcrumb-item">Visit</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- EDITING --}}

    <h1>Laporan Penjualan Bulanan</h1>

    <form action="{{ route('report.visit') }}" method="GET">
        <label for="month">Pilih Bulan:</label>
        <input type="month" id="month" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
        <button type="submit">Filter</button>
    </form>

    <h2>{{ $month }} - {{ $year }}</h2>

    <table border="1">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Tanggal Penjualan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->product_name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ $sale->price }}</td>
                    <td>{{ $sale->total }}</td>
                    <td>{{ $sale->sale_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Total Pendapatan: {{ $totalRevenue }}</h3>
    <h3>Total Barang Terjual: {{ $totalItemsSold }}</h3>

    <form action="{{ route('reports.export.excel') }}" method="GET" style="display: inline-block;">
        <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
        <button type="submit">Export to Excel</button>
    </form>

    <form action="{{ route('reports.export.pdf') }}" method="GET" style="display: inline-block;">
        <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
        <button type="submit">Export to PDF</button>
    </form>
                            {{-- END --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')

    <script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    {{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}">
    </script> --}}
@endpush

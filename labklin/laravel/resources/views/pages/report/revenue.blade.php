@extends('layouts.app')

@section('title', 'Report Revenue')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Report Revenue</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Report</a></div>
                <div class="breadcrumb-item">Revenue</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Filter Report</h2>
                            {{-- FORM --}}
                            <form action="{{ route('report.revenue') }}" method="GET">
                                <div class="form-group">
                                    <label for="month">Select Month</label>
                                    <input class="form-control" type="month" id="month" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                </div>
                                <div class="form-group">
                                    <div class="text-right">
                                    <button class="btn btn-primary" type="submit">Filter</button>
                                    </div>
                                </div>
                            </form>
                            {{-- END FORM --}}
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Summary Report</h2>
                            {{-- LIST --}}
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    @php
                                        $chargeall = number_format($sales->sum('totalcharge'),0,',','.');
                                    @endphp
                                    <b>Total Charge</b>
                                    <span class="badge badge-success badge-pill">Rp. {{ $chargeall }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    @php
                                        $discountall = number_format($sales->sum('totaldiscount'),0,',','.');
                                    @endphp
                                    <b>Total Discount</b>
                                    <span class="badge badge-success badge-pill">Rp. {{ $discountall }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    @php
                                        $revenueall = number_format($sales->sum('totalrevenue'),0,',','.');
                                    @endphp
                                    <b>Total Revenue</b>
                                    <span class="badge badge-success badge-pill">Rp. {{ $revenueall }}</span>
                                </div>
                            </div>
                            {{-- END LIST --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Revenue Report</h2>
                            {{-- TABLE --}}
                            <div class="table-responsive mt-2">
                                <table class="table-striped table">
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>Total Charge</th>
                                        <th>Total Discount</th>
                                        <th>Total Revenue</th>
                                    </tr>
                                    @foreach ($sales as $visit)
                                    @php
                                        $sumcharge = number_format($visit->totalcharge,0,',','.');
                                        $sumdiscount = number_format($visit->totaldiscount,0,',','.');
                                        $sumrevenue = number_format($visit->totalrevenue,0,',','.');
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $visit->date }}</td>
                                        <td class="text-center">Rp. {{ $sumcharge }}</td>
                                        <td class="text-center">Rp. {{ $sumdiscount }}</td>
                                        <td class="text-center"><b>Rp. {{ $sumrevenue }}</b></td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $sales->withQueryString()->links() }}
                            </div>
                            {{-- END TABLE --}}
                            <h2 class="section-title">Download Report</h2>
                            <div class="form-group">
                                <div class="text-center mt-2">
                                    <form action="{{ route('reports.export.excelrevenue') }}" method="GET" style="display: inline-block;">
                                    <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-file-excel" aria-hidden="true"></i> Export to Excel</button>
                                    </form>

                                    <form action="{{ route('reports.export.pdfrevenue') }}" method="GET" style="display: inline-block;">
                                        <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                        <button class="btn btn-danger" type="submit"><i class="fa fa-file-pdf" aria-hidden="true"></i> Export to PDF</button>
                                    </form>
                                </div>
                            </div>
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
{{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script> --}}
@endpush

@extends('layouts.app')

@section('title', 'Report Visit')

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
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Filter Report</h2>
                            {{-- FORM --}}
                            <form action="{{ route('report.visit') }}" method="GET">
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
                                    <b>Total Visit</b>
                                    <span class="badge badge-success badge-pill">{{ $sales->count() }} Patient</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    @php
                                        $charge = number_format($totalCharge,0,',','.');
                                    @endphp
                                    <b>Total Charge</b>
                                    <span class="badge badge-success badge-pill">Rp. {{ $charge }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    @php
                                        $revenue = number_format($totalRevenue,0,',','.');
                                    @endphp
                                    <b>Total Revenue</b>
                                    <span class="badge badge-success badge-pill">Rp. {{ $revenue }}</span>
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
                            <h2 class="section-title">Visit Report</h2>
                            {{-- TABLE --}}
                            <div class="table-responsive mt-2">
                                <table class="table-striped table">
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>No Reg</th>
                                        <th>Name</th>
                                        <th>Department</th>
                                        <th>Status</th>
                                    </tr>
                                    @foreach ($sales as $visit)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $visit->visit_date }}</td>
                                        <td class="text-center">{{ $visit->visit_registration_id }}</td>
                                        <td>{{ $visit->visit_patient_name }} ( {{ $visit->visit_patient_mr }} )</td>
                                        <td class="text-center">{{ $visit->visit_patient_dept }}</td>
                                        <td class="text-center">
                                            @if($visit->visit_status_timeline == 'Registered')
                                            <div title="Registered" class="badge badge-pill badge-danger">Registered</div>
                                            @elseif($visit->visit_status_timeline == 'Arrived')
                                            <div title="Arrived"class="badge badge-pill badge-pink">Arrived</div>
                                            @elseif($visit->visit_status_timeline == 'Waiting')
                                            <div title="Waiting"class="badge badge-pill badge-info">Waiting</div>
                                            @elseif($visit->visit_status_timeline == 'Sampling')
                                            <div title="Sampling"class="badge badge-pill badge-warning text-dark">Sampling</div>
                                            @elseif($visit->visit_status_timeline == 'Examination')
                                            <div title="Examination"class="badge badge-pill badge-warning text-dark">Examination</div>
                                            @elseif($visit->visit_status_timeline == 'Validation')
                                            <div title="Validation"class="badge badge-pill badge-primary">Validation</div>
                                            @elseif($visit->visit_status_timeline == 'Reporting')
                                            <div title="Validation"class="badge badge-pill badge-success">Reporting</div>
                                            @elseif($visit->visit_status_timeline == 'Finished')
                                            <div title="Finished"class="badge badge-pill badge-success">Finished</div>
                                            @endif
                                        </td>
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
                                    <form action="{{ route('reports.export.excel') }}" method="GET" style="display: inline-block;">
                                    <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-file-excel" aria-hidden="true"></i> Export to Excel</button>
                                    </form>

                                    <form action="{{ route('reports.export.pdf') }}" method="GET" style="display: inline-block;">
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

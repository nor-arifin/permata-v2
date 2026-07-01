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
            <h1>Report {{$labs[0]->test}}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Report</a></div>
                <div class="breadcrumb-item">Laboratory</div>
                <div class="breadcrumb-item">{{$labs[0]->test}}</div>
            </div>
        </div>

        @php
        //GET YEAR AND MONTH FROM URL
            $monthYear = request()->input('month', date('Y-m'));
            $month = date('m', strtotime($monthYear));
            $year = date('Y', strtotime($monthYear));
            $coder = request()->input('code');
            $thisMonth = date('M Y', strtotime($monthYear));
        @endphp

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
                            <h2 class="section-title">{{$labs[0]->test}} Test Report {{$thisMonth}}</h2>
                            {{-- TABLE --}}
                            <div class="table-responsive mt-2">
                                <table class="table-striped table">
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>No Reg</th>
                                        <th>Name</th>
                                        <th>Test</th>
                                        <th>Result</th>
                                        <th>Reference</th>
                                        <th>Unit</th>
                                    </tr>
                                    @foreach ($labs as $detail)
                                    <tr>
                                        @php
                                            $date = date('d-m-Y', strtotime($detail->date));
                                        @endphp
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $date }}</td>
                                        <td class="text-center">{{ $detail->noreg }}</td>
                                        <td>{{ $detail->name }} ( {{ $detail->mr }} )</td>
                                        <td class="text-center">{{ $detail->test }}</td>
                                        <td class="text-center">{{ $detail->result }}</td>
                                        <td class="text-center">{{ $detail->reference }}</td>
                                        <td class="text-center">{{ $detail->unit }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $labs->withQueryString()->links() }}
                            </div>
                            {{-- END TABLE --}}
                            <h2 class="section-title">Download Report {{$thisMonth}}</h2>
                            @php
                                echo "Year: ".$year." Month: ".$month." Code: ".$coder;
                            @endphp
                            <div class="form-group">
                                <div class="text-center mt-2">
                                    <form action="{{ route('reports.export.exceldetail') }}" method="GET" style="display: inline-block;">
                                        <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                        <input type="hidden" name="code" value="{{ $coder }}">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-file-excel" aria-hidden="true"></i> Export to Excel</button>
                                    </form>
                                    <form action="{{ route('reports.export.pdfdetail') }}" method="GET" style="display: inline-block;">
                                        <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                        <input type="hidden" name="code" value="{{ $coder }}">
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

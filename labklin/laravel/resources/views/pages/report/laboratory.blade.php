@extends('layouts.app')

@section('title', 'Report Laboratory')

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
            <h1>Report Laboratory</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Report</a></div>
                <div class="breadcrumb-item">Laboratory</div>
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
                            <form action="{{ route('report.laboratory') }}" method="GET">
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
                            <h2 class="section-title">Laboratory Chart Report</h2>
                            {{-- LIST --}}
                            <canvas id="myChart4"
                                height="86"></canvas>
                            {{-- END LIST --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Laboratory Report</h2>
                            {{-- TABLE --}}
                            <div class="table-responsive mt-2">
                                <table class="table-striped table-hover table">
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Test Code</th>
                                        <th>Test Name</th>
                                        <th>Group</th>
                                        <th>SubGroup</th>
                                        <th>Total Order</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($labs as $lab)
                                    @php
                                        $sumquantity = number_format($lab->quantity,0,',','.');
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $lab->code }}</td>
                                        <td class="text-left">{{ $lab->test }}</td>
                                        <td class="text-center">{{ $lab->grouptest }}</td>
                                        <td class="text-center">{{ $lab->subgrouptest }}</td>
                                        <td class="text-center"><b>{{ $sumquantity }}</b></td>
                                        <td class="text-center">
                                            <form action="{{ route('report.laboratory.detail') }}" method="GET">
                                                <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                                <input type="hidden" name="code" value="{{ $lab->code }}">
                                                <button type="submit" class="btn btn-primary btn-sm">Detail</button>
                                            </form>
                                        </a>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $labs->withQueryString()->links() }}
                            </div>
                            {{-- END TABLE --}}
                            <h2 class="section-title">Download Report</h2>
                            <div class="form-group">
                                <div class="text-center mt-2">
                                    <form action="{{ route('reports.export.excellab') }}" method="GET" style="display: inline-block;">
                                        <input type="hidden" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                        <button class="btn btn-success" type="submit"><i class="fa fa-file-excel" aria-hidden="true"></i> Export to Excel</button>
                                    </form>
                                    <form action="{{ route('reports.export.pdflab') }}" method="GET" style="display: inline-block;">
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

<script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
<script>
    const ctx = document.getElementById('myChart4');
    new Chart(ctx, {
        type: 'pie',
        data: {
            //DATA 01 - 31
        labels: @json($datagrouptest),
        datasets: [
        {
            label: 'Test Group Chart',
            data: @json($dataquantity),
            // data: [300, 50, 100],
            tension: 0.4,
            borderWidth: 5,
            backgroundColor: [
            'rgb(56, 0, 177)',
            'rgb(252, 84, 75)',
            'rgb(255, 164, 38)',
            'rgb(71, 195, 99)'
            ],
    hoverOffset: 4
        },
        ]
        },
        options: {
            responsive: true,
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
    </script>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-chartjs.js') }}"></script>

@endpush

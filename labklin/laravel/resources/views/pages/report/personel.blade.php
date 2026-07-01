@extends('layouts.app')

@section('title', 'Report Personel')

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
            <h1>Report Personel</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Report</a></div>
                <div class="breadcrumb-item">Personel</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            {{-- FORM --}}
            <form action="{{ route('report.personel') }}" method="GET">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Filter Report</h2>
                                <div class="form-group">
                                    <label for="month">Select Month</label>
                                    <input class="form-control" type="month" id="month" name="month" value="{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}">
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Filter Personel</h2>
                                <div class="form-group">
                                    <label for="month">Select Personel</label>
                                    @if (Auth::user()->role == 'admin')
                                    <select class="form-control" name="personel" id="personel" required>
                                        <option value="">- Select -</option>
                                        @foreach ($personels as $personel)
                                            <option value="{{ $personel->handler }}">{{ $personel->handler }}</option>
                                        @endforeach
                                    </select>
                                    @else
                                    <select class="form-control" name="personel" id="personel" required>
                                        <option value="">- Select -</option>
                                        <option value="{{ Auth::user()->name }}">{{ Auth::user()->name }}</option>
                                    </select>
                                    @endif
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group mb-0">
                                <div class="text-right">
                                <button class="btn btn-primary" type="submit">Generate Report</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            {{-- END FORM --}}
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Personel Report</h2>
                            {{-- LIST --}}
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Total Visit Service</b>
                                    <span class="badge badge-success badge-pill">{{ $sales->count() }} Patient</span>
                                </div>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                @php
                                    $charge = number_format($totalCharge,0,',','.');
                                @endphp
                                <b>Total Revenue Collected</b>
                                <span class="badge badge-success badge-pill">Rp. {{ $charge }}</span>
                            </div>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Total Specimen Collection</b>
                                    <span class="badge badge-success badge-pill">{{ $collection }} Patient</span>
                                </div>
                            </div>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Total Specimen Receive</b>
                                    <span class="badge badge-success badge-pill">{{ $receive }} Patient</span>
                                </div>
                            </div>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Total Test Completed</b>
                                    <span class="badge badge-success badge-pill">{{ $tester }} Test</span>
                                </div>
                            </div>
                            <div class="list-group">
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <b>Total Result Validated</b>
                                    <span class="badge badge-success badge-pill">{{ $validated }} Result</span>
                                </div>
                            </div>
                            {{-- END LIST --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

@endpush

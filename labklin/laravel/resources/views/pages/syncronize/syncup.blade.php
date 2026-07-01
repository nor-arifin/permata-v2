@extends('layouts.app')

@section('title', 'Database Syncronize')

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
            <h1>Database Syncronize</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Database</a></div>
                <div class="breadcrumb-item">Syncronize to Cloud</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            {{-- FORM --}}
            <form action="{{ route('merge.syncup') }}" method="GET">
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Database Syncronize</h2>
                                <div class="form-group">
                                    <label for="month">Date</label>
                                    <input class="form-control" type="date" id="date" name="date" required>
                                </div>
                                <div class="form-group">
                                    <label for="month">Select Table</label>
                                    @if (Auth::user()->role == 'admin')
                                    <select class="form-control" name="table" id="table" required>
                                        <option value="">- Select -</option>
                                        <option value="visits">Visits</option>
                                        <option value="services_detail">Service</option>
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
                            <h2 class="section-title">Syncronize Description</h2>
                            <div>
                                <p>The data synchronization process will transfer and align data <b>from the local system to the cloud</b>. The data to be synchronized includes all data created or modified in the local system. Please ensure that all data has been verified before proceeding with the synchronization process.</p>
                                <p><b>Terms and Conditions:</b></p>
                                <p>
                                    <li>The data synchronization process will transfer and align data <b>from the local system to the cloud</b>.</li>
                                    <li>During the synchronization process, certain system functions may be unavailable. The process is expected to be completed within 5 minutes.</li>
                                    <li>Before proceeding, please ensure that all data has been verified or backupped.</li>
                                    <li>The user agrees that all risks related to the synchronization process, including data errors, data loss, or any delays that may occur during the process, are the user's responsibility.</li>
                                    <li>After clicking the button "Syncronize to Cloud", the process will start and cannot be terminated. The data will be transferred and aligned to the cloud. Please do not close the browser or tab until the process is complete.</li>
                                </p>
                            </div>
                            <h2 class="section-title">Syncronize Confirmation</h2>
                            <div class="form-group mb-0">
                                <input type="checkbox" name="agree" id="agree" required>
                                <label for="agree">I agree with the terms and conditions</label>
                            </div>
                            <div class="form-group mb-0">
                                <div class="text-right">
                                <button class="btn btn-primary" type="submit">Syncronize to Cloud</button>
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

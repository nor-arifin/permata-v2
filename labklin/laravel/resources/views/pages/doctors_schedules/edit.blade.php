@extends('layouts.app')

@section('title', 'Form Doctor Schedule')

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
            <h1>Edit Forms</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Doctor Schedules</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form action="{{ route('doctor-schedules.update', $sch) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h4>Edit Doctor Schedule</h4>
                            </div>
                            <div class="card-body">
                                @foreach ($doctorschedules as $schedule)
                                <div class="form-group">
                                    <label>Doctor Name</label>
                                    <input type="text" placeholder="{{ $schedule->doctor->doctor_name }}" class="form-control" readonly>
                                </div>
                                {{-- DAY --}}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label>Day</label>
                                        <input type="text" name="monday" value="Monday" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Start Time</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="start_time" value="{{ $schedule->start_time }}" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>End Time</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="end_time" value="{{ $schedule->end_time }}"  class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            @if ($schedule->status == 'active')
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                            @elseif ($schedule->status == 'inactive')
                                            <option value="inactive" selected>InActive</option>
                                            <option value="active">Active</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{-- END DAY --}}
                                <div class="form-group">
                                    <div class="alert alert-info">
                                        <b>Note!</b> If status is inactive, then doctor will not be available on that day and time.
                                    </div>
                                </div>
                                @endforeach
                                <div class="form-group">
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')

<script src="{{ asset('library/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>
@endpush

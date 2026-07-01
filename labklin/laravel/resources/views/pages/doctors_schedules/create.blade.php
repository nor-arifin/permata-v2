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
            <h1>Form Doctor Schedule</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Doctor Schedules</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <form action="{{ route('doctor-schedules.store') }}" method="POST">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>New Doctor Schedule</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Doctor Name</label>
                                    <select name="doctor_id" class="form-control selectric @error('doctor_id')
                                    is-invalid @enderror" required>
                                        <option value="">- Select Doctor -</option>
                                        @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">{{ $doctor->doctor_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                {{-- MONDAY --}}
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
                                            <input type="text" name="monday_start" class="form-control timepicker">
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
                                            <input type="text" name="monday_end" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label>Status</label>
                                        <select name="monday_status" class="form-control">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- END MONDAY --}}
                                {{-- TUESDAY --}}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="text" name="tuesday" value="Tuesday" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="tuesday_start" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="tuesday_end" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="tuesday_status" class="form-control">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- END TUESDAY --}}
                                {{-- WEDNESDAY --}}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="text" name="wednesday" value="Wednesday" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="wednesday_start" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="wednesday_end" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="wednesday_status" class="form-control">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- END WEDNESDAY --}}
                                {{-- THURSDAY --}}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="text" name="thursday" value="Thursday" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="thursday_start" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="thursday_end" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="thursday_status" class="form-control">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- END THURSDAY --}}
                                {{-- FRIDAY --}}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="text" name="friday" value="Friday" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="friday_start" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="friday_end" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="friday_status" class="form-control">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- END FRIDAY --}}
                                {{-- SATURDAY --}}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="text" name="saturday" value="Saturday" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="saturday_start" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="saturday_end" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="saturday_status" class="form-control">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- END SATURDAY --}}
                                {{-- SUNDAY --}}
                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <input type="text" name="sunday" value="Sunday" class="form-control" readonly>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="sunday_start" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-clock"></i>
                                                </div>
                                            </div>
                                            <input type="text" name="sunday_end" class="form-control timepicker">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <select name="sunday_status" class="form-control">
                                            <option value="active" selected>Active</option>
                                            <option value="inactive">InActive</option>
                                        </select>
                                    </div>
                                </div>
                                {{-- END SUNDAY --}}
                                <div class="form-group">
                                    <div class="alert alert-info">
                                        <b>Note!</b> If status is inactive, then doctor will not be available on that day and time. System will not saving record if status is inactive.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Submit</button>
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

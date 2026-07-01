@extends('layouts.app')

@section('title', 'Edit User')

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
                <div class="breadcrumb-item">Doctors</div>
            </div>
        </div>
        <div class="section-body">
            {{-- HEADER PROFIL DOCTOR --}}
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            @if ($doctor->doctor_photo == null)
                            <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" width="100px" height="100px"
                                class="rounded-circle profile-widget-picture">
                            @else
                            <img alt="image" src="{{ asset($doctor->doctor_photo) }}" width="100px" height="100px"
                                class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                @endif

                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Posts</div>
                                    <div class="profile-widget-item-value">187</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Followers</div>
                                    <div class="profile-widget-item-value">6,8K</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Following</div>
                                    <div class="profile-widget-item-value">2,1K</div>
                                </div>
                            </div>
                        </div>
                        <div class="profile-widget-description">
                            <div class="profile-widget-name">dr. {{ $doctor->doctor_name }} <div
                                    class="text-muted d-inline font-weight-normal">
                                    <div class="slash"></div> {{ $doctor->doctor_speciality }}
                                </div>
                            </div>
                            dr. {{ $doctor->doctor_name }} is a doctor name in <b>Indonesia</b>, specility in
                            {{ $doctor->doctor_speciality }}.
                        </div>
                    </div>
                </div>
            </div>
            {{-- FORM EDIT --}}
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <form action="{{ route('doctors.update', $doctor) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card">
                            <div class="card-header">
                                <h4>Primary Data Doctor</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Doctor Name</label>
                                    <input type="text" class="form-control @error('doctor_name')
                                    is-invalid
                                @enderror" name="doctor_name" value="{{ $doctor->doctor_name }}">
                                    @error('doctor_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Birthdate</label>
                                    <input type="text" class="form-control datepicker @error('doctor_birthdate')
                                    is-invalid
                                @enderror" name="doctor_birthdate" value="{{ $doctor->doctor_birthdate }}">
                                    @error('doctor_birthdate')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text" class="form-control @error('doctor_nik')
                                    is-invalid
                                @enderror" name="doctor_nik" value="{{ $doctor->doctor_nik }}">
                                    @error('doctor_nik')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Gender</label>
                                    <div class="selectgroup w-100">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="doctor_gender" value="male"
                                                class="selectgroup-input" @if ($doctor->doctor_gender == 'male') checked
                                            @endif>
                                            <span class="selectgroup-button">Male</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="doctor_gender" value="female"
                                                class="selectgroup-input" @if ($doctor->doctor_gender == 'female')
                                            checked
                                            @endif>
                                            <span class="selectgroup-button">Female</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Doctor ID</label>
                                    <input type="text" class="form-control" name="doctor_id"
                                        value="{{ $doctor->doctor_id }}">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="col-12 col-md-6 col-lg-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Advanced Data Doctor</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control @error('doctor_email')
                                is-invalid
                            @enderror" name="doctor_email" value="{{ $doctor->doctor_email }}">
                                @error('doctor_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="number" class="form-control @error('doctor_phone')
                                is-invalid
                            @enderror" name="doctor_phone" value="{{ $doctor->doctor_phone }}">
                                @error('doctor_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>SIP Number</label>
                                <input type="text" class="form-control @error('doctor_sip')
                                is-invalid
                            @enderror" name="doctor_sip" value="{{ $doctor->doctor_sip }}">
                                @error('doctor_sip')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Speciality</label>
                                <input type="text" class="form-control @error('doctor_speciality')
                                is-invalid
                            @enderror" name="doctor_speciality" value="{{ $doctor->doctor_speciality }}">
                                @error('doctor_speciality')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Doctor Photo</label>
                                <input type="file" class="form-control" name="doctor_photo" @error('doctor_photo')
                                    is-invalid @enderror>
                                @error('doctor_photo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Update</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection

@push('scripts')
@endpush

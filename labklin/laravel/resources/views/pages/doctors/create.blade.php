@extends('layouts.app')

@section('title', 'Form Doctor')

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
            <h1>Form Doctors</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Doctor</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-6">
                    <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <h4>Primary Data Doctor</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Doctor Name</label>
                                    <input type="text" class="form-control @error('doctor_name')
                                is-invalid
                            @enderror" name="doctor_name" id="doctor_name" value="{{ old('doctor_name') }}" required>
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
                            @enderror" name="doctor_birthdate" value="{{ old('doctor_birthdate') }}" required>
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
                            @enderror" name="doctor_nik" id="doctor_nik" value="{{ old('doctor_nik') }}" required>
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
                                                class="selectgroup-input" {{ old("doctor_gender") == 'male' ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Male</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="doctor_gender" value="female" {{ old("doctor_gender") == 'female' ? 'checked' : '' }}
                                                class="selectgroup-input">
                                            <span class="selectgroup-button">Female</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label id="doctor_label" style="display: block">Doctor ID</label>
                                    <label id="doctor_found" class="text-black text-success" style="display: none">Doctor ID Found</label>
                                    <label id="doctor_notfound" class="text-black text-danger" style="display: none">Doctor ID Not Found</label>
                                    <input type="text" class="form-control" name="doctor_id" id="doctor_id" readonly>
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
                        @enderror" name="doctor_email" value="{{ old('doctor_email') }}">
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
                        @enderror" name="doctor_phone" value="{{ old('doctor_phone') }}" required>
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
                        @enderror" name="doctor_sip" value="{{ old('doctor_sip') }}">
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
                        @enderror" name="doctor_speciality" value="{{ old('doctor_speciality') }}">
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
                                <button class="btn btn-primary">Submit</button>
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

{{-- SCRIPT IHS STATUS --}}
<script>
    $(document).ready(function() {
        $('#doctor_nik').on('change', function(){
            var nik = $(this).val();
            $.ajax({
            url: '/doctorbynik/'+nik,
            type: 'GET',
            dataType: 'json',
            success: function (data)
            {
                console.log(data);
                if(data[1].total == 1 ){ //CEK APAKAH DATA RESOURCE ADA, cek console.log
                    $('#doctor_id').val(data[1].entry[0].resource.id);
                    $('#doctor_name').val(data[1].entry[0].resource.name[0].text);
                    document.getElementById('doctor_label').style.display = 'none';
                    document.getElementById('doctor_found').style.display = 'block';
                    document.getElementById('doctor_notfound').style.display = 'none';
                    console.log(data);
                } else { //JIKA TIDAK ADA TAMPILKAN BERIKUT
                    $('#doctor_id').val("");
                    $('#doctor_name').val("");
                    document.getElementById('doctor_label').style.display = 'none';
                    document.getElementById('doctor_found').style.display = 'none';
                    document.getElementById('doctor_notfound').style.display = 'block';
                };
            }
            });
        });
    });
</script>

<script src="{{ asset('library/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
{{-- <script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script> --}}
@endpush

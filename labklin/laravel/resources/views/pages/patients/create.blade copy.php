@extends('layouts.app')

@section('title', 'Form Patient')

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
            <h1>Form Patient</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Patients</div>
            </div>
        </div>
        <div class="section-body">
            <form action="{{ route('patients.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>New Patient Registration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Medical Record ID</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control @error('patient_mr')
                                    is-invalid
                                @enderror" name="patient_mr" value="{{ $autorm }}" placeholder="Medical Record Number" readonly required>
                                @error('patient_mr')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-6 mt-0">
                                <div class="form-text text-muted">Medical Record Number is autogenerate from system and must be unique with 6 digits number.</div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">NIK (ID Number)</label>
                            <div class="col-sm-4 mt-2">
                                <input type="text" class="form-control @error('patient_nik')
                                    is-invalid
                                @enderror" name="patient_nik" id="patient_nik" placeholder="Patient NIK Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')" minlength="16" maxlength="16" required>
                                @error('patient_nik')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="text" class="form-control" name="patient_ihs" id="patient_ihs" placeholder="SATUSEHAT ID">
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="hidden" id="patient_status_value" name="patient_status">
                                <div id="patient_status_success" class="text-black text-success"></div>
                                <div id="patient_status_error" class="text-black text-danger"></div>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <button type="button" id="validate" class="btn btn-md btn-primary">
                                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                                    Validate NIK
                                </button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Full Name</label>
                            <div class="col-sm-2 mt-2">
                                <select class="form-control" name="patient_title" required>
                                    <option value="">- Title -</option>
                                    <option value="Mr">Mr.</option>
                                    <option value="Mrs">Mrs.</option>
                                    <option value="Miss">Miss.</option>
                                    <option value="By">Baby.</option>
                                </select>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control @error('patient_name')
                                    is-invalid
                                @enderror" name="patient_name" id="patient_name" placeholder="Patient Name" required>
                                @error('patient_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label mt-2">Gender</label>
                            <div class="col-sm-2 mt-2">
                                <select class="form-control" name="patient_gender" required>
                                    <option value="">- Gender -</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Place and Date of Birth</label>
                            <div class="col-sm-4 mt-2">
                                <input type="text" class="form-control @error('patient_birthplace')
                                    is-invalid
                                @enderror" name="patient_birthplace" placeholder="Birth Place" onkeyup="this.value = this.value.toUpperCase();" required>
                                @error('patient_birthplace')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="date" class="form-control @error('patient_birthdate')
                                    is-invalid
                                @enderror" name="patient_birthdate" id="patient_birthdate"  placeholder="Birth Date" required>
                                @error('patient_birthdate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="input-group col-sm-2 mt-2">
                                <input type="text" class="form-control phone-number" name="umur" id="umur" readonly>

                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        Year
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Address</label>
                            <div class="col-sm-10 mt-2">
                                <textarea class="form-control" name="patient_address_line" placeholder="Address" onkeyup="this.value = this.value.toUpperCase();" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2"></label>
                            <div class="col-sm-2 mt-2">
                                <select name="patient_code_province" class="form-control" id="provinsi" required>
                                    <option value="">- Select Province -</option>
                                    @foreach ($provinsi as $item)
                                        <option value="{{ $item->code ?? '' }}">{{ $item->name ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <select name="patient_code_city" class="form-control" id="kota" required>
                                    <option value="">- Select City -</option>
                                    <option value="">Select Province First</option>
                                </select>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <select name="patient_code_district" class="form-control" id="kecamatan" required>
                                    <option value="">- Select District -</option>
                                    <option value="">Select City First</option>
                                </select>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <select name="patient_code_village" class="form-control" id="kelurahan" required>
                                    <option value="">- Select Village -</option>
                                    <option value="">Select District First</option>
                                </select>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="text" class="form-control" name="patient_address_extension" placeholder="Reg. Code" id="kodewilayah" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Phone</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control @error('patient_telecom')
                                    is-invalid
                                @enderror" name="patient_telecom" placeholder="Phone Number"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')" minlength="9" maxlength="13" required>
                                @error('patient_telecom')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label mt-2">Email</label>
                            <div class="col-sm-4">
                                <input type="mail" class="form-control @error('patient_email')
                                    is-invalid
                                @enderror" name="patient_email" placeholder="active@mail.com">
                                @error('patient_email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Religion</label>
                            <div class="col-sm-4 mt-2">
                                <select class="form-control" name="patient_religion" required>
                                    <option value="">- Select -</option>
                                    <option value="Islam">Islam</option>
                                    <option value="Kristen">Kristen</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Buddha">Buddha</option>
                                    <option value="Konghucu">Konghucu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label mt-2">Blood Type</label>
                            <div class="col-sm-4 mt-2">
                                <select class="form-control" name="patient_bloodtype" required>
                                    <option value="">- Select -</option>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="-">Tidak Diketahui</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Profession</label>
                            <div class="col-sm-4 mt-2">
                                <select class="form-control" name="patient_profession" required>
                                    <option value="">- Select -</option>
                                    <option value="Karyawan Swasta">Karyawan Swasta</option>
                                    <option value="Karyawan BUMN">Karyawan BUMN</option>
                                    <option value="Pegawai Negeri Sipil (ASN)">Pegawai Negeri Sipil (ASN)</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                    <option value="Tenaga Kesehatan">Tenaga Kesehatan</option>
                                    <option value="Tenaga Pengajar">Tenaga Pengajar</option>
                                    <option value="TNI">TNI</option>
                                    <option value="Polisi">Polisi</option>
                                    <option value="Security/Satpam">Security/Satpam</option>
                                    <option value="Pelajar/Mahasiswa">Pelajar/Mahasiswa</option>
                                    <option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
                                    <option value="Petani">Petani</option>
                                    <option value="Peternak">Peternak</option>
                                    <option value="Nelayan">Nelayan</option>
                                    <option value="Transportasi">Transportasi</option>
                                    <option value="Buruh Harian Lepas">Buruh Harian Lepas</option>
                                    <option value="Seniman">Seniman</option>
                                    <option value="Tokoh Agama">Tokoh Agama</option>
                                    <option value="Belum/Tidak Bekerja">Belum/Tidak Bekerja</option>
                                    <option value="Pensiunan">Pensiunan</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <label class="col-sm-2 col-form-label mt-2">Marital Status</label>
                            <div class="col-sm-4 mt-2">
                                <select class="form-control" name="patient_marital_status" required>
                                    <option value="">- Select -</option>
                                    <option value="S">Single</option>
                                    <option value="M">Married</option>
                                    <option value="D">Divorced</option>
                                    <option value="W">Widow</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-header" id="patient_companion_title" style="display: none">
                        <h4>Patient Companion</h4>
                    </div>
                    <div class="card-header" id="patient_companion_subtitle" style="display: none">
                        <h10>Name and Phone of Patient Companion must be filled if patient is less than 17 years old.</h10>
                    </div>
                    <div class="card-body" id="patient_companion_form" style="display: none">
                        {{-- PATIENT COMPANION --}}
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Name</label>
                            <div class="col-sm-4 mt-2">
                                <input type="text" class="form-control @error('patient_relationship_name')
                                    is-invalid
                                @enderror" name="patient_relationship_name" placeholder="Full Name">
                                @error('patient_relationship_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <label class="col-sm-2 col-form-label mt-2">Phone</label>
                            <div class="col-sm-4 mt-2">
                                <input type="text" class="form-control @error('patient_relationship_phone')
                                    is-invalid
                                @enderror" name="patient_relationship_phone" placeholder="Phone Number">
                                @error('patient_relationship_phone')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- INPUTAN HIDDEN --}}
                    </div>
                    <input type="hidden" name="patient_address_city" id="patient_address_city">
                    <input type="hidden" name="patient_identifier" value="nik">
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@push('scripts')
{{-- SCRIPT IHS STATUS --}}
<script>
    $(document).ready(function() {
        $('#validate').click(function(){
            var nik = $('#patient_nik').val();
            $.ajax({
            url: '/getbyid/'+nik,
            type: 'GET',
            dataType: 'json',
            success: function (data)
            {
                if(data.total == 1 ){ //CEK APAKAH DATA RESOURCE ADA, cek console.log
                    $('#patient_status_value').val("active");
                    $('#patient_ihs').val(data.entry[0].resource.id);
                    // $('#patient_name').val(data.entry[0].resource.name[0].text);
                    document.getElementById("patient_status_success").textContent = "IHS Data Successfully Validated";
                    document.getElementById('validate').style.display = 'none';
                    // console.log(data);
                } else { //JIKA TIDAK ADA TAMPILKAN BERIKUT
                    $('#patient_status_value').val("inactive");
                    document.getElementById("patient_status_error").textContent = "NIK Not Found on IHS Data.";
                    $('#patient_ihs').val("0");
                    // console.log(data);
                };
            }
            });
        });
    });
</script>
{{-- SCRIPT GET AGE FROM PATIENT BIRTHDATE ONCHANGE--}}
<script>
$(document).ready(function()
    {
        $('#patient_birthdate').change(function()
        {
            console.log("change");
            var dob = new Date(document.getElementById('patient_birthdate').value);
            var today = new Date();
            var age = Math.floor((today-dob)/(365.25*24*60*60*1000));
            if(age < 0) {
                umur = age * 0;
            }else{
                umur = age;
            }
            document.getElementById('umur').value = umur;
            if(umur < 17){
                document.getElementById('patient_companion_title').style.display = 'block';
                document.getElementById('patient_companion_subtitle').style.display = 'block';
                document.getElementById('patient_companion_form').style.display = 'block';
            }else{
                document.getElementById('patient_companion_title').style.display = 'none';
                document.getElementById('patient_companion_subtitle').style.display = 'none';
                document.getElementById('patient_companion_form').style.display = 'none';
            }
        });
    });
</script>
{{-- SCRIPT GET KOTA --}}
<script>
    $(document).ready(function() {
    $('#provinsi').on('change', function() {
    var categoryID = $(this).val();
    if(categoryID) {
        $.ajax({
            url: '/getKota/'+categoryID,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data)
            {
                if(data){
                    $('#kota').empty();
                    $('#kota').append('<option hidden>- Select City -</option>');
                    $.each(data, function(code, kota){
                        $('select[name="patient_code_city"]').append('<option value="'+ kota.code +'">' + kota.name + '</option>');
                    });
                }else{
                    $('#kota').empty();
                }
            }
        });
    }else{
        $('#kota').empty();
    }
    });
    });
</script>
{{-- SCRIPT GET KECAMATAN --}}
<script>
    $(document).ready(function() {
    $('#kota').on('change', function() {
    var categoryID2 = $(this).val();
    if(categoryID2) {
        $.ajax({
            url: '/getKec/'+categoryID2,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data)
            {
                if(data){
                    $('#kecamatan').empty();
                    $('#kecamatan').append('<option hidden>- Select District -</option>');
                    $.each(data, function(code, kecamatan){
                        $('select[name="patient_code_district"]').append('<option value="'+ kecamatan.code +'">' + kecamatan.name + '</option>');
                    });
                }else{
                    $('#kecamatan').empty();
                }
            }
        });
    }else{
        $('#kecamatan').empty();
    }
    });
    });
</script>
{{-- SCRIPT GET KELURAHAN / DESA --}}
<script>
    $(document).ready(function() {
    $('#kecamatan').on('change', function() {
    var categoryID3 = $(this).val();
    if(categoryID3) {
        $.ajax({
            url: '/getKel/'+categoryID3,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data)
            {
                if(data){
                    $('#kelurahan').empty();
                    $('#kelurahan').append('<option hidden>- Select Village -</option>');
                    $.each(data, function(code, kelurahan){
                        $('select[name="patient_code_village"]').append('<option value="'+ kelurahan.code +'">' + kelurahan.name + '</option>');
                    });
                }else{
                    $('#kelurahan').empty();
                }
            }
        });
    }else{
        $('#kelurahan').empty();
    }
    });
    });
</script>
{{-- SCRIPT GET KODE --}}
<script>
    $(document).ready(function() {
    $('#kelurahan').on('change', function() {
    var categoryID4 = $(this).val();
    if(categoryID4) {
        $.ajax({
            url: '/getKode/'+categoryID4,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data)
            {
                if(data){
                    $('#kodewilayah').empty();
                    $.each(data, function(code, kodewilayah){
                    document.getElementById('kodewilayah').value = kodewilayah.code;
                    });
                }else{
                    $('#kodewilayah').empty();
                }
            }
        });
    }else{
        $('#kodewilayah').empty();
    }
    });
    });
</script>
{{-- SCRIPT GET NAME --}}
<script>
    $(document).ready(function() {
    $('#kota').on('change', function() {
    var categoryID5 = $(this).val();
    if(categoryID5) {
        $.ajax({
            url: '/getnamakota/'+categoryID5,
            type: "GET",
            data : {"_token":"{{ csrf_token() }}"},
            dataType: "json",
            success:function(data)
            {
                if(data){
                    $('#patient_address_city').empty();
                    $.each(data, function(code, patient_address_city){
                    document.getElementById('patient_address_city').value = patient_address_city.name;
                    });
                }else{
                    $('#patient_address_city').empty();
                }
            }
        });
    }else{
        $('#patient_address_city').empty();
    }
    });
    });
</script>
@endpush


@extends('layouts.app')

@section('title', 'Form Customer')

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
                <h1>Form Customer</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Customers</div>
                </div>
            </div>
            <div class="section-body">
                <form action="{{ route('customers.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>New Customer Registration</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label">Customer Code ID</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('customer_code')
                                        is-invalid
                                    @enderror" name="customer_code" value="{{ $autoid }}" placeholder="Customer Code"
                                        readonly required>
                                    @error('customer_code')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-6 mt-0">
                                    <div class="form-text text-muted">Customer Code is autogenerate from system.</div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Customer Name</label>
                                <div class="col-sm-2 mt-2">
                                    <select class="form-control" name="customer_type" value="{{ old('customer_type') }}"
                                        required>
                                        <option value="">- Type -</option>
                                        <option value="RSD">RS Daerah</option>
                                        <option value="RSS">RS Swasta</option>
                                        <option value="LAB">Laboratorium</option>
                                        <option value="Pemerintah">Pemerintah</option>
                                        <option value="PT.">PT.</option>
                                        <option value="CV.">CV.</option>
                                        <option value="Umum">Umum</option>
                                        <option value="Other">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-sm-8 mt-2">
                                    <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control @error('customer_name')
                                        is-invalid
                                    @enderror" name="customer_name" value="{{ old('customer_name') }}"
                                        id="customer_name" placeholder="Customer Name" required>
                                    @error('customer_name')
                                        <div class=" invalid-feedback" maxlength="50">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Address</label>
                                <div class="col-sm-10 mt-2">
                                    <input type="text" class="form-control" name="customer_address"
                                        value="{{ old('customer_address') }}" placeholder="Address"
                                        onkeyup="this.value = this.value.toUpperCase();" maxlength="50" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Kode Wilayah</label>
                                <div class="col-sm-2 mt-2">
                                    <select name="customer_province" value="{{ old('customer_province') }}"
                                        class="form-control" id="provinsi">
                                        <option value="">- Select Province -</option>
                                        @foreach($provinsi as $item)
                                            <option value="{{ $item->code ?? '' }}">
                                                {{ $item->name ?? '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <select name="customer_city" value="{{ old('customer_city') }}" class="form-control"
                                        id="kota" required>
                                        <option value="">- Select City -</option>
                                        <option value="">Select Province First</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <select name="customer_district" value="{{ old('customer_district') }}"
                                        class="form-control" id="kecamatan" required>
                                        <option value="">- Select District -</option>
                                        <option value="">Select City First</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <select name="customer_village" value="{{ old('customer_village') }}"
                                        class="form-control" id="kelurahan" required>
                                        <option value="">- Select Village -</option>
                                        <option value="">Select District First</option>
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <input type="text" class="form-control" id="customer_address_detail"
                                        name="customer_address_detail" value="{{ old('customer_address_detail') }}"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                        required readonly>
                                    </input>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Phone</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('customer_phone')
                                        is-invalid
                                    @enderror" name="customer_phone" value="{{ old('customer_phone') }}"
                                        placeholder="Phone Number"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                        minlength="9" maxlength="13" required>
                                    @error('customer_phone')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">Email</label>
                                <div class="col-sm-4">
                                    <input type="mail" class="form-control @error('customer_email')
                                        is-invalid
                                    @enderror" name="customer_email" value="{{ old('customer_email') }}"
                                        placeholder="active@mail.com">
                                    @error('customer_email')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">PIC</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('customer_pic')
                                        is-invalid
                                    @enderror" name="customer_pic" onkeyup="this.value = this.value.toUpperCase();"
                                        value="{{ old('customer_pic') }}" placeholder="PIC Name">
                                    @error('customer_pic')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">PIC NIK</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('customer_pic_nik')
                                        is-invalid
                                    @enderror" name="customer_pic_nik" value="{{ old('customer_pic_nik') }}"
                                        placeholder="PIC NIK"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                        minlength="16" maxlength="16" required>
                                    @error('customer_pic_nik')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">PIC Position</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('customer_pic_position')
                                        is-invalid
                                    @enderror" name="customer_pic_position" value="{{ old('customer_pic_position') }}"
                                        placeholder="Staff / Supervisor / Manager / Direktur" required>
                                    @error('customer_pic_position')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">PIC Phone</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('customer_pic_phone')
                                        is-invalid
                                    @enderror" name="customer_pic_phone" value="{{ old('customer_pic_phone') }}"
                                        placeholder="PIC Phone Number"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                        minlength="9" maxlength="13" required>
                                    @error('customer_pic_phone')
                                        <div class=" invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
    {{-- SCRIPT GET KOTA --}}
    <script>
        $(document).ready(function () {
            $('#provinsi').on('change', function () {
                var categoryID = $(this).val();
                if (categoryID) {
                    $.ajax({
                        url: '/getKota/' + categoryID,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                $('#kota').empty();
                                $('#kota').append(
                                    '<option hidden>- Select City -</option>');
                                $.each(data, function (code, kota) {
                                    $('select[name="customer_city"]').append(
                                        '<option value="' + kota.code + '">' +
                                        kota.name + '</option>');
                                });
                            } else {
                                $('#kota').empty();
                            }
                        }
                    });
                } else {
                    $('#kota').empty();
                }
            });
        });
    </script>
    {{-- SCRIPT GET KECAMATAN --}}
    <script>
        $(document).ready(function () {
            $('#kota').on('change', function () {
                var categoryID2 = $(this).val();
                if (categoryID2) {
                    $.ajax({
                        url: '/getKec/' + categoryID2,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                $('#kecamatan').empty();
                                $('#kecamatan').append(
                                    '<option hidden>- Select District -</option>');
                                $.each(data, function (code, kecamatan) {
                                    $('select[name="customer_district"]')
                                        .append('<option value="' + kecamatan.code +
                                            '">' + kecamatan.name + '</option>');
                                });
                            } else {
                                $('#kecamatan').empty();
                            }
                        }
                    });
                } else {
                    $('#kecamatan').empty();
                }
            });
        });
    </script>
    {{-- SCRIPT GET KELURAHAN / DESA --}}
    <script>
        $(document).ready(function () {
            $('#kecamatan').on('change', function () {
                var categoryID3 = $(this).val();
                if (categoryID3) {
                    $.ajax({
                        url: '/getKel/' + categoryID3,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                $('#kelurahan').empty();
                                $('#kelurahan').append(
                                    '<option hidden>- Select Village -</option>');
                                $.each(data, function (code, kelurahan) {
                                    $('select[name="customer_village"]').append(
                                        '<option value="' + kelurahan.code +
                                        '">' + kelurahan.name + '</option>');
                                });
                            } else {
                                $('#kelurahan').empty();
                            }
                        }
                    });
                } else {
                    $('#kelurahan').empty();
                }
            });
        });
    </script>
    {{-- SCRIPT GET KODE --}}
    <script>
        $(document).ready(function () {
            $('#kelurahan').on('change', function () {
                var categoryID4 = $(this).val();
                if (categoryID4) {
                    $.ajax({
                        url: '/getKode/' + categoryID4,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                $('#customer_address_detail').empty();
                                $.each(data, function (code, kodewilayah) {
                                    document.getElementById('customer_address_detail')
                                        .value =
                                        kodewilayah.code;
                                });
                                console.log(data);
                            } else {
                                $('#customer_address_detail').empty();
                            }
                        }
                    });
                } else {
                    $('#customer_address_detail').empty();
                }
            });
        });
    </script>
    <!-- SCRIPT GET customer_address_detail -->
@endpush
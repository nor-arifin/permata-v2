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
            <div class="section-body"></div>
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Customer</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Customer Code ID</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control @error('customer_code')
                                    is-invalid
                                @enderror" name="customer_code" value="{{ $customer->customer_code }}"
                                    placeholder="Customer Code" readonly required>
                                @error('customer_code')
                                    <div class=" invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-sm-4 mt-0">
                                <div class="form-text text-muted">Customer Code is not editable.</div>
                            </div>
                            <div class="col-sm-2 mt-0">
                                <select class="form-control" name="customer_status" required>
                                    <option value="">- Status -</option>
                                    <option value="active" {{ $customer->customer_status == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" {{ $customer->customer_status == 'inactive' ? 'selected' : '' }}>
                                        InActive
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Customer Name</label>
                            <div class="col-sm-2 mt-2">
                                <select class="form-control" name="customer_type" required>
                                    <option value="">- Type -</option>
                                    <option value="RSD" {{ $customer->customer_type == 'RSD' ? 'selected' : '' }}>RS Daerah
                                    </option>
                                    <option value="RSS" {{ $customer->customer_type == 'RSS' ? 'selected' : '' }}>RS Swasta
                                    </option>
                                    <option value="LAB" {{ $customer->customer_type == 'LAB' ? 'selected' : '' }}>
                                        Laboratorium
                                    </option>
                                    <option value="Pemerintah" {{ $customer->customer_type == 'Pemerintah' ? 'selected' : '' }}>Pemerintah</option>
                                    <option value="PT." {{ $customer->customer_type == 'PT.' ? 'selected' : '' }}>PT.
                                    </option>
                                    <option value="CV." {{ $customer->customer_type == 'CV.' ? 'selected' : '' }}>CV.
                                    </option>
                                    <option value="Umum" {{ $customer->customer_type == 'Umum' ? 'selected' : '' }}>Umum
                                    </option>
                                    <option value="Other" {{ $customer->customer_type == 'Other' ? 'selected' : '' }}>
                                        Lainnya
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-8 mt-2">
                                <input type="text" onkeyup="this.value = this.value.toUpperCase();" class="form-control @error('customer_name')
                                    is-invalid
                                @enderror" name="customer_name" value="{{ $customer->customer_name }}"
                                    id="customer_name" placeholder="Customer Name" maxlength="50" required>
                                @error('customer_name')
                                    <div class=" invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Address</label>
                            <div class="col-sm-10 mt-2">
                                <input type="text" class="form-control" name="customer_address"
                                    value="{{ $customer->customer_address }}" placeholder="Address"
                                    onkeyup="this.value = this.value.toUpperCase();" maxlength="50" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label mt-2">Kode Wilayah</label>
                            <div class="col-sm-2 mt-2">
                                <select name="customer_province" value="{{ old('customer_province') }}" class="form-control"
                                    id="provinsi">
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
                                    id="kota">
                                    <option value="">- Select City -</option>
                                    <option value="">Select Province First</option>
                                </select>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <select name="customer_district" value="{{ old('customer_district') }}" class="form-control"
                                    id="kecamatan">
                                    <option value="">- Select District -</option>
                                    <option value="">Select City First</option>
                                </select>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <select name="customer_village" value="{{ old('customer_village') }}" class="form-control"
                                    id="kelurahan">
                                    <option value="">- Select Village -</option>
                                    <option value="">Select District First</option>
                                </select>
                            </div>
                            <div class="col-sm-2 mt-2">
                                <input type="text" class="form-control" id="customer_address_detail"
                                    name="customer_address_detail" value="{{ $customer->customer_address_detail}}"
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
                                @enderror" name="customer_phone" value="{{ $customer->customer_phone }}"
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
                                @enderror" name="customer_email" value="{{ $customer->customer_email }}"
                                    placeholder="active@mail.com">
                                @error('customer_email')
                                        <div class=" invalid-feedback"></div>
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
                                value="{{ old('customer_pic', $customer->customer_pic) }}" placeholder="PIC Name">
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
                            @enderror" name="customer_pic_nik"
                                value="{{ old('customer_pic_nik', $customer->customer_pic_nik) }}" placeholder="PIC NIK"
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
                            @enderror" name="customer_pic_position"
                                value="{{ old('customer_pic_position', $customer->customer_pic_position) }}"
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
                            @enderror" name="customer_pic_phone"
                                value="{{ old('customer_pic_phone', $customer->customer_pic_phone) }}"
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
    </div>
    <div class="card-footer text-right">
        <button class="btn btn-primary" type="submit">Update</button>
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
@extends('layouts.app')

@section('title', 'Form Profile Clinic')

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
                <h1>Form Clinic</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Clinic</div>
                </div>
            </div>
            <div class="section-body">
                <form action="{{ route('profileclinic.update', $profiles) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-header">
                            <h4>Profile Clinic : {{ $profiles->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Clinic Name</label>
                                <div class="col-sm-10 mt-2">
                                    <input type="text" class="form-control @error('name')
                                        is-invalid
                                    @enderror" name="name" placeholder="Clinic Name" value="{{ $profiles->name }}">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Description</label>
                                <div class="col-sm-10 mt-2">
                                    <input type="text" class="form-control @error('description')
                                        is-invalid
                                    @enderror" name="description" placeholder="Clinic Description"
                                        value="{{ $profiles->description }}">
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Address</label>
                                <div class="col-sm-6 mt-2">
                                    <input type="text" class="form-control" name="address" placeholder="Address"
                                        onkeyup="this.value = this.value.toUpperCase();" value="{{ $profiles->address }}"
                                        required></input>
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <input type="text" class="form-control" name="base_address_city" placeholder="City Name"
                                        id="base_address_city" value="{{ $profiles->base_address_city }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2"></label>
                                <div class="col-sm-2 mt-2">
                                    <select name="base_code_province" class="form-control" id="provinsi" required>
                                        @if ($profiles->base_code_province !== null)
                                            <option value="{{ $profiles->base_code_province }}">{{ $profiles->province_name }}
                                            </option>
                                        @else
                                            <option value="">- Select Province -</option>
                                        @endif
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item->code ?? '' }}">{{ $item->name ?? '' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <select name="base_code_city" class="form-control" id="kota" required>
                                        @if ($profiles->base_code_city !== null)
                                            <option value="{{ $profiles->base_code_city }}">{{ $profiles->city_name }}</option>
                                        @else
                                            <option value="">- Select City -</option>
                                            <option value="">Select Province First</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <select name="base_code_district" class="form-control" id="kecamatan" required>
                                        @if ($profiles->base_code_district !== null)
                                            <option value="{{ $profiles->base_code_district }}">{{ $profiles->district_name }}
                                            </option>
                                        @else
                                            <option value="">- Select District -</option>
                                            <option value="">Select City First</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <select name="base_code_village" class="form-control" id="kelurahan" required>
                                        @if ($profiles->base_code_village !== null)
                                            <option value="{{ $profiles->base_code_village }}">{{ $profiles->village_name }}
                                            </option>
                                        @else
                                            <option value="">- Select Village -</option>
                                            <option value="">Select District First</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <select name="status" class="form-control" required>
                                        <option value="Active" {{ $profiles->status == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Suspended" {{ $profiles->status == 'Suspended' ? 'selected' : '' }}>
                                            Suspended</option>
                                        <option value="Inactive" {{ $profiles->status == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Regional Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="base_address_extension"
                                        value="{{ $profiles->base_address_extension }}" placeholder="Reg. Code"
                                        id="kodewilayah" readonly>
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">Postal Code</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('base_address_postalcode')
                                        is-invalid
                                    @enderror" name="base_address_postalcode"
                                        value="{{ $profiles->base_address_postalcode }}" placeholder="Postal Code"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                        minlength="5" maxlength="5" required>
                                    @error('base_address_postalcode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Logitude Coordinate</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control @error('base_address_longitude')
                                        is-invalid
                                    @enderror" name="base_address_longitude"
                                        value="{{ $profiles->base_address_longitude }}" placeholder="Longitude" required>
                                    @error('base_address_longitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">Latitude Coordinate</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control @error('base_address_latitude')
                                        is-invalid
                                    @enderror" name="base_address_latitude"
                                        value="{{ $profiles->base_address_longitude }}" placeholder="Latitude" required>
                                    @error('base_address_latitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">Altitude Coordinate</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control @error('base_address_altitude')
                                        is-invalid
                                    @enderror" name="base_address_altitude"
                                        value="{{ $profiles->base_address_altitude }}" placeholder="Latitude" required>
                                    @error('base_address_altitude')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Official Phone</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('phone')
                                        is-invalid
                                    @enderror" name="phone" value="{{ $profiles->phone }}"
                                        placeholder="Official Phone Number"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                        minlength="9" maxlength="13" required>
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">Official Email</label>
                                <div class="col-sm-4">
                                    <input type="mail" class="form-control @error('email')
                                        is-invalid
                                    @enderror" name="email" value="{{ $profiles->email }}"
                                        placeholder="official@mail.com">
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Official Website</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('website')
                                        is-invalid
                                    @enderror" name="website" value="{{ $profiles->website }}"
                                        placeholder="www.official.site">
                                    @error('website')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">Contact Person</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control @error('pic')
                                        is-invalid
                                    @enderror" name="pic" value="{{ $profiles->pic }}"
                                        placeholder="Person In Charge Name">
                                    @error('pic')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Upload Logo</label>
                                <div class="col-sm-4">
                                    <input type="file" class="form-control" name="logo" @error('logo') is-invalid @enderror>
                                    @error('logo')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <label class="col-sm-2 col-form-label mt-2">Accreditation</label>
                                <div class="col-sm-4">
                                    <select name="acreditation" class="form-control" required>
                                        @if ($profiles->acreditation !== null)
                                            <option value="{{ $profiles->acreditation }}">{{ $profiles->acreditation }}</option>
                                        @else
                                            <option value="">- Select Acreditation -</option>
                                        @endif
                                        <option value="Pratama">Pratama</option>
                                        <option value="Madya">Madya</option>
                                        <option value="Utama">Utama</option>
                                        <option value="Paripurna">Paripurna</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card-header">
                            <h4>SatuSehat Integration</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Faskes ID</label>
                                <div class="col-sm-10 mt-2">
                                    <input type="text" class="form-control @error('faskes_id')
                                        is-invalid
                                    @enderror" name="faskes_id" placeholder="Organization ID"
                                        value="{{ $profiles->faskes_id }}">
                                    @error('faskes_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">System Environment</label>
                                <div class="col-sm-10 mt-2">
                                    <select name="acreditation" class="form-control" required>
                                        @if ($profiles->environment !== null)
                                            @if($profiles->environment == "DEV")
                                                <option value="{{ $profiles->environment }}">Development</option>
                                            @elseif ($profiles->environment == "STG")
                                                <option value="{{ $profiles->environment }}">Staging</option>
                                            @else
                                                <option value="{{ $profiles->environment }}">Production</option>
                                            @endif
                                        @else
                                            <option value="">- Select System Environment-</option>
                                        @endif
                                        <option value="DEV">Development</option>
                                        <option value="STG">Staging</option>
                                        <option value="PROD">Production</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Organization ID</label>
                                <div class="col-sm-10 mt-2">
                                    <input type="text" class="form-control @error('organization_id')
                                        is-invalid
                                    @enderror" name="organization_id" placeholder="Organization ID"
                                        value="{{ $profiles->organization_id }}">
                                    @error('organization_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Client ID</label>
                                <div class="col-sm-10 mt-2">
                                    <input type="text" class="form-control @error('client_id')
                                        is-invalid
                                    @enderror" name="client_id" placeholder="Client ID"
                                        value="{{ $profiles->client_id }}">
                                    @error('client_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label mt-2">Secret Key</label>
                                <div class="col-sm-10 mt-2">
                                    <input type="text" class="form-control @error('client_secretkey')
                                        is-invalid
                                    @enderror" name="client_secretkey" placeholder="Client Secret Key"
                                        value="{{ $profiles->client_secretkey }}">
                                    @error('client_secretkey')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
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
                                $('#kota').append('<option hidden>- Select City -</option>');
                                $.each(data, function (code, kota) {
                                    $('select[name="base_code_city"]').append(
                                        '<option value="' + kota.code + '">' + kota
                                            .name + '</option>');
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
                                    $('select[name="base_code_district"]').append(
                                        '<option value="' + kecamatan.code + '">' +
                                        kecamatan.name + '</option>');
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
                                    $('select[name="base_code_village"]').append(
                                        '<option value="' + kelurahan.code + '">' +
                                        kelurahan.name + '</option>');
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
                                $('#kodewilayah').empty();
                                $.each(data, function (code, kodewilayah) {
                                    document.getElementById('kodewilayah').value =
                                        kodewilayah.code;
                                });
                            } else {
                                $('#kodewilayah').empty();
                            }
                        }
                    });
                } else {
                    $('#kodewilayah').empty();
                }
            });
        });
    </script>
    {{-- SCRIPT GET NAME --}}
    <script>
        $(document).ready(function () {
            $('#kota').on('change', function () {
                var categoryID5 = $(this).val();
                if (categoryID5) {
                    $.ajax({
                        url: '/getnamakota/' + categoryID5,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                $('#base_address_city').empty();
                                $.each(data, function (code, patient_address_city) {
                                    document.getElementById('base_address_city').value =
                                        patient_address_city.name;
                                });
                            } else {
                                $('#base_address_city').empty();
                            }
                        }
                    });
                } else {
                    $('#base_address_city').empty();
                }
            });
        });
    </script>
@endpush
@extends('layouts.app')

@section('title', 'Form Organization')

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
            <h1>Form Organization</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Organizations</div>
            </div>
        </div>
        <div class="section-body">
            <form action="{{ route('organizations.update', $organization) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4>Update Organization</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Organization Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('organization_code')
                                    is-invalid
                                @enderror" name="organization_code" value="{{ $organization->organization_code }}" placeholder="3 Digits Unique Code" minlength="3" maxlength="3" required>
                                @error('organization_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Organization Name</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control @error('organization_name')
                                    is-invalid
                                @enderror" name="organization_name" value="{{ $organization->organization_name }}" placeholder="Organization Name" minlength="3" required>
                                @error('organization_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Organization Type</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-control" name="organization_type" required>
                                    @php
                                        $organization_type = $organization->organization_type;
                                    @endphp
                                    @if ($organization_type == "prov")
                                        @php
                                            $show = "Healthcare Provider";
                                        @endphp
                                    @elseif ($organization_type == "dept")
                                        @php
                                            $show = "Hospital Department";
                                        @endphp
                                    @elseif ($organization_type == "govt")
                                        @php
                                            $show = "Government";
                                        @endphp
                                    @elseif ($organization_type == "laboratory")
                                        @php
                                            $show = "Laboratory";
                                        @endphp
                                    @elseif ($organization_type == "edu")
                                        @php
                                            $show = "Educational Institute";
                                        @endphp
                                    @elseif ($organization_type == "other")
                                        @php
                                            $show = "Other";
                                        @endphp
                                    @endif
                                    <option value="{{ $organization_type }}">{{ $show }}</option>
                                    <option value="ro">Ruangan (Default)</option>
                                    <option value="bu">Gedung</option>
                                    <option value="wi">Sayap Gedung</option>
                                    <option value="area">Area</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Organization Status</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-control" name="organization_status" required>
                                    <option value="{{ $organization->organization_status }}">{{ ucfirst($organization->organization_status) }}</option>
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">ID Organization</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control @error('organization_uuid')
                                    is-invalid
                                @enderror" name="organization_uuid" value="{{ $organization->organization_uuid }}" placeholder="Organization ID" readonly>
                                @error('organization_uuid')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @php
                        $address = getenv('ALAMAT');
                        $city = getenv('KOTA');
                        $telecom = getenv('PHONE');
                        $email = getenv('EMAIL');
                        $postalcode = getenv('KODE_POS');
                        $codeprovince = getenv('KODE_PROVINSI');
                        $codecity = getenv('KODE_KABUPATEN');
                        $codedistrict = getenv('KODE_KECAMATAN');
                        $codevillage = getenv('KODE_KELURAHAN');
                    @endphp
                    <input type="hidden" name="organization_address_use" value="official">
                    <input type="hidden" name="organization_address_line" value="{{ $address }}">
                    <input type="hidden" name="organization_address_city" value="{{ $city }}">
                    <input type="hidden" name="organization_address_country" value="ID">
                    <input type="hidden" name="organization_telecom" value="{{ $telecom }}">
                    <input type="hidden" name="organization_email" value="{{ $email }}">
                    <input type="hidden" name="organization_address_postalcode" value="{{ $postalcode }}">
                    <input type="hidden" name="organization_code_province" value="{{ $codeprovince }}">
                    <input type="hidden" name="organization_code_city" value="{{ $codecity }}">
                    <input type="hidden" name="organization_code_district" value="{{ $codedistrict }}">
                    <input type="hidden" name="organization_code_village" value="{{ $codevillage }}">
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
@endpush


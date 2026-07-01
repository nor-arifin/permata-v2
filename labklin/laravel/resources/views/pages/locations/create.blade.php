@extends('layouts.app')

@section('title', 'Form Location')

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
            <h1>Form Location</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Locations</div>
            </div>
        </div>
        <div class="section-body">
            <form action="{{ route('locations.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>New Location Registration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Location Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('location_code')
                                    is-invalid
                                @enderror" name="location_code" placeholder="3 Digits Unique Code" minlength="3" maxlength="3" required>
                                @error('location_code')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Location Name</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control @error('location_name')
                                    is-invalid
                                @enderror" name="location_name" placeholder="Location Name" onkeyup="this.value = this.value.toUpperCase();" minlength="3" required>
                                @error('location_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Location Description</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control @error('location_description')
                                    is-invalid
                                @enderror" name="location_description" placeholder="Location Description" required>
                                @error('location_description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Location Position</label>
                            @php
                                $longitude = getenv('LONGITUDE');
                                $latitude = getenv('LATITUDE');
                                $altitude = 0;
                                $address = getenv('ALAMAT');
                                $city = getenv('KOTA');
                            @endphp
                            <div class="col-sm-3 mt-2">
                                <input type="text" class="form-control @error('location_position_longitude')
                                    is-invalid
                                @enderror" name="location_position_longitude" value ="{{ $longitude }}" placeholder="Longitude" required>
                                @error('location_position_longitude')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-2">
                                <input type="text" class="form-control @error('location_position_latitude')
                                    is-invalid
                                @enderror" name="location_position_latitude" value = "{{ $latitude }}" placeholder="Latitude" required>
                                @error('location_position_latitude')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-3 mt-2">
                                <input type="text" class="form-control @error('location_position_altitude')
                                    is-invalid
                                @enderror" name="location_position_altitude" value ="{{ $altitude }}" placeholder="Altitude" required>
                                @error('location_position_altitude')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Location Type</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-control" name="location_physical_type" required>
                                    <option value="">- Select -</option>
                                    <option value="ro">Ruangan (Default)</option>
                                    <option value="bu">Gedung</option>
                                    <option value="wi">Sayap Gedung</option>
                                    <option value="area">Area</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Location Status</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-control" name="location_status" required>
                                    <option value="">- Select -</option>
                                    <option value="active">Active</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Location Part Of</label>
                            <div class="col-sm-9 mt-2">
                                <select class="form-control" name="location_organization" required>
                                    <option value="">- Select -</option>
                                    <option value="{{$profiles->organization_id}}">{{$profiles->name}} (Main Organization)</option>
                                    @foreach ($organizations as $organization)
                                        <option value="{{ $organization->organization_uuid ?? '' }}">{{ $organization->organization_name ?? '' }} (Sub Organization)</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="location_mode" value="instance">
                    <input type="hidden" name="location_address_use" value="work">
                    <input type="hidden" name="location_address_line" value="{{ $address }}">
                    <input type="hidden" name="location_address_city" value="{{ $city }}">
                    <input type="hidden" name="location_address_country" value="ID">
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
@endpush


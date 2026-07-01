@extends('layouts.app')

@section('title', 'Profile')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/assets/css/bootstrap.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Profile</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Profile</div>
                </div>
            </div>
            <div class="section-body">
                <h2 class="section-title">Hi, {{ $profile->name }}</h2>
                <p class="section-lead">
                    Change information about yourself on this page.
                </p>

                <div class="row mt-sm-4">
                    <div class="col-12 col-md-12 col-lg-5">
                        <div class="card profile-widget">
                            <div class="profile-widget-header">
                                @if($profile->photo == null)
                                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}"
                                        class="rounded-circle profile-widget-picture">
                                @else
                                    <img alt="image" src="{{ asset($profile->photo) }}" height="50px" width="50px"
                                        class="img-fluid profile-widget-picture">
                                @endif
                                <div class="profile-widget-items">
                                    <div class="profile-widget-item">
                                        <div class="profile-widget-item-label">{{ ucfirst($profile->role) }}</div>
                                        <div class="profile-widget-item-value">Stage : {{ ucfirst($profile->stage) }}
                                            - Division : {{ ucfirst($profile->division) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="profile-widget-description">
                                <div class="profile-widget-name">{{ $profile->name }}
                                    <div class="text-muted d-inline font-weight-normal">
                                        <div class="slash"></div> {{ ucfirst($profile->role) }}
                                    </div>
                                </div>
                                {{ $profile->name }} is a {{ $profile->role }} on <b>LabKlin Systems</b>.
                                <b>'Labkesmas Kalteng'</b>.
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-7">
                        <div class="card">
                            <form action="{{ route('profile.update', $profile->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <label>Full Name</label>
                                            <input type="text" name="name" value="{{ $profile->name }}" class="form-control"
                                                value="Ujang" required="">
                                            <div class="invalid-feedback">
                                                Please fill in the full name
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>Email</label>
                                            <input type="email" name="email" value="{{ $profile->email }}"
                                                class="form-control" required>
                                            <div class="invalid-feedback">
                                                Please fill in the email
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>Phone</label>
                                            <input type="text" name="phone" value="{{ $profile->phone }}"
                                                class="form-control" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>New Password</label>
                                            <input type="password" name="password" class="form-control">
                                            <div class="invalid-feedback">
                                                Please fill in the password
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>Confirm Password</label>
                                            <input type="password" name="password_confirm" class="form-control">
                                            <div class="invalid-feedback">
                                                Please confirm password
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <label class="form-label">Change Photo</label>
                                            <input type="file" class="form-control" name="photo" @error('photo') is-invalid
                                            @enderror>
                                            @error('photo')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button class="btn btn-primary">Save Changes</button>
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
    <!-- JS Libraies -->
    <script src="{{ asset('library/summernote/dist/summernote-bs4.js') }}"></script>

    <!-- Page Specific JS File -->
@endpush
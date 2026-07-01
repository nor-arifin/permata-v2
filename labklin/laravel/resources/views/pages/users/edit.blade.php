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
                <h1>Advanced Forms</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Users</div>
                </div>
            </div>

            <div class="section-body">
                <h2 class="section-title">Users</h2>

                <div class="card">
                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-header">
                            <h4>Edit User {{ $user->name }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control @error('name')
                                    is-invalid
                                @enderror" name="name" value="{{ $user->name }}">
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control @error('email')
                                    is-invalid
                                @enderror" name="email" value="{{ $user->email }}">
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <i class="fas fa-lock"></i>
                                        </div>
                                    </div>
                                    <input type="password" class="form-control @error('password')
                                        is-invalid
                                    @enderror" name="password">
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">Roles</label>
                                <select class="form-control" name="role" required>
                                    <option value="{{ $user->role }}">{{ ucfirst($user->role) }} (Aktif)</option>
                                    <option value="">- Select -</option>
                                    <option value="admin">Admin</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="validator">Validator</option>
                                    <option value="verifier">Verifier</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="staff">Staff</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Stage</label>
                                <select class="form-control" name="stage" required>
                                    <option value="{{ $user->stage }}">{{ ucfirst($user->stage) }} (Aktif)</option>
                                    <option value="clinic">Clinic</option>
                                    <option value="finance">Finance</option>
                                    <option value="general">General</option>
                                    <option value="kesmas">Kesmas</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Division</label>
                                <select class="form-control" name="division" required>
                                    <option value="{{ $user->division }}">{{ ucfirst($user->division) }} (Aktif)</option>
                                    <option value="clinic">Clinic</option>
                                    <option value="kimia">Kimia</option>
                                    <option value="mikro">Mikro</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Photo</label>
                                <input type="file" class="form-control" name="photo" @error('photo') is-invalid @enderror>
                                @error('photo')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>
@endsection

@push('scripts')
@endpush
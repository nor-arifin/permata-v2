@extends('layouts.app')

@section('title', 'Notification Setting')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Notification Setting</h1>
        </div>

        @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Fonnte Configuration</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('notification.setting.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>API Token</label>
                                <input type="text" name="api_token" class="form-control" value="{{ old('api_token', $setting->api_token) }}" placeholder="Fonnte API Token">
                            </div>

                            <div class="form-group">
                                <label>Fallback Number</label>
                                <input type="text" name="fallback_number" class="form-control" value="{{ old('fallback_number', $setting->fallback_number) }}" placeholder="62812xxxxxx">
                            </div>

                            <div class="form-group">
                                <label>Notification Status</label>
                                <select name="is_active" class="form-control">
                                    <option value="1" {{ $setting->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$setting->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('notification.setting.test') }}" class="btn btn-info" target="_blank">Test Notification</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Locations')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Location</h1>
                <div class="section-header-button">
                    <a href="{{ route('locations.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Location</a></div>
                    <div class="breadcrumb-item">All Location</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Locations</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('locations.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Longitude</th>
                                            <th>Latitude</th>
                                            <th>Altitude</th>
                                            <th>ID Location</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($locations as $location)
                                            <tr>
                                                <td>{{ $location->location_name }}
                                                </td>
                                                <td>
                                                    {{ $location->location_description }}
                                                </td>
                                                <td>
                                                    {{ $location->location_position_longitude }}
                                                </td>
                                                <td>
                                                    {{ $location->location_position_latitude }}
                                                </td>
                                                <td>
                                                    {{ $location->location_position_altitude }}
                                                </td>
                                                <td>
                                                    {{ $location->location_uuid}}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('locations.edit', $location->id) }}'
                                                            class="btn btn-sm btn-warning btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                        data-toggle="modal" data-target="#deleteModal{{ $location->id }}"><i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $locations->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

{{-- MODAL DELETE--}}
@foreach ($locations as $location)
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $location->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really to delete data {{ $location->location_name }} ?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('locations.destroy', $location->id) }}" method="POST" class="ml-2">
                    <input type="hidden" name="_method" value="DELETE" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- END MODAL DELETE --}}
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

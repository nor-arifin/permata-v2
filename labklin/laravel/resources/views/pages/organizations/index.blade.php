@extends('layouts.app')

@section('title', 'Organizations')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Organization</h1>
                <div class="section-header-button">
                    <a href="{{ route('organizations.create') }}" class="btn btn-primary">Add New Sub Organization</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Organization</a></div>
                    <div class="breadcrumb-item">All Organization</div>
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
                                <h4>Main Organization</h4>
                            </div>
                            <div class="card-body">
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr class="text-center">
                                            <th>Name</th>
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Telecom</th>
                                            <th>Type</th>
                                            <th>ID Organization</th>
                                        </tr>
                                        <tr>
                                            <td>{{ $profiles->name }}</td>
                                            <td>{{ $profiles->address }}</td>
                                            <td>{{ $profiles->base_address_city }}</td>
                                            <td>{{ $profiles->phone }}</td>
                                            <td>Main Organization</td>
                                            <td>{{ $profiles->organization_id }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $organizations->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>All Sub Organizations</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('organizations.index') }}">
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
                                            <th>Address</th>
                                            <th>City</th>
                                            <th>Telecom</th>
                                            <th>Type</th>
                                            <th>ID Organization</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($organizations as $organization)
                                            <tr>
                                                <td>{{ $organization->organization_name }}
                                                </td>
                                                <td>
                                                    {{ $organization->organization_address_line }}
                                                </td>
                                                <td>
                                                    {{ $organization->organization_address_city }}
                                                </td>
                                                <td>
                                                    {{ $organization->organization_telecom }}
                                                </td>
                                                <td>
                                                    {{ $organization->organization_type }}
                                                </td>
                                                <td>
                                                    {{ $organization->organization_uuid}}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('organizations.edit', $organization->id) }}'
                                                            class="btn btn-sm btn-warning btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                        data-toggle="modal" data-target="#deleteModal{{ $organization->id }}"><i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $organizations->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

{{-- MODAL DELETE--}}
@foreach ($organizations as $organization)
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $organization->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really to delete data {{ $organization->organization_name }} ?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('organizations.destroy', $organization->id) }}" method="POST" class="ml-2">
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

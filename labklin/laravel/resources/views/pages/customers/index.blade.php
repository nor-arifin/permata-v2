@extends('layouts.app')

@section('title', 'Customers')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Customers</h1>
                <div class="section-header-button">
                    <a href="{{ route('customers.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Customers</a></div>
                    <div class="breadcrumb-item">All Customers</div>
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
                                <h4>All Customers</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('customers.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search by Name" name="customer_name">
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
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>PIC</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($customers as $data)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $data->customer_code }}
                                                </td>
                                                <td>
                                                    <strong>{{ $data->customer_name }}</strong>
                                                </td>
                                                <td class="text-center">
                                                    {{ ucfirst($data->customer_type) }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $data->customer_address }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $data->customer_phone }}
                                                </td>
                                                <td class="text-center">
                                                    {{ $data->customer_pic }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($data->customer_status === 'active')
                                                        <div class="badge badge-pill badge-success">{{ ucfirst($data->customer_status) }}</div>
                                                    @else
                                                        <div class="badge badge-pill badge-danger">{{ ucfirst($data->customer_status) }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('customers.edit', $data->id) }}'
                                                            class="btn btn-sm btn-warning btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                            data-toggle="modal" data-target="#deleteModal{{ $data->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $customers->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- MODAL DELETE --}}
    @foreach ($customers as $customer)
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $data->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete customer <strong>{{ $data->customer_name }}</strong>? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <form action="{{ route('customers.destroy', $data->id) }}" method="POST" class="ml-2">
                            @csrf
                            @method('DELETE')
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
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

@extends('layouts.app')

@section('title', 'Kesmas Orders')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kesmas Orders</h1>
                <div class="section-header-button">
                    <a href="{{ route('kesmas.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Orders</a></div>
                    <div class="breadcrumb-item">All Kesmas Orders</div>
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
                                <h4>All Kesmas Orders</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('kesmas.index') }}">
                                        <div class=" input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table-hover table">
                                        <tr class="text-center">
                                            <th>Tanggal</th>
                                            <th>Order ID</th>
                                            <th>Customer Name</th>
                                            <th>Type</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($orders as $data)
                                            <tr class="text-center">
                                                <td>{{ date('d-m-Y', strtotime($data->order_date)) }}</td>
                                                <td>{{ $data->order_code }}</td>
                                                <td>{{ $data->customer_name }}</td>
                                                <td>{{ $data->order_type }}</td>
                                                <td>
                                                    @php
                                                        $total = $data->order_total;
                                                        $total = number_format($total, 0, ',', '.');
                                                    @endphp
                                                    <strong>Rp. {{ $total }}</strong>

                                                </td>
                                                <td>{{ ucfirst($data->order_status) }}</td>
                                                <td>
                                                    @if ($data->order_status == 'draft')
                                                        <a href='{{ route('kesmas.sample', $data->id) }}' data-toggle="tooltip"
                                                            data-placement="top" title="Input Sample"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-vials"></i>
                                                        </a>
                                                    @endif
                                                    @if ($data->order_status == 'registered')
                                                        <a href='{{ route('kesmas.parameter', $data->id) }}' data-tosmle="tooltip"
                                                            data-placement="top" title="Input Parameter"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-tags"></i>
                                                        </a>
                                                    @endif
                                                    @if ($data->order_status == 'review')
                                                        <a href='{{ route('kesmas.review', $data->id) }}' data-toggle="tooltip"
                                                            data-placement="top" title="Review FPPS" class="btn btn-sm btn-warning">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    @if (
                                                            $data->order_status != 'draft' && $data->order_status != 'registered'
                                                            && $data->order_status != 'review'
                                                        )
                                                        <a href='{{ route('kesmas.fpps', $data->id) }}' data-toggle="tooltip"
                                                            data-placement="top" title="FPPS" class="btn btn-sm btn-info">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                    @endif
                                                    <button class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#deleteModal{{ $data->id }}"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>

                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $orders->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- MODAL DELETE--}}
    @foreach ($orders as $data)
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
                        <p>{{ $data->id }}Do you really want to delete order {{ $data->customer_name }} No. FPPS :
                            {{ $data->order_code }}?
                            This process will delete the order
                            from the database.
                        </p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <form action="{{ route('kesmas.destroy', $data->id) }}" method="POST" class="ml-2">
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
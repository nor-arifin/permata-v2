@extends('layouts.app')

@section('title', 'Labkesmas Status')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laboratory</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Labkesmas</a></div>
                    <div ss="breadcrumb-item">All Kesmas Orders</div>
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
                                <h4>All Labkesmas Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('labkesmas.status') }}">
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
                                                <td>
                                                    @if($data->order_status == 'Completed')
                                                        <div title="Completed" class="badge badge-pill badge-success text-white">
                                                            Completed</div>
                                                    @elseif($data->order_status == 'Validation')
                                                        <div title="Validation" class="badge badge-pill badge-info text-white">
                                                            Validation</div>
                                                    @elseif($data->order_status == 'Verification')
                                                        <div title="Verification" class="badge badge-pill badge-warning text-white">
                                                            Verification</div>
                                                    @elseif($data->order_status == 'On Process')
                                                        <div title="On Process" class="badge badge-pill badge-danger text-white">
                                                            On Process</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href='{{ route('kesmas.fpps', $data->id) }}' data-toggle="tooltip"
                                                        data-placement="top" title="FPPS" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-print"></i>
                                                    </a>
                                                    <a href="{{ route('print.labelkm', $data->id) }}"
                                                        class="btn btn-sm btn-info btn-icon ml-2" title="Print Barcode"
                                                        target="_blank"><i class="fas fa-barcode"></i>
                                                    </a>
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
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
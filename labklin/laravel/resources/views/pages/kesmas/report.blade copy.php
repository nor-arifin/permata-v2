@extends('layouts.app')

@section('title', 'Kesmas Report')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Kesmas Report</h1>
                <div class="section-header-button">
                    <a href="{{ route('kesmas.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Labkesmas</a></div>
                    <div ss="breadcrumb-item">All Report</div>
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
                                    <form method="GET" action="{{ route('kesmas.index') }}"></form>
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
                                                                                    @if ($data->order_status == 'Completed')
                                                                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                                                                            data-target="#printModal{{ $data->id }}"><i class="fas fa-print"></i>
                                                                                        </button>
                                                                                    @endif
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
    <!-- Modal -->
    @foreach ($orders as $data)
        <div class="modal fade" id="printModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="printModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Print Report ?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Please select paper header !</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <a href="{{ route('kesmas.print', $data->id) }}" class="btn btn-primary">Lab Paper</a>
                        <a href="{{ route('kesmas.printkan', $data->id) }}" class="btn btn-primary">KAN Paper</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
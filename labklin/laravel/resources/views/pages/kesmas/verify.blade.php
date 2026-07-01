@extends('layouts.app')

@section('title', 'Verify Kesmas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Verify Kesmas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Labkesmas</a></div>
                    <div class="breadcrumb-item">Verification</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Verify Result</h4>
                                <div class="card-header-action float-right" data-toggle="tooltip" data-placement="top"
                                    title="Reload">
                                    <a href="{{ route('labkesmas.verify') }}" class="btn btn-primary"><i
                                            class="fa fa-refresh" aria-hidden="true"></i></a>
                                </div>
                            </div>

                            <div class="card-body">
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="kimia-tab3" data-toggle="tab" href="#kimia"
                                            role="tab" aria-controls="kimia" aria-selected="true">Kimia<sup
                                                class="badge badge-info">{{ $countkimia }}</sup></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="mikro-tab3" data-toggle="tab" href="#mikro" role="tab"
                                            aria-controls="mikro" aria-selected="false">Mikrobiologi<sup
                                                class="badge badge-info">{{ $countmikro }}</sup></a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="kimia" role="tabpanel"
                                        aria-labelledby="kimia-tab3">
                                        <div class="card-body">
                                            <div class="float-right">
                                                <form method="GET" action="{{ route('labkesmas.verify') }}"></form>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search"
                                                        name="name">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary"><i
                                                                class="fas fa-search"></i></button>
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
                                                        <th>Collect Time</th>
                                                        <th>Receive Time</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach ($kimias as $kimia)
                                                        <tr class="text-center">
                                                            <td>{{ date('d-m-Y', strtotime($kimia->order_date)) }}</td>
                                                            @if($kimia->order_reject != null)
                                                                <td>{{ $kimia->order_code }}<sup class="text-danger"> Rejection
                                                                    </sup>
                                                                </td>
                                                            @else
                                                                <td>{{ $kimia->order_code }}</td>
                                                            @endif
                                                            <td>{{ $kimia->customer_name }}</td>
                                                            <td>{{ $kimia->order_type }}</td>
                                                            <td>{{ date('d-m-Y H:i', strtotime($kimia->order_collect)) }}</td>
                                                            <td>{{ date('d-m-Y H:i', strtotime($kimia->order_receive)) }}</td>
                                                            @if (in_array(auth()->user()->division, ['general', 'kimia']))
                                                                <td>
                                                                    <a href='{{ route('labkesmas.verification', $kimia->id) }}'
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Verify Result" class="btn btn-sm btn-info">
                                                                        <i class="fa fa-search"></i>
                                                                    </a>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <a href='#' data-toggle="tooltip" data-placement="top"
                                                                        title="Locked" class="btn btn-sm btn-warning">
                                                                        <i class="fa fa-lock"></i>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                        </tr>

                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="float-right">
                                                {{ $kimias->withQueryString()->links() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="mikro" role="tabpanel" aria-labelledby="mikro-tab3">
                                        <div class="card-body">
                                            <div class="float-right">
                                                <form method="GET" action="{{ route('labkesmas.verify') }}"></form>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" placeholder="Search"
                                                        name="name">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary"><i
                                                                class="fas fa-search"></i></button>
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
                                                        <th>Collect Time</th>
                                                        <th>Receive Time</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach ($mikros as $mikro)
                                                        <tr class="text-center">
                                                            <td>{{ date('d-m-Y', strtotime($mikro->order_date)) }}</td>
                                                            @if($mikro->order_reject != null)
                                                                <td>{{ $mikro->order_code }}<sup class="text-danger"> Rejection
                                                                    </sup>
                                                                </td>
                                                            @else
                                                                <td>{{ $mikro->order_code }}</td>
                                                            @endif
                                                            <td>{{ $mikro->customer_name }}</td>
                                                            <td>{{ $mikro->order_type }}</td>
                                                            <td>{{ date('d-m-Y H:i', strtotime($mikro->order_collect)) }}</td>
                                                            <td>{{ date('d-m-Y H:i', strtotime($mikro->order_receive)) }}</td>
                                                            @if (in_array(auth()->user()->division, ['general', 'mikro']))
                                                                <td>
                                                                    <a href='{{ route('labkesmas.verification', $mikro->id) }}'
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Verify Result" class="btn btn-sm btn-info">
                                                                        <i class="fa fa-search"></i>
                                                                    </a>
                                                                </td>
                                                            @else
                                                                <td>
                                                                    <a href='#' data-toggle="tooltip" data-placement="top"
                                                                        title="Locked" class="btn btn-sm btn-warning">
                                                                        <i class="fa fa-lock"></i>
                                                                    </a>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="float-right">
                                                {{ $mikros->withQueryString()->links() }}
                                            </div>
                                        </div>
                                    </div>
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
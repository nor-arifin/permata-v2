@extends('layouts.app')

@section('title', 'Payment Kesmas')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Payment Kesmas</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kesmas</a></div>
                    <div class="breadcrumb-item">Payment</div>
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
                                <h4>Payment Kesmas</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right mr-4">
                                    <button class="btn btn-primary" id="opensearch" data-toggle="tooltip"
                                        data-placement="top" title="Search Payment"><i class="fas fa-search"></i></button>
                                    <a href="{{ route('payment.kesmas') }}" class="btn btn-info ml-2" data-toggle="tooltip"
                                        data-placement="top" title="Refresh"><i class="fas fa-refresh"></i></a>
                                </div>
                                <ul class="nav nav-pills" id="myTab3" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="unpaid-tab3" data-toggle="tab" href="#unpaid"
                                            role="tab" aria-controls="unpaid" aria-selected="true">Unpaid<sup
                                                class="badge badge-danger">{{ $countunpaids }}</sup></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="paid-tab3" data-toggle="tab" href="#paid" role="tab"
                                            aria-controls="paid" aria-selected="false">Paid<sup
                                                class="badge badge-success">{{ $countpaids }}</sup></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pks-tab4" data-toggle="tab" href="#pks" role="tab"
                                            aria-controls="pks" aria-selected="false">PKS<sup
                                                class="badge badge-warning">{{ $countpkss }}</sup></a>
                                    </li>
                                </ul>
                                <div class="tab-content" id="myTabContent2">
                                    <div class="tab-pane fade show active" id="unpaid" role="tabpanel"
                                        aria-labelledby="unpaid-tab3">
                                        <div class="card-body">
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
                                                    @foreach ($unpaids as $unpaid)
                                                        <tr class="text-center">
                                                            <td>{{ date('d-m-Y', strtotime($unpaid->order_date)) }}</td>
                                                            <td>{{ $unpaid->order_code }}</td>
                                                            <td>{{ $unpaid->customer_name }}</td>
                                                            <td>{{ $unpaid->order_type }}</td>
                                                            <td>
                                                                @php
                                                                    $total = $unpaid->order_total;
                                                                    $total = number_format($total, 0, ',', '.');
                                                                @endphp
                                                                <strong>Rp. {{ $total }}</strong>

                                                            </td>
                                                            <td>{{ ucfirst($unpaid->order_status) }}</td>
                                                            <td>
                                                                @if ($unpaid->order_payment_date == null)
                                                                    <a href='{{ route('payment.inputkm', $unpaid->id) }}'
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Input Payment" class="btn btn-sm btn-success">
                                                                        <i class="fas fa-cash-register"></i>
                                                                    </a>
                                                                @endif
                                                                <a href='{{ route('print.receiptkm', $unpaid->id) }}' target="_blank"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Print Receipt" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-print"></i>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="float-right">
                                                {{ $unpaids->withQueryString()->links() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="paid" role="tabpanel" aria-labelledby="paid-tab3">
                                        <div class="card-body">
                                            <div class="clearfix mb-3"></div>
                                            <div class="table-responsive">
                                                <table class="table-striped table">
                                                    <tr class="text-center">
                                                        <th>Order ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Type</th>
                                                        <th>Metode</th>
                                                        <th>Total</th>
                                                        <th>Payment Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach ($paids as $paid)
                                                        <tr class="text-center">
                                                            <td>{{ $paid->order_code }}</td>
                                                            <td>{{ $paid->customer_name }}</td>
                                                            <td>{{ $paid->order_type }}</td>
                                                            <td>{{ $paid->order_payment_method }}</td>
                                                            <td>
                                                                @php
                                                                    $total = $paid->order_total;
                                                                    $total = number_format($total, 0, ',', '.');
                                                                @endphp
                                                                <strong>Rp. {{ $total }}</strong>
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($paid->order_payment_date))}}</td>
                                                            <td>
                                                                <a href='{{ route('print.receiptkm', $paid->id) }}' target="_blank"
                                                                    data-toggle="tooltip" data-placement="top"
                                                                    title="Print Receipt" class="btn btn-sm btn-info">
                                                                    <i class="fas fa-print"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="float-right">
                                                {{ $paids->withQueryString()->links() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pks" role="tabpanel" aria-labelledby="pks-tab4">
                                        <div class="card-body">
                                            <div class="clearfix mb-3"></div>
                                            <div class="table-responsive">
                                                <table class="table-striped table">
                                                    <tr class="text-center">
                                                        <th>Order ID</th>
                                                        <th>Customer Name</th>
                                                        <th>Type</th>
                                                        <th>PKS No.</th>
                                                        <th>Total</th>
                                                        <th>Due Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    @foreach ($pkss as $pks)
                                                        <tr class="text-center">
                                                            <td>{{ $pks->order_code }}</td>
                                                            <td>{{ $pks->customer_name }}</td>
                                                            <td>{{ $pks->order_type }}</td>
                                                            <td>{{ $pks->payment_mou_number }}</td>
                                                            <td>
                                                                @php
                                                                    $total = $pks->order_total;
                                                                    $total = number_format($total, 0, ',', '.');
                                                                @endphp
                                                                <strong>Rp. {{ $total }}</strong>
                                                            </td>
                                                            <td>{{ date('d-m-Y', strtotime($pks->payment_mou_duedate)) }}</td>
                                                            <td>
                                                                @if ($pks->payment_status === 'pending')
                                                                    <a href='{{ route('payment.inputpks', $pks->id) }}'
                                                                        data-toggle="tooltip" data-placement="top"
                                                                        title="Input Payment PKS" class="btn btn-sm btn-success">
                                                                        <i class="fas fa-cash-register"></i>
                                                                    </a>
                                                                @endif
                                                                 <a href='{{ route('print.receiptpks', $pks->id) }}' target="_blank"
                                                                     data-toggle="tooltip" data-placement="top"
                                                                     title="Print Receipt" class="btn btn-sm btn-info">
                                                                     <i class="fas fa-print"></i>
                                                                 </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </div>
                                            <div class="float-right">
                                                {{ $pkss->withQueryString()->links() }}
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

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Search Payment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" action="{{ route('payment.kesmas') }}">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="searchName">Customer Name</label>
                            <input type="text" class="form-control" id="searchName" name="name"
                                placeholder="Enter customer name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('#opensearch').on('click', function () {
                    $('#searchModal').modal('show');
                });
            });
        </script>
    @endpush
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
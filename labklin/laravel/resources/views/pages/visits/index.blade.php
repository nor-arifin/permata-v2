@extends('layouts.app')

@section('title', 'Outpatient Visits')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class=" main-content">
        <section class="section">
            <div class="section-header">
                <h1>Visits</h1>
                <div class="section-header-button">
                    <a href="{{ route('visits.create') }}" class=" btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Visits</a></div>
                    <div class="breadcrumb-item">All Visit</div>
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
                                <h4>All Visits</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('visits.index') }}">
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
                                    <table class="table-striped table">
                                        <tr class="text-center">
                                            <th>No.</th>
                                            <th>Date</th>
                                            <th>No Reg</th>
                                            <th>Name</th>
                                            <th>Department</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($visits as $visit)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $visit->visit_date }}</td>
                                                <td class="text-center">{{ $visit->visit_registration_id }}</td>
                                                <td>{{ $visit->visit_patient_name }} ( {{ $visit->visit_patient_mr }} )</td>
                                                <td class="text-center">{{ $visit->visit_patient_dept }}</td>
                                                <td class="text-center">
                                                    @if($visit->visit_status_timeline == 'Registered')
                                                        <div title="Registered" class="badge badge-pill badge-danger">Registered
                                                        </div>
                                                    @elseif($visit->visit_status_timeline == 'Arrived')
                                                        <div title="Arrived" class="badge badge-pill badge-pink">Arrived</div>
                                                    @elseif($visit->visit_status_timeline == 'Waiting')
                                                        <div title="Waiting" class="badge badge-pill badge-info">Waiting</div>
                                                    @elseif($visit->visit_status_timeline == 'Sampling')
                                                        <div title="Sampling" class="badge badge-pill badge-warning text-dark">
                                                            Sampling</div>
                                                    @elseif($visit->visit_status_timeline == 'Examination')
                                                        <div title="Examination" class="badge badge-pill badge-warning text-dark">
                                                            Examination</div>
                                                    @elseif($visit->visit_status_timeline == 'Validation')
                                                        <div title="Validation" class="badge badge-pill badge-primary">Validation
                                                        </div>
                                                    @elseif($visit->visit_status_timeline == 'Reporting')
                                                        <div title="Validation" class="badge badge-pill badge-success">Reporting
                                                        </div>
                                                    @elseif($visit->visit_status_timeline == 'Finished')
                                                        <div title="Finished" class="badge badge-pill badge-success">Finished</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        @if($visit->visit_status_timeline == 'Registered')
                                                            <a href='{{ route('visits.anamneses', $visit->id) }}'
                                                                data-toggle="tooltip" data-placement="top" title="Input Anamnesis"
                                                                class="btn btn-sm btn-info btn-icon ml-2">
                                                                <i class="fa fa-stethoscope"></i>
                                                            </a>
                                                        @elseif($visit->visit_status_timeline == 'Arrived')
                                                            <a href='{{ route('visits.anamneses', $visit->id) }}'
                                                                data-toggle="tooltip" data-placement="top" title="Input Anamnesis"
                                                                class="btn btn-sm btn-info btn-icon ml-2">
                                                                <i class="fa fa-stethoscope"></i>
                                                            </a>
                                                        @elseif($visit->visit_status_timeline == 'Waiting')
                                                            <a href='{{ route('visits.services', $visit->id) }}'
                                                                data-toggle="tooltip" data-placement="top" title="Input Service"
                                                                class="btn btn-sm btn-success btn-icon ml-2">
                                                                <i class="fa fa-plus-square"></i>
                                                            </a>
                                                        @elseif($visit->visit_status_timeline == 'Sampling')
                                                            {{-- VIEW RESUME --}}
                                                            <a href='{{ route('visits.resume', $visit->visit_registration_id) }}'
                                                                data-toggle="tooltip" data-placement="top" title="Visit Summary"
                                                                class="btn btn-sm btn-warning btn-icon ml-2">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            {{-- END VIEW RESUME --}}
                                                            @if($visit->visit_payment_status == 'paid')
                                                                <a href='{{ route('print.receipt', $visit->id) }}' data-toggle="tooltip"
                                                                    data-placement="top" title="Print Receipt"
                                                                    class="btn btn-sm btn-info btn-icon ml-2">
                                                                    <i class="fa fa-print"></i>
                                                                </a>
                                                            @elseif($visit->visit_payment_status == 'unpaid')
                                                                <a href='{{ route('visits.services', $visit->id) }}'
                                                                    data-toggle="tooltip" data-placement="top" title="Add New Service"
                                                                    class="btn btn-sm btn-success btn-icon ml-2">
                                                                    <i class="fa fa-plus-square"></i>
                                                                </a>
                                                            @endif
                                                        @elseif($visit->visit_status_timeline == 'Examination')
                                                            {{-- VIEW RESUME --}}
                                                            <a href='{{ route('visits.resume', $visit->visit_registration_id) }}'
                                                                data-toggle="tooltip" data-placement="top" title="Visit Summary"
                                                                class="btn btn-sm btn-warning btn-icon ml-2">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            {{-- END VIEW RESUME --}}
                                                            @if($visit->visit_payment_status == 'paid')
                                                                <a href='{{ route('print.receipt', $visit->id) }}' data-toggle="tooltip"
                                                                    data-placement="top" title="Print Receipt"
                                                                    class="btn btn-sm btn-info btn-icon ml-2">
                                                                    <i class="fa fa-print"></i>
                                                                </a>
                                                            @endif
                                                        @elseif($visit->visit_status_timeline == 'Reporting')
                                                            {{-- VIEW RESUME --}}
                                                            <a href='{{ route('visits.resume', $visit->visit_registration_id) }}'
                                                                data-toggle="tooltip" data-placement="top" title="Visit Summary"
                                                                class="btn btn-sm btn-warning btn-icon ml-2">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            {{-- END VIEW RESUME --}}
                                                            @if($visit->visit_payment_status == 'paid')
                                                                <a href='{{ route('print.receipt', $visit->id) }}' data-toggle="tooltip"
                                                                    data-placement="top" title="Print Receipt"
                                                                    class="btn btn-sm btn-info btn-icon ml-2">
                                                                    <i class="fa fa-print"></i>
                                                                </a>
                                                            @endif
                                                        @elseif($visit->visit_status_timeline == 'Finished')
                                                            {{-- VIEW RESUME --}}
                                                            <a href='{{ route('visits.resume', $visit->visit_registration_id) }}'
                                                                data-toggle="tooltip" data-placement="top" title="Visit Summary"
                                                                class="btn btn-sm btn-warning btn-icon ml-2">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                            {{-- END VIEW RESUME --}}
                                                            @if($visit->visit_payment_status == 'paid')
                                                                <a href='{{ route('print.receipt', $visit->id) }}' data-toggle="tooltip"
                                                                    data-placement="top" title="Print Receipt"
                                                                    class="btn btn-sm btn-info btn-icon ml-2">
                                                                    <i class="fa fa-print"></i>
                                                                </a>
                                                            @endif
                                                        @endif
                                                        @if (Auth::user()->role == "admin")
                                                            <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                                data-toggle="modal" data-target="#deleteModal{{ $visit->id }}"><i
                                                                    class=" fas fa-trash"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $visits->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- MODAL DELETE--}}
    @foreach ($visits as $visit)
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $visit->id }}">
            <div class=" modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete data {{ $visit->visit_patient_name }} ? This action is not reversible and all
                            data of medical record will be lost.</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <form action="{{ route('visits.delete', $visit->id) }}" method=" POST" class="ml-2">
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <button class=" btn btn-sm btn-danger btn-icon confirm-delete">
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
    <script src=" {{ asset('js/page/features-posts.js') }}"></script>
@endpush
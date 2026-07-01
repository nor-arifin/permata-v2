@extends('layouts.app')

@section('title', 'Laboratory Status')

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
                    <div ss="breadcrumb-item"><a href="#">Laboratory</a></div>
                    <div class="breadcrumb-item">All Order</div>
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
                                <h4>All Laboratory Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('lab.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="search">
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
                                            <th>Medical Record</th>
                                            <th>Patient Name</th>
                                            <th>Departement</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($services as $lab)
                                                                            <tr class="text-center">
                                                                                <td>{{ $loop->iteration }}</td>
                                                                                @php
                                                                                    $date = $lab->created_at;
                                                                                    $date = date('d-m-Y', strtotime($date));
                                                                                @endphp
                                                                                <td style="white-space: nowrap;">{{ $date }}</td>
                                                                                <td>{{ $lab->service_visit_registration_id }}</td>
                                                                                <td>{{ $lab->service_visit_patient_mr }} / {{ $lab->patient_ihs }}</td>
                                                                                <td class="text-left">{{ $lab->patient_name }}
                                                                                    ({{ ucfirst($lab->patient_gender) }})</td>
                                                                                <td>{{ $lab->visit_patient_dept }}</td>
                                                                                <td class="text-center">
                                                                                    @if($lab->visit_status_timeline == 'Registered')
                                                                                        <div title="Registered" class="badge badge-pill badge-danger">Registered
                                                                                        </div>
                                                                                    @elseif($lab->visit_status_timeline == 'Arrived')
                                                                                        <div title="Arrived" class="badge badge-pill badge-pink">Arrived</div>
                                                                                    @elseif($lab->visit_status_timeline == 'Waiting')
                                                                                        <div title="Waiting" class="badge badge-pill badge-info">Waiting</div>
                                                                                    @elseif($lab->visit_status_timeline == 'Sampling')
                                                                                        <div title="Sampling" class="badge badge-pill badge-warning text-dark">
                                                                                            Sampling</div>
                                                                                    @elseif($lab->visit_status_timeline == 'Examination')
                                                                                        <div title="Examination" class="badge badge-pill badge-warning text-dark">
                                                                                            Examination</div>
                                                                                    @elseif($lab->visit_status_timeline == 'Validation')
                                                                                        <div title="Validation" class="badge badge-pill badge-primary">Validation
                                                                                        </div>
                                                                                    @elseif($lab->visit_status_timeline == 'Reporting')
                                                                                        <div title="Reporting" class="badge badge-pill badge-success">Validated
                                                                                        </div>
                                                                                    @elseif($lab->visit_status_timeline == 'Finished')
                                                                                        <div title="Finished" class="badge badge-pill badge-success">Finished</div>
                                                                                    @endif
                                                                                </td>
                                                                                <td style="white-space: nowrap;">
                                                                                    @if($lab->visit_status_timeline == 'Sampling')
                                                                                        <a href='{{ route('lab.show', $lab->service_visit_registration_id) }}'
                                                                                            data-toggle="tooltip" data-placement="top" title="View Lab Service"
                                                                                            class="btn btn-sm btn-info btn-icon ml-2">
                                                                                            <i class="fa fa-eye"></i>
                                                                                        </a>
                                                                                    @elseif($lab->visit_status_timeline == 'Examination')
                                                                                        <a href='{{ route('specimen', $lab->service_visit_registration_id) }}'
                                                                                            data-toggle="tooltip" data-placement="top" title="View Lab Service"
                                                                                            class="btn btn-sm btn-info btn-icon ml-2">
                                                                                            <i class="fa fa-eye"></i>
                                                                                        </a>
                                                                                    @elseif($lab->visit_status_timeline == 'Finished')
                                                                                         <a href='{{ route('print.labreport', $lab->service_visit_registration_id) }}' target="_blank"
                                                                                             data-toggle="tooltip" data-placement="top" title="Print Result"
                                                                                             class="btn btn-sm btn-primary btn-icon ml-2">
                                                                                             <i class="fa fa-print"></i>
                                                                                         </a>
                                                                                     @elseif($lab->visit_status_timeline == 'Reporting')
                                                                                         <a href='{{ route('print.labreport', $lab->service_visit_registration_id) }}'
                                                                                             data-toggle="tooltip" data-placement="top" title="Print Result"
                                                                                             target="_blank" class="btn btn-sm btn-primary btn-icon ml-2">
                                                                                            <i class="fa fa-print"></i>
                                                                                        </a>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $services->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- MODAL DELETE--}}
    @foreach ($services as $lab)
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $lab->service_visit_registration_id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to delete data {{ $lab->patient_name }} ? This action is not reversible and all data of
                            medical record will be lost.</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <form action="{{ route('lab.destroy', $lab->service_visit_registration_id) }}" method="POST"
                            class="ml-2">
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
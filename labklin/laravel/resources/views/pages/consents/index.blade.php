@extends('layouts.app')

@section('title', 'Consents')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Consent</h1>
                <div class="section-header-button">
                    <a href="{{ route('consents.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Consent</a></div>
                    <div class="breadcrumb-item">All Consent</div>
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
                                <h4>All Consents</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('consents.index') }}">
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
                                            <th>Patient ID</th>
                                            <th>Patient Name</th>
                                            <th>Consent Agreement</th>
                                            <th>Consent Agent</th>
                                            <th>UUID Consent</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($consents as $consent)
                                            <tr>
                                                <td>{{ $consent->consent_patient_id }}
                                                </td>
                                                <td>
                                                    {{ $consent->consent_patient_name }}
                                                </td>
                                                <td>
                                                    {{ $consent->consent_action }}
                                                </td>
                                                <td>
                                                    {{ $consent->consent_agent }}
                                                </td>
                                                <td>
                                                    {{ $consent->consent_uuid }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('print.consent', $consent->id) }}'
                                                            class="btn btn-sm btn-primary btn-icon">
                                                            <i class="fas fa-print"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                            data-toggle="modal" data-target="#deleteModal{{ $consent->id }}"><i
                                                                class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $consents->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    {{-- MODAL DELETE--}}
    @foreach ($consents as $consent)
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $consent->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do you really to delete data {{ $consent->consent_patient_name }} ?</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <form action="{{ route('consents.destroy', $consent->id) }}" method="POST" class="ml-2">
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
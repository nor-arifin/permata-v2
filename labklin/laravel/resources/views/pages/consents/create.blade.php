@extends('layouts.app')

@section('title', 'Form Consent')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Form Consent</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Consents</div>
                </div>
            </div>
            <div class="section-body">
                <form action="{{ route('consents.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>New Consent Agreement</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Patient ID</label>
                                <div class="col-sm-3 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="consent_patient_id" id="consent_patient_id"
                                            class="form-control" placeholder="Patient IHS ID" aria-label="">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" data-toggle="modal"
                                                data-target="#modal-pasien"><i
                                                    class="fas fa-search d-none d-sm-inline"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    <input type="text" class="form-control @error('consent_patient_mr')
                                        is-invalid
                                    @enderror" name="consent_patient_mr" id="consent_patient_mr"
                                        placeholder="MedRec Number" readonly>
                                    @error('consent_patient_mr')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-4 mt-2">
                                    <input type="text" class="form-control @error('consent_patient_name')
                                        is-invalid
                                    @enderror" name="consent_patient_name" id="consent_patient_name"
                                        placeholder="Patient Name" readonly>
                                    @error('consent_patient_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Consent Action</label>
                                <div class="col-sm-9 mt-2">
                                    <select class="form-control" name="consent_action" required>
                                        <option value="">- Select -</option>
                                        <option value="OPTIN">OPTIN</option>
                                        <option value="OPTOUT">OPTOUT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Consent Agent</label>
                                <div class="col-sm-9 mt-2">
                                    <input type="text" class="form-control @error('consent_agent')
                                        is-invalid
                                    @enderror" name="consent_agent"
                                        value="{{ auth()->user()->name }} - {{$profiles->name}}" placeholder="Consent Agent"
                                        readonly>
                                    @error('consent_agent')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Consent Timestamp</label>
                                <div class="col-sm-9 mt-2">
                                    <input type="text" class="form-control" name="consent_timestamp"
                                        value="{{ date('Y-m-d H:i:s') }}" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- <input type="hidden" name="environment" value="{{$profiles->environment}}"> -->
                        <input type="hidden" name="environment" value="PROD">
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Send Agreement</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    {{-- MODAL PATIENT LIST --}}
    <div class="modal fade" id="modal-pasien">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Patient List</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body table-responsive">
                    <table id="datatables" class="table-striped table-hover table" width="100%">
                        <thead>
                            <tr class="text-center">
                                <th>Name</th>
                                <th>Patient IHS ID</th>
                                <th>Medical Record</th>
                                <th>Birthdate / Age</th>
                                <th>Gender</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- ISI TABLE BODY ADA PADA AJAX DIBAWAH --}}
                            {{-- BUTTON DIATUR PADA CONTROLLER --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        {{-- END MODAL PATIENT LIST --}}
@endsection
    @push('scripts')
        <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
        <!-- Page Specific JS File -->
        <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#datatables').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "/data-patients/jsonvisit",
                    columns: [{
                        data: 'patient_name',
                        name: 'patient_name',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'patient_ihs',
                        name: 'patient_ihs',
                        className: 'text-center',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'patient_mr',
                        name: 'patient_mr',
                        className: 'text-center',
                        orderable: true,
                        searchable: true
                    },
                    {
                        data: 'patient_birthdate',
                        name: 'patient_birthdate',
                        className: 'text-center',
                        orderable: false,
                        searchable: true
                    },
                    {
                        data: 'patient_gender',
                        name: 'patient_gender',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: 'text-center',
                        orderable: false,
                        searchable: false
                    },
                    ],
                })
            });
        </script>
        {{-- LOAD DATA DARI MODAL SELECTED --}}
        <script>
            $(document).ready(function () {
                $(document).on('click', '#select', function () {
                    var consent_patient_id = $(this).data('ihs');
                    var consent_patient_mr = $(this).data('mr');
                    var consent_patient_name = $(this).data('name');
                    $('#consent_patient_id').val(consent_patient_id);
                    $('#consent_patient_mr').val(consent_patient_mr);
                    $('#consent_patient_name').val(consent_patient_name);
                    // HIDE MODAL SETELAH SELECT
                    $('#modal-pasien').modal('hide');
                })
            });
        </script>
    @endpush
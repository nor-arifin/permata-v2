@extends('layouts.app')

@section('title', 'Patients')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Patients</h1>
                <div class="section-header-button">
                    <a href="{{ route('patients.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Patients</a></div>
                    <div class="breadcrumb-item">All Patient</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                {{-- DATATABLE --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>All Patients</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="datatables" class="table-striped table-hover table" width="100%">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Name</th>
                                                <th>Medical Record</th>
                                                <th>IHS Number</th>
                                                <th>Birthdate / Age</th>
                                                <th>ID Number</th>
                                                <th>Gender</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END DATATABLE --}}
        </section>
    </div>
{{-- MODAL DELETE--}}
@foreach ($patients as $patient)
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $patient->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure to delete data {{ $patient->patient_name }} ? This action is not reversible and all data of medical record will be lost.</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('patients.destroyserverside', $patient->id) }}" method="POST" class="ml-2">
                    <input type="hidden" name="_method" value="POST" />
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
<script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('js/page/modules-datatables.js') }}"></script>
<script type="text/javascript">
$(document).ready( function () {
    $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/data-patients/json",
            columns: [
                { data: 'patient_name', name: 'patient_name', orderable: true, searchable: true},
                { data: 'patient_mr', name: 'patient_mr', className: 'text-center', orderable: true, searchable: true},
                { data: 'patient_ihs', name: 'patient_ihs', className: 'text-center', orderable: true, searchable: true},
                { data: 'patient_birthdate', name: 'patient_birthdate', className: 'text-center', orderable: false, searchable: true },
                { data: 'patient_nik', name: 'patient_nik', className: 'text-center', orderable: false, searchable: true },
                { data: 'patient_gender', name: 'patient_gender', className: 'text-center', orderable: false, searchable: false },
                { data: 'patient_status', name: 'patient_status', className: 'text-center', orderable: false, searchable: false },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false},
            ],
        })
} );
</script>
@endpush

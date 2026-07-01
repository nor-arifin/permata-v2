@extends('layouts.app')

@section('title', 'Form Visit')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Form Visit</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Visits</div>
            </div>
        </div>
        <div class="section-body">
            <form action="{{ route('visits.store') }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4>New Visit Registration</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-sm-4 mt-0">
                                <label>Ambulatory Method Visit</label>
                                <input type="hidden" name="visit_method" value="RAJAL">
                            </div>
                            <div class="form-group col-sm-4 mt-0">
                                <label>Registration Code</label>
                                <input type="text" class="form-control @error('visit_registration_id')
                                    is-invalid
                                @enderror" name="visit_registration_id" value="{{ $autoreg }}" placeholder="Registration Code" readonly>
                                @error('visit_registration_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group col-sm-4 mt-0">
                                <label>Registration Date</label>
                                <input type="text" class="form-control @error('visit_date_arrived')
                                    is-invalid
                                @enderror" name="visit_date_arrived" value="{{ date('Y-m-d\TH:i:sP') }}" placeholder="Registration Date" readonly>
                                @error('visit_date_arrived')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- PATIENT --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Patient Detail</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Patient ID</label>
                            <div class="col-sm-7 mt-2">
                                <div class="input-group">
                                    <input type="text" name="visit_patient_id" value="{{ old('visit_patient_id') }}" id="visit_patient_id" class="form-control" placeholder="Patient IHS ID" aria-label="">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#modal-pasien"><i class="fas fa-search d-none d-sm-inline"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2 mt-2">
                                {{-- BUTTON NEW PATIENT --}}
                                <a href="{{ route('patients.create') }}" class="btn btn-success btn-lg btn-block btn-icon-split">
                                    <i class="fas fa-plus"></i> New Patient
                                </a>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Patient Medical Record</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control @error('visit_patient_mr')
                                    is-invalid
                                @enderror" name="visit_patient_mr" value="{{ old('visit_patient_mr') }}" id="visit_patient_mr" placeholder="Medical Record Number" readonly>
                                @error('visit_patient_mr')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Patient Name</label>
                            <div class="col-sm-9 mt-2">
                                <input type="text" class="form-control @error('visit_patient_name')
                                    is-invalid
                                @enderror" name="visit_patient_name" value="{{ old('visit_patient_name') }}" id="visit_patient_name" placeholder="Patient Name" readonly>
                                @error('visit_patient_name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Place, Date of Birth</label>
                            <div class="col-sm-4 mt-2">
                                <input type="text" class="form-control @error('visit_patient_birthplace')
                                    is-invalid
                                @enderror" name="visit_patient_birthplace" value="{{ old('visit_patient_birthplace') }}" id="visit_patient_birthplace" placeholder="Patient Birth Place" readonly>
                                @error('visit_patient_birthplace')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-sm-5 mt-2">
                                <input type="text" class="form-control @error('visit_patient_birthdate')
                                    is-invalid
                                @enderror" name="visit_patient_birthdate" value="{{ old('visit_patient_birthdate') }}" id="visit_patient_birthdate" placeholder="YYYY-MM-DD" readonly>
                                @error('visit_patient_birthdate')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- DOCTOR AND DIAGNOSIS --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Medical Participant</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Doctor Name</label>
                            <div class="col-sm-9 mt-2">
                            <select class="form-control" name="visit_doctor_id" id="visit_doctor_id" value="{{ old('visit_doctor_id') }}" required>
                                <option value="">- Select -</option>
                                @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->doctor_id }}">{{ $doctor->doctor_name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Location</label>
                            <div class="col-sm-9 mt-2">
                            <select class="form-control" name="visit_location_id" id="visit_location_id" value="{{ old('visit_location_id') }}" required>
                                <option value="">- Select -</option>
                                @foreach ($locations as $location)
                                        <option value="{{ $location->location_uuid }}">{{ $location->location_name }}</option>
                                @endforeach
                            </select>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- PATIENT STATUS --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Patient Status</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-sm-3 mt-2 col-form-label">Patient Status</label>
                            <div class="col-sm-4 mt-2">
                            <select class="form-control" name="visit_patient_status" id="visit_patient_status" value="{{ old('visit_patient_status') }}" required>
                                <option value="">- Select -</option>
                                <option value="BPJS">BPJS</option>
                                <option value="General">General</option>
                                <option value="Assurance">Assurance</option>
                                <option value="MoU">MoU</option>
                            </select>
                            </div>
                            <div class="col-sm-5 mt-2">
                                <input type="text" class="form-control @error('visit_patient_account')
                                    is-invalid
                                @enderror" name="visit_patient_account" value="{{ old('visit_patient_account') }}" id="visit_patient_account" placeholder="BPJS / Assurance Number">
                                @error('visit_patient_account')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <input type="hidden" name="visit_patient_telecom" value="{{ old('visit_patient_telecom') }}" id="visit_patient_telecom">
                    <input type="hidden" name="visit_doctor_name" value="{{ old('visit_doctor_name') }}" id="visit_doctor_name">
                    <input type="hidden" name="visit_location_name" value="{{ old('visit_location_name') }}" id="visit_location_name">
                    <div class="card-footer text-right">
                        <button class="btn btn-primary" type="submit">Register Visit</button>
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
                        <th>Birthdate</th>
                        <th>Gender</th>
                        <th>Status</th>
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
$(document).ready( function () {
    $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('/data-patients/jsonvisit') }}",
            columns: [
                { data: 'patient_name', name: 'patient_name', orderable: true, searchable: true},
                { data: 'patient_ihs', name: 'patient_ihs', className: 'text-center', orderable: true, searchable: true},
                { data: 'patient_mr', name: 'patient_mr', className: 'text-center', orderable: true, searchable: true},
                { data: 'patient_birthdate', name: 'patient_birthdate', className: 'text-center', orderable: false, searchable: true },
                { data: 'patient_gender', name: 'patient_gender', className: 'text-center', orderable: false, searchable: false },
                { data: 'patient_status', name: 'patient_status', className: 'text-center', orderable: false, searchable: false },
                { data: 'action', name: 'action', className: 'text-center', orderable: false, searchable: false},
            ],
        })
} );
</script>
{{-- LOAD DATA DARI MODAL SELECTED --}}
<script>
$(document).ready( function () {
    $(document).on('click', '#select', function(){
        var visit_patient_id = $(this).data('ihs');
        var visit_patient_mr = $(this).data('mr');
        var visit_patient_name = $(this).data('name');
        var visit_patient_birthdate = $(this).data('birthdate');
        var visit_patient_birthplace = $(this).data('birthplace');
        var visit_patient_telecom = $(this).data('telecom');
        $('#visit_patient_id').val(visit_patient_id);
        $('#visit_patient_mr').val(visit_patient_mr);
        $('#visit_patient_name').val(visit_patient_name);
        $('#visit_patient_birthdate').val(visit_patient_birthdate);
        $('#visit_patient_birthplace').val(visit_patient_birthplace);
        $('#visit_patient_telecom').val(visit_patient_telecom);
        // HIDE MODAL SETELAH SELECT
        $('#modal-pasien').modal('hide');
    })
});
// SCRIPT LOCATION NAME FROM LOCATION ID
$(document).ready( function () {
    $(document).on('change', '#visit_location_id', function(){
        var visit_location_id = $(this).val();
        $.ajax({
            url: '{{ url("/getlocation") }}/'+visit_location_id,
            type: 'GET',
            dataType: 'json',
            success: function (data)
            {
                $('#visit_location_name').val(data[0].location_name);
            }
        });
    })
});
// SCRIPT DOCTOR NAME FROM DOCTOR ID
$(document).ready( function () {
    $(document).on('change', '#visit_doctor_id', function(){
        var visit_doctor_id = $(this).val();
        $.ajax({
            url: '{{ url("/getdoctor") }}/'+visit_doctor_id,
            type: 'GET',
            dataType: 'json',
            success: function (data)
            {
                $('#visit_doctor_name').val(data[0].doctor_name);
            }
        })
    })
})
</script>
@endpush


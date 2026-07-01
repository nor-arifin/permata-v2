@extends('layouts.app')

@section('title', 'Anamneses')

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
                <h1>Patient Anamneses</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Visit</a></div>
                    <div class="breadcrumb-item">Anamneses</div>
                </div>
            </div>
            {{-- FORM VALIDATION ALERT --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            {{-- END FORM VALIDATION ALERT --}}
            <div class="section-body">
                @if ($visit->visit_encounter_id == null)
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('visits.resendencounter', $visit->visit_registration_id) }}" method="POST">
                                @csrf
                                <p>The patient registration is not connected to FHIR Server. Please connect to FHIR Server
                                    first.</p>
                                <span>
                                    <input type="hidden" name="visit_id" value="{{ $visit->visit_registration_id }}">
                                    <button type="submit" class="btn btn-primary" id="getfhir">Get ID FHIR</button>
                                </span>
                        </div>
                        </form>
                    </div>
                @endif
                <form action="{{ route('anamneses.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>Registration Data</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-sm-6 mt-0">
                                    <label><strong>Ambulatory Method Visit</strong></label>
                                    <input type="hidden" name="visit_method" value="RAJAL">
                                </div>
                                <div class="col-sm-2 mt-0">
                                    <label>FHIR Status</label>
                                    @if ($visit->visit_encounter_id == null)
                                        <div class="badge badge-pill badge-danger">Not Connected</div>
                                    @else
                                        <div class="badge badge-pill badge-success">Connected</div>
                                    @endif
                                </div>
                                <div class="form-group col-sm-4 mt-0">
                                    <label>Registration Code</label>
                                    <input type="text" class="form-control" id="idreg" name="visit_registration_id"
                                        value="{{ $visit->visit_registration_id }}" readonly>
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
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="card">
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Medical
                                                Record</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $visit->visit_patient_mr }} / {{ $patient->patient_ihs }}
                                            </label>
                                        </div>
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Patient
                                                Name</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $visit->visit_patient_name }} ({{ ucfirst($patient->patient_gender) }})
                                            </label>
                                        </div>
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Birth
                                                Date</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                @php
                                                    $age = \Carbon\Carbon::parse($patient->patient_birthdate)->age
                                                @endphp
                                                : {{ $patient->patient_birthdate }} ({{ $age }} Years Old)
                                            </label>
                                        </div>
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Plan</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $visit->visit_patient_status }}
                                            </label>
                                        </div>
                                        <div class="form-inline mb-2">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Address</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $patient->patient_address_line }} -
                                                {{ $patient->patient_address_city }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="card">
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Doctor</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $visit->visit_doctor_name }} / {{ $visit->visit_doctor_id }}
                                            </label>
                                        </div>
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Departement</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $visit->visit_patient_dept }}
                                            </label>
                                        </div>
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Status</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $visit->visit_status_timeline }}
                                            </label>
                                        </div>
                                        <div class="form-inline">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Service
                                                Start</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                : {{ $visit->visit_date_arrived }}
                                            </label>
                                        </div>
                                        <div class="form-inline mb-2">
                                            <label class="col-sm-3 mt-2"
                                                style="display: inline-block; text-align:left; font-weight: bold;">Service
                                                Finish</label>
                                            <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                                @if ($visit->visit_date_finished == null)
                                                    : Still Active
                                                @else
                                                    : {{ $visit->visit_date_finished }}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- CONDITION --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Patient Condition</h4>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('icd.list') }}" class="btn btn-primary" target="_blank">
                                    <i class="fas fa-search d-none d-sm-inline"> ICD-10</i>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label mt-2">Diagnosis ICD-10 Code</label>
                                <div class="col-sm-2 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="visit_icd10_code" value="{{ old('visit_icd10_code') }}"
                                            id="visit_icd10_code" class="form-control text-uppercase" placeholder="Code"
                                            aria-label="" style="text-transform: uppercase;">
                                    </div>
                                </div>
                                <div class="col-sm-7 mt-2">
                                    <input type="text" class="form-control @error('visit_icd10_display')
                                        is-invalid
                                    @enderror" name="visit_icd10_display" value="{{ old('visit_icd10_display') }}"
                                        id="visit_icd10_display" placeholder="Display Diagnosis" readonly>
                                    @error('visit_icd10_display')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label mt-2">Condition Note</label>
                                <div class="col-sm-9 mt-2">
                                    <input type="text" class="form-control @error('condition_note')
                                        is-invalid
                                    @enderror" name="condition_note" value="{{ old('condition_note') }}"
                                        id="condition_note" placeholder="Condition Notes">
                                    @error('condition_note')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- OBERSVATION --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Patient Vital Sign</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label mt-2">Heart Rate</label>
                                <div class="col-sm-3 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="observation_heartrate"
                                            value="{{ old('observation_heartrate') }}" id="observation_heartrate"
                                            class="form-control" placeholder="60 - 80" aria-label=""
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                            minlength="1" maxlength="3" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" disabled>/Minutes</button>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-3 col-form-label mt-2">Respiratory Rate</label>
                                <div class="col-sm-3 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="observation_respiratory"
                                            value="{{ old('observation_respiratory') }}" id="observation_respiratory"
                                            class="form-control" placeholder="12 - 20" aria-label=""
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                            minlength="1" maxlength="3" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" disabled>/Minutes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label mt-2">Blood Pressure</label>
                                <div class="col-sm-3 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="observation_systolic"
                                            value="{{ old('observation_systolic') }}" id="observation_systolic"
                                            class="form-control" placeholder="Systolic" aria-label=""
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                            minlength="1" maxlength="3" required>
                                        <input type="text" name="observation_diastolic"
                                            value="{{ old('observation_diastolic') }}" id="observation_diastolic"
                                            class="form-control" placeholder="Diastolic" aria-label=""
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                            minlength="1" maxlength="3" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" disabled>mmHg</button>
                                        </div>
                                    </div>
                                </div>
                                <label class="col-sm-3 col-form-label mt-2">Temperature</label>
                                <div class="col-sm-3 mt-2">
                                    <div class="input-group">
                                        <input type="text" name="observation_temperature"
                                            value="{{ old('observation_temperature') }}" id="observation_temperature"
                                            class="form-control" placeholder="36 - 38" aria-label=""
                                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                            minlength="1" maxlength="2" required>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button" disabled>&#176C</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <input type="hidden" name="idvisit" value="{{ $visit->id }}">
                        <input type="hidden" name="condition_subject_id" value="{{ $patient->patient_ihs }}">
                        <input type="hidden" name="condition_subject_name" value="{{ $visit->visit_patient_name }}">
                        <input type="hidden" name="visit_encounter_id" value="{{ $visit->visit_encounter_id }}">
                        <input type="hidden" name="condition_clinicalstatus" value="active">
                        <input type="hidden" name="condition_category" value="Diagnosis">
                        <input type="hidden" name="condition_onset" value="{{ date('Y-m-d\TH:i:sP') }}">
                        <input type="hidden" name="condition_recorded" value="{{ date('Y-m-d\TH:i:sP') }}">
                        <input type="hidden" name="doctor_id" value="{{ $visit->visit_doctor_id }}">
                        <input type="hidden" name="doctor_name" value="{{ $visit->visit_doctor_name }}">
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Save Anamneses</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <!-- Load SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $('#visit_icd10_code').on('change', function () {
                var visit_icd10_code = $(this).val();
                if (!visit_icd10_code) {
                    Swal.fire({
                        title: 'ICD-10 Code',
                        text: 'Please enter a valid ICD-10 Code',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    });
                    $('#visit_icd10_display').val('');
                    return;
                }

                $.ajax({
                    url: "/data-icd/" + visit_icd10_code,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        if (data && data.icd10_id) {
                            Swal.fire({
                                title: 'ICD-10 Ditemukan',
                                text: data.icd10_code + ' - ' + data.icd10_id,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                            $('#visit_icd10_display').val(data.icd10_id);
                        } else {
                            Swal.fire({
                                title: 'ICD-10 Code',
                                text: 'ICD-10 Tidak Ditemukan',
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            });
                            $('#visit_icd10_display').val('');
                        }
                    },
                    error: function () {
                        Swal.fire({
                            title: 'Error',
                            text: 'Unable to fetch ICD-10 Code. Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        $('#visit_icd10_display').val('');
                    }
                });
            });
        });
    </script>

@endpush
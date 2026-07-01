@extends('layouts.app')

@section('title', 'Visit Summary')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Visit Summary</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Visits</a></div>
                <div class="breadcrumb-item">Resume</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
            {{-- PATIENT --}}
            <div class="card">
                <div class="card-header">
                    <h4>Patient Detail - No. Reg : {{ $visit->visit_registration_id }}
                    </h4>
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
                                        : {{ $visit->visit_patient_name }}
                                        ({{ ucfirst($patient->patient_gender) }})
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Birth
                                        Date</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        @php
                                        $age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
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
            {{-- ANAMNESES --}}
            <div class="card">
                <div class="card-header">
                    <h4>Patient Condition at {{ $anamneses->created_at }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">FHIR
                                        SatuSehat</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        @if ($anamneses->condition_id == null)
                                        Not Updated
                                        @else
                                        Updated to This Condition
                                        @endif
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Condition</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        {{ $anamneses->condition_code }}
                                        ({{ ucfirst($anamneses->condition_display) }})
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Notes</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        @if ($anamneses->condition_note == null)
                                        -
                                        @else
                                        {{ $anamneses->condition_note }}
                                        @endif
                                    </label>
                                </div>
                                <div class="form-inline mb-2">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Vital
                                        Sings</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        HR = {{ $anamneses->observation_heartrate }}x/Minute, RR =
                                        {{ $anamneses->observation_respiratory }}x/Minute, BP =
                                        {{ $anamneses->observation_systolic }}/{{ $anamneses->observation_diastolic }}
                                        mmHg, Temp = {{ $anamneses->observation_temperature }}°C
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- LABORATORY --}}
            <div class="card">
                <div class="card-header">
                    <h4>Laboratory Summary</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Registered</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        @php
                                        $timeregistered = date('d-m-Y H:i:s', strtotime($visit->visit_date_arrived));
                                        @endphp
                                        {{ $timeregistered }} by {{ $visit->visit_registered_by }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Specimen
                                        Collected</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        @php
                                        $timesampling = date('d-m-Y H:i:s', strtotime($visit->visit_time_sampling));
                                        @endphp
                                        {{ $timesampling }} by {{ $visit->visit_sampling_by }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Specimen
                                        Received</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        @php
                                        $timereceive = date('d-m-Y H:i:s', strtotime($visit->visit_time_receive));
                                        @endphp
                                        {{ $timereceive }} by {{ $visit->visit_receive_by }}
                                    </label>
                                </div>
                                <div class="form-inline mb-2">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Results
                                        Validation</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        @php
                                        $timevalidation = date('d-m-Y H:i:s', strtotime($visit->visit_time_validation));
                                        @endphp
                                        {{ $timevalidation}} by {{ $visit->visit_validation_by }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card table-responsive">
                                {{-- RESULT LAB --}}
                                <table class="table-striped table-bordered table-hover table" id="observation">
                                    <tr class="table-primary text-center text-bold">
                                        <th>Parameter</th>
                                        <th>Result</th>
                                        <th>Reference Range</th>
                                        <th>Unit</th>
                                        <th width="5%">Flag</th>
                                    </tr>
                                    @foreach ($results as $result)
                                    {{-- SET REFERENCE RANGE --}}
                                    @php
                                    $gender = $patient->patient_gender;
                                    $resultvalue = $result->service_result;
                                    $resulttype = $result->test_resulttype;
                                    $reference = $result->service_reference;
                                    @endphp
                                    @if ($resulttype == 'Qn')
                                    @if ($age > 12 && $age <= 200) @if ($gender=='male' ) @php $min=$result->
                                        test_min_male;
                                        $max = $result->test_max_male;
                                        @endphp
                                        @elseif ($gender == 'female')
                                        @php
                                        $min = $result->test_min_female;
                                        $max = $result->test_max_female;
                                        @endphp
                                        @endif
                                        @elseif ($age > 1 && $age <= 12) @php $min=$result->test_min_child;
                                            $max = $result->test_max_child;
                                            @endphp
                                            @elseif ($age <= 1) @php $min=$result->test_min_baby;
                                                $max = $result->test_max_baby;
                                                @endphp
                                                @else
                                                @php
                                                $min = $result->test_min_general;
                                                $max = $result->test_max_general;
                                                @endphp
                                                @endif
                                                @else
                                                @php
                                                $min = $reference;
                                                $max = $reference;
                                                @endphp
                                                @endif
                                                <tr>
                                                    @if ($result->test_category == 'Panel')
                                                    <td><b>{{ $result->service_name }}</b></td>
                                                    @elseif(($result->test_category == 'Sub Panel'))
                                                    <td>&nbsp;&nbsp;&nbsp;&nbsp;{{ $result->service_name }}</td>
                                                    @else
                                                    <td>{{ $result->service_name }}</td>
                                                    @endif
                                                    @if ($reference == 'Terlampir')
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    <td class="text-center"></td>
                                                    @else
                                                    <td class="text-center"><b>{{ $result->service_result }}</b></td>
                                                    <td class="text-center">{{ $result->service_reference }}</td>
                                                    <td class="text-center">{{ $result->test_unit }}</td>
                                                    @if ($resulttype == 'Qn' && $reference != null)
                                                    @if ($resultvalue < $min && $resultvalue < $max) @php $flag="L" ;
                                                        @endphp @elseif ($resultvalue> $min && $resultvalue > $max)
                                                        @php
                                                        $flag = "H";
                                                        @endphp
                                                        @else
                                                        @php
                                                        $flag = "";
                                                        @endphp
                                                        @endif
                                                        <td class="text-center text-danger"><b>{{ $flag }}</b></td>
                                                        @elseif($resulttype != 'Qn' && $reference != null)
                                                        @if ($resultvalue != $reference)
                                                        @php
                                                        $flag = "*";
                                                        @endphp
                                                        @else
                                                        @php
                                                        $flag = "";
                                                        @endphp
                                                        @endif
                                                        <td class="text-center text-warning"><b>{{ $flag }}</b></td>
                                                        @else
                                                        @php
                                                        $flag = "";
                                                        @endphp
                                                        <td class="text-center text-success"><b>{{ $flag }}</b></td>
                                                        @endif
                                                        @endif
                                                </tr>
                                                @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="form-inline">
                                    <label class="col-sm-12 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Expertise :
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-12 mt-2 mb-2"
                                        style="display: inline-block; text-align:left;">{{ $visit->visit_validation_impression }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($visit->visit_status_timeline == 'Reporting')
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="col-12 text-center">
                                    <button href="#" class="btn btn-success mt-2 mb-3" data-toggle="modal"
                                        data-target="#letterModal">Generate Napza Letter</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="col-12 text-center">
                                    <div class="alert alert-warning text-dark mt-2 mb-3">
                                        <h5>Waiting Result Validated</h5>
                                        <p>Please confirm your validator to generate NAPZA letter button</p>
                                        <p>To update the data, please contact the administrator</p>
                                        <p>Thank you</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
    </section>
</div>

{{-- MODAL FINISH --}}
<div class="modal fade" tabindex="-1" role="dialog" id="letterModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Generator Napza Letter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('create.napza') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <p>
                        Hai <b>{{ auth()->user()->name }}</b>, this data will be stored in the NAPZA letter register and
                        will become a letter issued by your organization.</p>
                    @csrf
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    <div class="form-group">
                        <label for="letter_napza_date">Tanggal / Date</label>
                        <input type="date" class="form-control" id="letter_napza_date" name="letter_napza_date"
                            value="{{ old('letter_napza_date', date('Y-m-d')) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="letter_napza_number">Nomor Surat / Letter Number</label>
                        <input type="text" class="form-control" id="letter_napza_number" name="letter_napza_number"
                            value="{{ old('letter_napza_number') }}"
                            placeholder="Nomor/UPT Labkeskal/NAPZA/445.1/IV/2025" required>
                    </div>
                    <div class="form-group">
                        <label for="letter_napza_purpose">Keperluan / Purpose</label>
                        <textarea class="form-control" id="letter_napza_purpose" name="letter_napza_purpose" rows="3"
                            required>{{ old('letter_napza_purpose') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="letter_napza_conclution">Kesimpulan / Conclusion</label>
                        <select class="form-control" id="letter_napza_conclution" name="letter_napza_conclution"
                            required>
                            <option value="" disabled {{ old('letter_napza_conclution') ? '' : 'selected' }}>- Select -
                            </option>
                            <option value="TIDAK DITEMUKAN"
                                {{ old('letter_napza_conclution') == 'TIDAK DITEMUKAN' ? 'selected' : '' }}>TIDAK
                                DITEMUKAN</option>
                            <option value="DITEMUKAN"
                                {{ old('letter_napza_conclution') == 'DITEMUKAN' ? 'selected' : '' }}>DITEMUKAN</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="letter_napza_signed">Ditandatangani Oleh / Signed By</label>
                        <select class="form-control" id="letter_napza_signed" name="letter_napza_signed" required>
                            <option value="" disabled {{ old('letter_napza_signed') ? '' : 'selected' }}>- Select -
                            </option>
                            <option value="dr. VALENCIA WILENTINE"
                                {{ old('letter_napza_signed') == 'dr. VALENCIA WILENTINE' ? 'selected' : '' }}>dr.
                                VALENCIA WILENTINE</option>
                            <option value="dr. P,Rr. IMELDA WULANDARI"
                                {{ old('letter_napza_signed') == 'dr. P,Rr. IMELDA WULANDARI' ? 'selected' : '' }}>dr.
                                P,Rr. IMELDA WULANDARI</option>
                            <option value="dr. LESTARI, Sp.PK."
                                {{ old('letter_napza_signed') == 'dr. LESTARI, Sp.PK.' ? 'selected' : '' }}>dr. LESTARI,
                                Sp.PK.</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Surat Keterangan NAPZA akan dibuat untuk {{ $visit->visit_patient_name }} -
                            {{ $visit->visit_patient_mr }} dengan nomor LHU {{ $visit->visit_registration_id }}</label>
                        <p><i>Napza letter will be create for {{ $visit->visit_patient_name }} -
                                {{ $visit->visit_patient_mr }} with result number
                                {{ $visit->visit_registration_id }}</i></p>
                    </div>
                    <input type="hidden" name="letter_napza_name" value="{{ $visit->visit_patient_name }}">
                    <input type="hidden" name="letter_napza_mr" value="{{ $visit->visit_patient_mr }}">
                    <input type="hidden" name="letter_napza_lhu" value="{{ $visit->visit_registration_id }}">
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="submit" class="btn btn-primary">Generate Letter</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL RESULT --}}
@endsection
@push('scripts')


<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
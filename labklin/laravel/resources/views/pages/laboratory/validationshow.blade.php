@extends('layouts.app')

@section('title', 'Laboratory Validation')

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
                <div class="breadcrumb-item"><a href="#">Laboratory</a></div>
                <div class="breadcrumb-item">Validation</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
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
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Specimen
                                        Notes</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        {{ $visit->service_notes }}
                                    </label>
                                </div>
                                <div class="form-inline mb-2">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">History
                                        Laboratory Result</label>
                                    <label class="col-sm-12 mt-2 text-right"
                                        style="display: inline-block; text-align:left;">
                                        <button href="#" class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#historyModal"><i class="fas fa-search"></i> View Last
                                            Result</button>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card table-responsive">
                                {{-- RESULT LAB --}}
                                <table class="table-striped table-bordered table-hover table">
                                    <tr class="table-gray text-center text-bold">
                                        <th>Parameter</th>
                                        <th width="5%">Flag</th>
                                        <th>Result</th>
                                        <th>Reference Range</th>
                                        <th>Unit</th>
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
                                                    @if ($resulttype == 'Qn' && $reference != 'Terlampir')
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
                                                        @if ($reference == 'Terlampir')
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        @else
                                                        <td class="text-center"><b>{{ $result->service_result }}</b>
                                                        </td>
                                                        <td class="text-center">{{ $result->service_reference }}</td>
                                                        <td class="text-center">{{ $result->test_unit }}</td>
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
                                <div class="col-12 text-center">
                                    <button href="#" class="btn btn-danger mt-2 mb-3" data-toggle="modal"
                                        data-target="#unvalidateModal">Cancel Result</button>
                                    <button href="#" class="btn btn-success mt-2 mb-3" data-toggle="modal"
                                        data-target="#validateModal">Validate Result</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- MODAL VALIDATE --}}
<div class="modal fade" tabindex="-1" role="dialog" id="validateModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validate Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('lab.updateval', $visit->visit_registration_id) }}" method="POST" class="ml-2">
                <div class="modal-body">
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="visit_status_timeline" value="Reporting" />
                    <div class="form-group">
                        <label for="visit_validation_impression">Validation Impression</label>
                        <textarea class="form-control" name="visit_validation_impression"
                            required>{{$visit->visit_validation_impression}}</textarea>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button class="btn btn-sm btn-success btn-icon">
                        Validate
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- MODAL UNVALIDATE --}}
<div class="modal fade" tabindex="-1" role="dialog" id="unvalidateModal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Result Option</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to cancel this result ? <br>Please select action below to cancel this result
                </p>
                <form action="{{ route('lab.updatetocollect', $visit->visit_registration_id) }}" method="POST"
                    class="ml-2">
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="visit_status_timeline" value="Sampling" />
                    <div class="col-12 text-center">
                        <button class="btn btn-sm btn-danger btn-icon">
                            Re-Collect Specimen
                        </button>
                    </div>
                </form>
                <form action="{{ route('lab.updatetoreceive', $visit->visit_registration_id) }}" method="POST"
                    class="ml-2">
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <input type="hidden" name="visit_status_timeline" value="Examination" />
                    <div class="col-12 text-center mt-3">
                        <button class="btn btn-sm btn-warning btn-icon">
                            Re-Run Test
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-whitesmoke br">
            </div>
        </div>
    </div>
</div>
{{-- MODAL HISTORY --}}
<div class="modal fade" tabindex="-1" role="dialog" id="historyModal">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">History Laboratory Result</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($lastvisits as $last)
                {{-- RESULT LAB --}}
                @php
                $noreg = $last->visit_registration_id;
                $visitdate = $last->visit_date;
                $visitdated = date("d-m-Y", strtotime($visitdate));
                $labdetail = DB::table('services_detail')
                ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
                ->where('service_visit_registration_id', $noreg)
                ->whereNotNull('services_detail.service_time_result')
                ->whereNotNull('services_detail.service_loinc_code')
                ->orderBy('service_group')
                ->orderBy('service_servicerequest_id')
                ->get();
                @endphp
                <div><b>{{ $visitdated }} - {{ $last->visit_registration_id }}</b></div>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr class="text-center">
                            <th>Parameter</th>
                            <th width="5%">Flag</th>
                            <th>Result</th>
                            <th>Reference Range</th>
                            <th>Unit</th>
                        </tr>
                        @foreach ($labdetail as $result)
                        {{-- SET REFERENCE RANGE --}}
                        @php
                        $gender = $patient->patient_gender;
                        $resultvalue = $result->service_result;
                        $resulttype = $result->test_resulttype;
                        $reference = $result->service_reference;
                        @endphp
                        @if ($resulttype == 'Qn')
                        @if ($age > 12 && $age <= 200) @if ($gender=='male' ) @php $min=$result->test_min_male;
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
                                        @if ($resulttype == 'Qn' && $reference != 'Terlampir')
                                        @if ($resultvalue < $min && $resultvalue < $max) @php $flag="L" ; @endphp
                                            @elseif ($resultvalue> $min && $resultvalue > $max)
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
                                            @if ($reference == 'Terlampir')
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            <td class="text-center"></td>
                                            @else
                                            <td class="text-center"><b>{{ $result->service_result }}</b></td>
                                            <td class="text-center">{{ $result->service_reference }}</td>
                                            <td class="text-center">{{ $result->test_unit }}</td>
                                            @endif
                                    </tr>
                                    @endforeach
                    </table>
                    <p>Expertise : {{ $last->visit_validation_impression}}</p>
                </div>
                @endforeach
                <br>
                <p>LabKlin Systems only shows result of <b>3 latest visit</b>, if you want to see all visit, please
                    click <a href="{{ route('print.record', $patient->patient_mr) }}" target="_blank">here</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
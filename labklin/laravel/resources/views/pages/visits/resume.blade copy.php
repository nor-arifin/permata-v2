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
                {{-- SERVICE REQUEST --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Service Summary</h4>
                    </div>
                    <div class="card-body">
                        {{-- NOTED --}}
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
                                            style="display: inline-block; text-align:left; font-weight: bold;">Specimen Collected</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            @php
                                                $timesampling = date('d-m-Y H:i:s', strtotime($visit->visit_time_sampling));
                                            @endphp
                                            {{ $timesampling }} by {{ $visit->visit_sampling_by }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Specimen Received</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            @php
                                                $timereceive = date('d-m-Y H:i:s', strtotime($visit->visit_time_receive));
                                            @endphp
                                            {{ $timereceive }} by {{ $visit->visit_receive_by }}
                                        </label>
                                    </div>
                                    <div class="form-inline mb-2">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Results Validation</label>
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
                                            <th width="5%">Flag</th>
                                            <th>Result</th>
                                            <th>Reference Range</th>
                                            <th>Unit</th>
                                            <th colspan="2">FHIR</th>
                                        </tr>
                                        @foreach ($results as $result)
                                        {{-- SET REFERENCE RANGE --}}
                                        @php
                                            $gender = $patient->patient_gender;
                                            $age = $age;
                                            $resultvalue = $result->service_result;
                                            $resulttype = $result->test_resulttype;
                                            $reference = $result->service_reference;
                                        @endphp
                                        @if ($resulttype == 'Qn')
                                            @if ($age > 12 && $age <= 200)
                                                @if ($gender == 'male')
                                                    @php
                                                        $min = $result->test_min_male;
                                                        $max = $result->test_max_male;
                                                    @endphp
                                                @elseif ($gender == 'female')
                                                    @php
                                                        $min = $result->test_min_female;
                                                        $max = $result->test_max_female;
                                                    @endphp
                                                @endif
                                            @elseif ($age > 1 && $age <= 12)
                                                @php
                                                    $min = $result->test_min_child;
                                                    $max = $result->test_max_child;
                                                @endphp
                                            @elseif ($age <= 1)
                                                @php
                                                    $min = $result->test_min_baby;
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

                                            @if ($resulttype == 'Qn' && $reference != null)
                                                @if ($resultvalue < $min && $resultvalue < $max)
                                                    @php
                                                    $flag = "L";
                                                    @endphp
                                                @elseif ($resultvalue > $min && $resultvalue > $max)
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
                                            @if ($result->test_category != "Panel")
                                                @if ($result->service_observation_id == null && $result->service_result != null)
                                                <td class="text-center">
                                                    {{-- <form action="{{ route('lab.makefullreport', $result->id ) }}" method="POST" class="ml-2" id="sendResult{{$result->id}}"> --}}
                                                    {{-- <form action="" method="POST" class="ml-2" id="sendResult{{$result->id}}"> --}}
                                                    <form id="sendResult{{$result->id}}">
                                                        <input type="hidden" name="_method" id="method" value="PUT" />
                                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                                                        <input type="hidden" name="id" id="id_data" value="{{$result->id}}" />
                                                        <input type="hidden" name="flag" id="flag" value="{{ $flag }}" />
                                                        <input type="hidden" name="result" id="result" value="{{ $result->service_result }}" />
                                                        {{-- <input type="checkbox" name="makeresult" value="1" id="makeResult"> --}}
                                                        <button type="submit" class="btn btn-sm btn-success btn-icon" id="makeResult" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                                    </form>
                                                    <div id="cf-response-message"></div>
                                                    <div class="text-center text-success" id="successResult{{$result->id}}" data-toggle="tooltip"
                                                    data-placement="top" title="Success to FHIR" style="display: none">
                                                        <i class="fa fa-check" aria-hidden="true"></i></div>
                                                        <div class="text-center text-danger" id="errorResult{{$result->id}}" data-toggle="tooltip"
                                                    data-placement="top" title="Failed to FHIR" style="display: none">
                                                        <i class="fa fa-times" aria-hidden="true"></i></div>
                                                </td>
                                                @else
                                                <td class="text-center text-success" data-toggle="tooltip"
                                                    data-placement="top" title="Success to FHIR">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                </td>
                                                @endif
                                            @else
                                                {{-- PANEL --}}
                                                @php
                                                    $panelcode = $result->service_code;
                                                    // panel tree
                                                    $subpanel = DB::table('services_detail')
                                                                ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
                                                                ->where('test_partof', $panelcode)
                                                                ->where('service_visit_registration_id', $visit->visit_registration_id)
                                                                ->whereNotNull('services_detail.service_time_result')
                                                                ->count();
                                                    $subpaneldone = DB::table('services_detail')
                                                                ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
                                                                ->where('test_partof', $panelcode)
                                                                ->where('service_visit_registration_id', $visit->visit_registration_id)
                                                                ->whereNotNull('services_detail.service_observation_id')
                                                                ->count();
                                                @endphp
                                                @if ($subpanel == $subpaneldone)
                                                    @if ($result->service_diagnosticreport_id == null)
                                                    <td class="text-center">
                                                        <form id="sendResult{{$result->id}}">
                                                            <input type="hidden" name="_method" id="method" value="PUT" />
                                                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                                                            <input type="hidden" name="id" id="id_data" value="{{$result->id}}" />
                                                            <input type="hidden" name="flag" id="flag" value="{{$flag}}" />
                                                            <input type="hidden" name="result" id="result" value="{{ $result->service_result }}" />
                                                            <button type="submit" class="btn btn-sm btn-success btn-icon" id="makeResult" ><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                                        </form>
                                                        <div id="cf-response-message"></div>
                                                        <div class="text-center text-success" id="successResult{{$result->id}}" data-toggle="tooltip"
                                                        data-placement="top" title="Success to FHIR" style="display: none">
                                                            <i class="fa fa-check" aria-hidden="true"></i></div>
                                                            <div class="text-center text-danger" id="errorResult{{$result->id}}" data-toggle="tooltip"
                                                        data-placement="top" title="Failed to FHIR" style="display: none">
                                                            <i class="fa fa-times" aria-hidden="true"></i></div>
                                                    </td>
                                                    @else
                                                    <td class="text-center text-success" data-toggle="tooltip"
                                                        data-placement="top" title="Success to FHIR">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                    </td>
                                                    @endif
                                                @else
                                                    <td class="text-center text-success" data-toggle="tooltip"
                                                    data-placement="top" title="Waiting All Sub Panel Send to FHIR">
                                                    <i class="fa fa-spinner" aria-hidden="true"></i>
                                                </td>
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
                        @if ($visit->visit_status_timeline != 'Finished')
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="col-12 text-center">
                                        <button href="#" class="btn btn-primary mt-2 mb-3" data-toggle="modal" data-target="#finishModal">Finish Visit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        {{-- TAMBAH BUAT SEND DIAGNOSTIC --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- MODAL VALIDATE --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="finishModal">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Finish Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to finish visit {{ $visit->visit_registration_id}} / {{ $visit->visit_patient_name }} ? This action is not reversible and all data of medical record will be sent to FHIR SatuSehat.</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <form action="{{ route('visits.updatefinish', $visit->visit_registration_id) }}" method="POST" class="ml-2">
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="visit_status_timeline" value="Finished" />
                        <input type="hidden" name="visit_date_progress" value="{{$visit->visit_date_progress}}" />
                        <input type="hidden" name="visit_date_arrived" value="{{$visit->visit_date_arrived}}" />
                        @if ($visit->visit_payment_status == 'paid')
                            <button class="btn btn-sm btn-success btn-icon">
                                Finish - Send to FHIR
                            </button>
                        @else
                            <p><b class="text-danger">Payment must be paid first</b></p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
<script>
    $(document).ready(function() {
        $('#observation tr').each(function() {
            var $this = $(this);
            // var id = $this.find('input[name^="id"]').val();
            // var flag = $this.find('input[name^="flag"]').val();
            // var result = $this.find('input[name^="result"]').val();
            var id = $this.find('input[id="id_data"]').val();
            $('#sendResult'+id).submit(function(e) {
                e.preventDefault();

                // Serialize the form data
                // const formData = new FormData(form);
                $.ajax({
                    url: 'http://localhost:8000/lab/makefullreport/'+id,
                    type: 'POST',
                    data: $('form').serialize(),
                    // data: formData, // Remember that you need to have your csrf token included
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        if(data.success == true ){ //CEK APAKAH DATA RESOURCE ADA, cek console.log
                            document.getElementById('sendResult'+id).style.display = 'none';
                            document.getElementById('successResult'+id).style.display = 'block';
                            console.log(data);
                        // console.log(data);
                        }else{
                            document.getElementById('sendResult'+id).style.display = 'block';
                            document.getElementById('successResult'+id).style.display = 'none';
                            console.log(data);
                        };
                    }
                });
            });
        });
    });
</script>
    {{-- <script>
        $(document).ready(function() {
            $('#cf-form').submit(function(e) {
                e.preventDefault();

                // Serialize the form data
                const formData = new FormData(form);
                // Send an AJAX request
                $.ajax({
                    type: 'POST',
                    url: '{!! route('testing') !!}',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        // Handle the response message
                        $('#cf-response-message').text(response.message);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if needed
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script> --}}
{{-- <script>
    $(document).ready(function() {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#observation tr').each(function() {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var flag = $this.find('input[id^="flag"]').val();
                var result = $this.find('input[id^="result"]').val();
                // var check = $this.find('input[id="makeResult"]');
                var check = $this.find('input[name^="makeresult"]');
                $(document).on("submit", "#myForm", function(event){
                    event.preventDefault();

                    $.ajax({
                            url: 'http://localhost:8000/lab/makefullreport/'+id,
                            type: 'POST',
                            data: $('form').serialize(), // Remember that you need to have your csrf token included
                            dataType: 'json',
                            cache: false,
                            success: function(data) {
                                if(data.success == true ){ //CEK APAKAH DATA RESOURCE ADA, cek console.log
                                    document.getElementById('myForm'+id).style.display = 'none';
                                    document.getElementById('successResult'+id).style.display = 'block';
                                    console.log(data);
                                // console.log(data);
                                }else{
                                    document.getElementById('myForm'+id).style.display = 'block';
                                    document.getElementById('successResult'+id).style.display = 'none';
                                    console.log(data);
                                };
                            }
                        });
                });
                // check.on('click', function(e) {
                //     e.preventDefault();
                //     var checked = $(this).val();
                //     if (checked) {
                //         $.ajax({
                //             url: 'http://localhost:8000/lab/makefullreport/'+id,
                //             type: 'POST',
                //             data: $('form').serialize(), // Remember that you need to have your csrf token included
                //             dataType: 'json',
                //             cache: false,
                //             success: function(data) {
                //                 if(data.success == true ){ //CEK APAKAH DATA RESOURCE ADA, cek console.log
                //                     document.getElementById('sendResult'+id).style.display = 'none';
                //                     document.getElementById('successResult'+id).style.display = 'block';
                //                     console.log(data);
                //                 // console.log(data);
                //                 }else{
                //                     document.getElementById('sendResult'+id).style.display = 'block';
                //                     document.getElementById('successResult'+id).style.display = 'none';
                //                     console.log(data);
                //                 };
                //             }
                //         });
                //     } else {
                //         $('#makeResult').empty();
                //     }
                // });
            });
        });
</script> --}}

<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

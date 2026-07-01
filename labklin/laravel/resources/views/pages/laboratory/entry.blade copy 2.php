@extends('layouts.app')

@section('title', 'Laboratory Result')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laboratory</h1>
                <div class="section-header-button">
                    <a href="{{ route('lab.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Laboratory</a></div>
                    <div class="breadcrumb-item">Detail Order</div>
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
                {{-- INPUT LABORATORY --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Input Laboratory Result</h4>
                    </div>
                    <div class="card-body">
                        <div id="accordion">
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-1">
                                    <h4>Hematology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-1"
                                    data-parent="#accordion">
                                    {{-- Hematology --}}
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <tr class="text-center">
                                                <th>Parameter</th>
                                                <th>Result</th>
                                                <th>Reference Range</th>
                                                <th>Unit</th>
                                            </tr>
                                            @foreach ($hematology as $input)
                                                {{-- SET REFERENCE RANGE --}}
                                                @php
                                                    $gender = $patient->patient_gender;
                                                    $age = $age;
                                                @endphp
                                                @if ($age > 12 && $age <= 100)
                                                    @if ($gender == 'male')
                                                        @php
                                                        $reference = $input->test_normal_male;
                                                        @endphp
                                                    @elseif ($gender == 'female')
                                                        @php
                                                        $reference = $input->test_normal_female;
                                                        @endphp
                                                    @endif
                                                @elseif ($age > 1 && $age <= 12)
                                                    @php
                                                    $reference = $input->test_normal_child;
                                                    @endphp
                                                @elseif ($age <= 1)
                                                    @php
                                                    $reference = $input->test_normal_baby;
                                                    @endphp
                                                @else
                                                    @php
                                                    $reference = $input->test_normal_general;
                                                    @endphp
                                                @endif
                                            <tr>
                                                <td>{{ $input->service_name }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('lab.entryresult') }}" method="POST" id="entryHematology">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PUT" />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <input type="hidden" name="id" value="{{ $input->id }}" id="id" >
                                                        <input type="hidden" name="service_reference" value="{{ $reference }}" id="service_reference" >
                                                        <input type="hidden" name="service_time_result" value="{{ date('Y-m-d H:i:s') }}" id="service_time_result" >
                                                        <input type="hidden" name="service_handler" value="{{ auth()->user()->name }}" id="service_handler" >
                                                        <input type="text" class="form-control mt-3" name="service_result" value="{{ $input->service_result }}" id="serviceResultHematology">
                                                    </form>
                                                </td>
                                                <td class="text-center">{{ $reference }}</td>
                                                <td class="text-center">{{ $input->test_unit }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-2">
                                    <h4>Biochemistry</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-2"
                                    data-parent="#accordion">
                                    {{-- Biochemistry --}}
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <tr class="text-center">
                                                <th>Parameter</th>
                                                <th>Result</th>
                                                <th>Reference Range</th>
                                                <th>Unit</th>
                                            </tr>
                                            @php
                                                $no = 0;
                                            @endphp
                                            @foreach ($biochemistry as $input)
                                                {{-- SET REFERENCE RANGE --}}
                                                @php
                                                    $gender = $patient->patient_gender;
                                                    $age = $age;
                                                @endphp
                                                @if ($age > 12 && $age <= 100)
                                                    @if ($gender == 'male')
                                                        @php
                                                        $reference = $input->test_normal_male;
                                                        @endphp
                                                    @elseif ($gender == 'female')
                                                        @php
                                                        $reference = $input->test_normal_female;
                                                        @endphp
                                                    @endif
                                                @elseif ($age > 1 && $age <= 12)
                                                    @php
                                                    $reference = $input->test_normal_child;
                                                    @endphp
                                                @elseif ($age <= 1)
                                                    @php
                                                    $reference = $input->test_normal_baby;
                                                    @endphp
                                                @else
                                                    @php
                                                    $reference = $input->test_normal_general;
                                                    @endphp
                                                @endif
                                            <tr>
                                                <td>{{ $input->service_name }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('lab.entryresult') }}" method="POST" id="entryBiochemistry">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PUT" />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <input type="hidden" name="id" value="{{ $input->id }}" id="id" >
                                                        <input type="hidden" name="service_reference" value="{{ $reference }}" id="service_reference" >
                                                        <input type="hidden" name="service_time_result" value="{{ date('Y-m-d H:i:s') }}" id="service_time_result" >
                                                        <input type="hidden" name="service_handler" value="{{ auth()->user()->name }}" id="service_handler" >
                                                        <input type="text" class="form-control mt-3" name="service_result" value="{{ $input->service_result }}" id="serviceResultBiochemistry">
                                                    </form>
                                                </td>
                                                <td class="text-center">{{ $reference }}</td>
                                                <td class="text-center">{{ $input->test_unit }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-3">
                                    <h4>Immunology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-3"
                                    data-parent="#accordion">
                                    {{-- Immunology --}}
                                    <div class="table-responsive">
                                        <table class="table-striped table">
                                            <tr class="text-center">
                                                <th>Parameter</th>
                                                <th>Result</th>
                                                <th>Reference Range</th>
                                                <th>Unit</th>
                                            </tr>
                                            @foreach ($immunology as $input)
                                                {{-- SET REFERENCE RANGE --}}
                                                @php
                                                    $gender = $patient->patient_gender;
                                                    $age = $age;
                                                @endphp
                                                @if ($age > 12 && $age <= 100)
                                                    @if ($gender == 'male')
                                                        @php
                                                        $reference = $input->test_normal_male;
                                                        @endphp
                                                    @elseif ($gender == 'female')
                                                        @php
                                                        $reference = $input->test_normal_female;
                                                        @endphp
                                                    @endif
                                                @elseif ($age > 1 && $age <= 12)
                                                    @php
                                                    $reference = $input->test_normal_child;
                                                    @endphp
                                                @elseif ($age <= 1)
                                                    @php
                                                    $reference = $input->test_normal_baby;
                                                    @endphp
                                                @else
                                                    @php
                                                    $reference = $input->test_normal_general;
                                                    @endphp
                                                @endif
                                            <tr>
                                                <td>{{ $input->service_name }}</td>
                                                <td class="text-center">
                                                    <form action="{{ route('lab.entryresult') }}" method="POST" id="entryImmunology">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PUT" />
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                        <input type="hidden" name="id" value="{{ $input->id }}" id="id" >
                                                        <input type="hidden" name="service_reference" value="{{ $reference }}" id="service_reference" >
                                                        <input type="hidden" name="service_time_result" value="{{ date('Y-m-d H:i:s') }}" id="service_time_result" >
                                                        <input type="hidden" name="service_handler" value="{{ auth()->user()->name }}" id="service_handler" >
                                                        @if ($reference == "Non Reactive" || $reference == "Reactive")
                                                            <select name="service_result" class="form-control mt-3" id="serviceResultImmunology" required>
                                                                <option value="{{ $input->service_result }}">
                                                                    @if($input->service_result == null || $input->service_result == "")
                                                                        - Select -
                                                                    @else
                                                                        {{ $input->service_result }}
                                                                    @endif
                                                                </option>
                                                                <option value="Non Reactive">Non Reactive</option>
                                                                <option value="Reactive">Reactive</option>
                                                            </select>
                                                        @elseif ($reference == "Negative" || $reference == "Positive")
                                                            <select name="service_result" class="form-control mt-3" id="serviceResultImmunology" required>
                                                                <option value="{{ $input->service_result }}">
                                                                    @if($input->service_result == null || $input->service_result == "")
                                                                        - Select -
                                                                    @else
                                                                        {{ $input->service_result }}
                                                                    @endif
                                                                </option>
                                                                <option value="Negative">Negative</option>
                                                                <option value="Positive">Positive</option>
                                                            </select>
                                                        @else
                                                            <input type="text" class="form-control mt-3" name="service_result" value="{{ $input->service_result }}" id="serviceResultImmunology" required>
                                                        @endif
                                                    </form>
                                                </td>
                                                <td class="text-center">{{ $reference }}</td>
                                                <td class="text-center">{{ $input->test_unit }}</td>
                                            </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-4">
                                    <h4>Microbiology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-4"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-5">
                                    <h4>Urinology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-5"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-6">
                                    <h4>Bacteriology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-6"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-7">
                                    <h4>Parasitology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-7"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-8">
                                    <h4>Virology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-8"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-9">
                                    <h4>Genomics</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-9"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-10">
                                    <h4>Serology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-10"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-11">
                                    <h4>Toxicology</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-11"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                            <div class="accordion">
                                <div class="accordion-header"
                                    role="button"
                                    data-toggle="collapse"
                                    data-target="#panel-body-12">
                                    <h4>Other</h4>
                                </div>
                                <div class="accordion-body collapse"
                                    id="panel-body-12"
                                    data-parent="#accordion">
                                    <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                                        do eiusmod
                                        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                                        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                                        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat
                                        non
                                        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END INPUT LABORATORY --}}
            </div>
        </section>
    </div>
@endsection
<script src="{{ asset('library/jquery/dist/jquery371.min.js') }}" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- SCRIPT REMOVE DUPLICATE SELECT OPTION --}}
<script>
    $(document).ready(function()
    {
        var usedNames = {};
        $("select > option").each(function () {
            if (usedNames[this.value]) {
                $(this).remove();
            } else {
                usedNames[this.value] = this.text;
            }
        });
    });
</script>
{{-- SCRIPT INPUT RESULT --}}
{{-- HEMATOLOGY --}}
<script>
    $(document).ready(function() {
        $('#serviceResultHematology').on('change', function() {
        var result = $(this).val();
        if(result)
            {
                $.ajax({
                    url: '/entryresult',
                    type: "post",
                    data : jQuery('#entryHematology').serialize(),
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                    }
                });
            } else
            {
                $('#serviceResultHematology').empty();
            }
        });
    });
</script>
{{-- BIOCHEMISTRY --}}
<script>
    $(document).ready(function() {
        $('#serviceResultBiochemistry').on('change', function() {
        var result = $(this).val();
        if(result)
            {
                $.ajax({
                    url: '/entryresult',
                    type: "post",
                    data : jQuery('#entryBiochemistry').serialize(),
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                    }
                });
            } else
            {
                $('#serviceResultBiochemistry').empty();
            }
        });
    });
</script>
{{-- IMMUNOLOGY --}}
<script>
    $(document).ready(function() {
        $('#serviceResultImmunology').on('change', function() {
        var result = $(this).val();
        if(result)
            {
                $.ajax({
                    url: '/entryresult',
                    type: "post",
                    data : jQuery('#entryImmunology').serialize(),
                    cache: false,
                    success:function(data)
                    {
                        console.log(data);
                    }
                });
            } else
            {
                $('#serviceResultImmunology').empty();
            }
        });
    });
</script>
{{-- <script>
    $(document).ready(function()
    {
        $('#entry').submit(function(event)
            {
                event.preventDefault();
                jQuery.ajax({
                    url: "/entryresult",
                    data: jQuery('#entry').serialize(),
                    type: "post",
                    cache: false,
                    success: function(data)
                    {
                        console.log(data);
                    }
                });
            });
    });
</script> --}}
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

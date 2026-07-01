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
                            {{-- HEMATOLOGY --}}
                            @if ($hematology->count() > 0)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-1">
                                        <h4>Hematology</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-1" data-parent="#accordion">
                                        {{-- Hematology --}}
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="hematology">
                                                @php
                                                    $no = 0;
                                                @endphp
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
                                                            <form action="" method="POST" id="entryHematology">
                                                                @csrf
                                                                <input type="hidden" name="_method" id="method"
                                                                    value="PUT" />
                                                                <input type="hidden" name="_token" id="token"
                                                                    value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="service_reference"
                                                                    value="{{ $reference }}" id="service_reference">
                                                                <input type="hidden" name="service_time_result"
                                                                    value="{{ date('Y-m-d H:i:s') }}"
                                                                    id="service_time_result">
                                                                <input type="hidden" name="service_handler"
                                                                    value="{{ auth()->user()->name }}" id="service_handler">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $input->id }}" id="id_data">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="service_result"
                                                                    value="{{ $input->service_result }}"
                                                                    id="serviceResultHematology">
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
                            @endif
                            {{-- BIOCHEMISTRY --}}
                            @if ($biochemistry->count() > 0)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-2">
                                        <h4>Biochemistry</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-2" data-parent="#accordion">
                                        {{-- Biochemistry --}}
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="biochemistry">
                                                @php
                                                    $no = 0;
                                                @endphp
                                                <tr class="text-center">
                                                    <th>Parameter</th>
                                                    <th>Result</th>
                                                    <th>Reference Range</th>
                                                    <th>Unit</th>
                                                </tr>
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
                                                            <form action="" method="POST" id="entryBiochemistry">
                                                                @csrf
                                                                <input type="hidden" name="_method" id="method"
                                                                    value="PUT" />
                                                                <input type="hidden" name="_token" id="token"
                                                                    value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="service_reference"
                                                                    value="{{ $reference }}" id="service_reference">
                                                                <input type="hidden" name="service_time_result"
                                                                    value="{{ date('Y-m-d H:i:s') }}"
                                                                    id="service_time_result">
                                                                <input type="hidden" name="service_handler"
                                                                    value="{{ auth()->user()->name }}" id="service_handler">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $input->id }}" id="id_data">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="service_result"
                                                                    value="{{ $input->service_result }}"
                                                                    id="serviceResultBiochemistry">
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
                            @endif
                            {{-- IMMUNOLOGY --}}
                            @if ($immunology->count() > 0)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-3">
                                        <h4>Immunology</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-3" data-parent="#accordion">
                                        {{-- Immunology --}}
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="immunology">
                                                @php
                                                    $no = 0;
                                                @endphp
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
                                                            <form action="" method="POST" id="entryImmunology">
                                                                @csrf
                                                                <input type="hidden" name="_method" id="method"
                                                                    value="PUT" />
                                                                <input type="hidden" name="_token" id="token"
                                                                    value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="service_reference"
                                                                    value="{{ $reference }}" id="service_reference">
                                                                <input type="hidden" name="service_time_result"
                                                                    value="{{ date('Y-m-d H:i:s') }}"
                                                                    id="service_time_result">
                                                                <input type="hidden" name="service_handler"
                                                                    value="{{ auth()->user()->name }}" id="service_handler">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $input->id }}" id="id_data">
                                                                @if ($reference == "Reactive" || $reference == "Non Reactive")
                                                                    <select name="service_result" id="serviceResultImmunology" class="form-control" required>
                                                                        <option value="">-Select-</option>
                                                                        <option value="Reactive">Reactive</option>
                                                                        <option value="Non Reactive">Non Reactive</option>
                                                                    </select>
                                                                @elseif ($reference == "Positive" || $reference == "Negative")
                                                                    <select name="service_result" id="serviceResultImmunology" class="form-control" required>
                                                                        <option value="">-Select-</option>
                                                                        <option value="Positive">Positive</option>
                                                                        <option value="Negative">Negative</option>
                                                                    </select>
                                                                @else
                                                                    <input type="text" class="form-control mt-3"
                                                                        name="service_result"
                                                                        value="{{ $input->service_result }}"
                                                                        id="serviceResultImmunology">
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
                            @endif
                            {{-- MICROBIOLOGY --}}
                            @if ($microbiology->count() > 0)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-4">
                                        <h4>Microbiology</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-4" data-parent="#accordion">
                                        {{-- Microbiology --}}
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="microbiology">
                                                @php
                                                    $no = 0;
                                                @endphp
                                                <tr class="text-center">
                                                    <th>Parameter</th>
                                                    <th>Result</th>
                                                    <th>Reference Range</th>
                                                    <th>Unit</th>
                                                </tr>
                                                @foreach ($microbiology as $input)
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
                                                            <form action="" method="POST" id="entryMicrobiology">
                                                                @csrf
                                                                <input type="hidden" name="_method" id="method"
                                                                    value="PUT" />
                                                                <input type="hidden" name="_token" id="token"
                                                                    value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="service_reference"
                                                                    value="{{ $reference }}" id="service_reference">
                                                                <input type="hidden" name="service_time_result"
                                                                    value="{{ date('Y-m-d H:i:s') }}"
                                                                    id="service_time_result">
                                                                <input type="hidden" name="service_handler"
                                                                    value="{{ auth()->user()->name }}" id="service_handler">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $input->id }}" id="id_data">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="service_result"
                                                                    value="{{ $input->service_result }}"
                                                                    id="serviceResultMicrobiology">
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
                            @endif
                            {{-- URINOLOGY --}}
                            @if ($urinology->count() > 0)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-5">
                                        <h4>Urinology</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-5" data-parent="#accordion">
                                        {{-- Urinology --}}
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="urinology">
                                                @php
                                                    $no = 0;
                                                @endphp
                                                <tr class="text-center">
                                                    <th>Parameter</th>
                                                    <th>Result</th>
                                                    <th>Reference Range</th>
                                                    <th>Unit</th>
                                                </tr>
                                                @foreach ($urinology as $input)
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
                                                            <form action="" method="POST" id="entryUrinology">
                                                                @csrf
                                                                <input type="hidden" name="_method" id="method"
                                                                    value="PUT" />
                                                                <input type="hidden" name="_token" id="token"
                                                                    value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="service_reference"
                                                                    value="{{ $reference }}" id="service_reference">
                                                                <input type="hidden" name="service_time_result"
                                                                    value="{{ date('Y-m-d H:i:s') }}"
                                                                    id="service_time_result">
                                                                <input type="hidden" name="service_handler"
                                                                    value="{{ auth()->user()->name }}" id="service_handler">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $input->id }}" id="id_data">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="service_result"
                                                                    value="{{ $input->service_result }}"
                                                                    id="serviceResultUrinology">
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
                            @endif
                            @if ($bacteriology->count() > 0)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-6">
                                        <h4>Bacteriology</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-6" data-parent="#accordion">
                                        {{-- Bacteriology --}}
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="bacteriology">
                                                @php
                                                    $no = 0;
                                                @endphp
                                                <tr class="text-center">
                                                    <th>Parameter</th>
                                                    <th>Result</th>
                                                    <th>Reference Range</th>
                                                    <th>Unit</th>
                                                </tr>
                                                @foreach ($bacteriology as $input)
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
                                                            <form action="" method="POST" id="entryBacteriology">
                                                                @csrf
                                                                <input type="hidden" name="_method" id="method"
                                                                    value="PUT" />
                                                                <input type="hidden" name="_token" id="token"
                                                                    value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="service_reference"
                                                                    value="{{ $reference }}" id="service_reference">
                                                                <input type="hidden" name="service_time_result"
                                                                    value="{{ date('Y-m-d H:i:s') }}"
                                                                    id="service_time_result">
                                                                <input type="hidden" name="service_handler"
                                                                    value="{{ auth()->user()->name }}" id="service_handler">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $input->id }}" id="id_data">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="service_result"
                                                                    value="{{ $input->service_result }}"
                                                                    id="serviceResultBacteriology">
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
                            @endif
                            {{-- OTHER --}}
                            @if ($other->count() > 0)
                                <div class="accordion">
                                    <div class="accordion-header" role="button" data-toggle="collapse"
                                        data-target="#panel-body-7">
                                        <h4>Other</h4>
                                    </div>
                                    <div class="accordion-body collapse" id="panel-body-7" data-parent="#accordion">
                                        {{-- Other --}}
                                        <div class="table-responsive">
                                            <table class="table-striped table" id="other">
                                                @php
                                                    $no = 0;
                                                @endphp
                                                <tr class="text-center">
                                                    <th>Parameter</th>
                                                    <th>Result</th>
                                                    <th>Reference Range</th>
                                                    <th>Unit</th>
                                                </tr>
                                                @foreach ($other as $input)
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
                                                            <form action="" method="POST" id="entryOther">
                                                                @csrf
                                                                <input type="hidden" name="_method" id="method"
                                                                    value="PUT" />
                                                                <input type="hidden" name="_token" id="token"
                                                                    value="{{ csrf_token() }}" />
                                                                <input type="hidden" name="service_reference"
                                                                    value="{{ $reference }}" id="service_reference">
                                                                <input type="hidden" name="service_time_result"
                                                                    value="{{ date('Y-m-d H:i:s') }}"
                                                                    id="service_time_result">
                                                                <input type="hidden" name="service_handler"
                                                                    value="{{ auth()->user()->name }}" id="service_handler">
                                                                <input type="hidden" name="id"
                                                                    value="{{ $input->id }}" id="id_data">
                                                                <input type="text" class="form-control mt-3"
                                                                    name="service_result"
                                                                    value="{{ $input->service_result }}"
                                                                    id="serviceResultOther">
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
                            @endif
                        </div>
                        {{-- BUTTON SAVE RESULT --}}
                        <div class="row">
                            <div class="col-12 text-right">
                                <button href="#" class="btn btn-success mt-2 mb-2" data-toggle="modal" data-target="#saveModal">Save All Result</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END INPUT LABORATORY --}}
            </div>
        </section>
    </div>
    {{-- MODAL SAVE RESULTS --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="saveModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Save Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>The entered results <b class="text-danger">cannot be changed</b> and will be verified and validated by the validator. Click save if you are sure the laboratory results have been entered correctly.</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <form action="{{ route('lab.updateresult', $visit->visit_registration_id) }}" method="POST" class="ml-2">
                        <input type="hidden" name="_method" value="PUT" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        <input type="hidden" name="visit_status_timeline" value="Validation" />
                        <button class="btn btn-sm btn-success btn-icon">
                            Confirm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- SCRIPT REMOVE DUPLICATE SELECT OPTION --}}
@section('script')
    <script>
        $(document).ready(function() {
            var usedNames = {};
            $("select > option").each(function() {
                if (usedNames[this.value]) {
                    $(this).remove();
                } else {
                    usedNames[this.value] = this.text;
                }
            });
        });
        // {{-- SCRIPT INPUT RESULT --}}
        // {{-- HEMATOLOGY --}}
        $(document).ready(function() {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#hematology tr').each(function() {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var reference = $this.find('input[id="service_reference"]').val();
                var input_result = $this.find('input[name^="service_result"]');
                input_result.on('change', function() {
                    var result = $(this).val();
                    if (result) {
                        $.ajax({
                            url: '{{ route('lab.entryresult') }}',
                            type: "POST",
                            data: {
                                'id': id,
                                '_method': $('#method').val(),
                                '_token': $('#token').val(),
                                'service_reference': reference,
                                'service_time_result': $('#service_time_result').val(),
                                'service_handler': $('#service_handler').val(),
                                'service_result': result
                            },
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    } else {
                        $('#serviceResultHematology').empty();
                    }
                });
            });
        });
        // {{-- BIOCHEMISTRY --}}
        $(document).ready(function() {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#biochemistry tr').each(function() {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var reference = $this.find('input[id="service_reference"]').val();
                var input_result = $this.find('input[name^="service_result"]');
                input_result.on('change', function() {
                    var result = $(this).val();
                    console.log('ID:' + id, 'reference:' + reference, 'result:' + result); //INI YA ? iyaa mas betul biar tau data yang diinput
                    if (result) {
                        $.ajax({
                            url: '{{ route('lab.entryresult') }}',
                            type: "POST",
                            data: {
                                'id': id,
                                '_method': $('#method').val(),
                                '_token': $('#token').val(),
                                'service_reference': reference,
                                'service_time_result': $('#service_time_result').val(),
                                'service_handler': $('#service_handler').val(),
                                'service_result': result
                            },
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    } else {
                        $('#serviceResultBiochemistry').empty();
                    }
                });
            });
        });
        // {{-- IMMUNOLOGY --}}
        $(document).ready(function() {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#immunology tr').each(function() {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var reference = $this.find('input[id="service_reference"]').val();
                var select_result = $this.find('select[name^="service_result"]');
                var input_result = $this.find('input[name^="service_result"]');
                input_result.on('change', function() {
                    var result = $(this).val();
                    if (result) {
                        $.ajax({
                            url: '{{ route('lab.entryresult') }}',
                            type: "POST",
                            data: {
                                'id': id,
                                '_method': $('#method').val(),
                                '_token': $('#token').val(),
                                'service_reference': reference,
                                'service_time_result': $('#service_time_result').val(),
                                'service_handler': $('#service_handler').val(),
                                'service_result': result
                            },
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    } else {
                        $('#serviceResultImmunology').empty();
                    }
                });
                select_result.on('change', function() {
                    var result = $(this).val();
                    if (result) {
                        $.ajax({
                            url: '{{ route('lab.entryresult') }}',
                            type: "POST",
                            data: {
                                'id': id,
                                '_method': $('#method').val(),
                                '_token': $('#token').val(),
                                'service_reference': reference,
                                'service_time_result': $('#service_time_result').val(),
                                'service_handler': $('#service_handler').val(),
                                'service_result': result
                            },
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    } else {
                        $('#serviceResultImmunology').empty();
                    }
                });
            });
        });
        // {{-- MICROBIOLOGY --}}
        $(document).ready(function() {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#microbiology tr').each(function() {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var reference = $this.find('input[id="service_reference"]').val();
                var input_result = $this.find('input[name^="service_result"]');
                input_result.on('change', function() {
                    var result = $(this).val();
                    if (result) {
                        $.ajax({
                            url: '{{ route('lab.entryresult') }}',
                            type: "POST",
                            data: {
                                'id': id,
                                '_method': $('#method').val(),
                                '_token': $('#token').val(),
                                'service_reference': reference,
                                'service_time_result': $('#service_time_result').val(),
                                'service_handler': $('#service_handler').val(),
                                'service_result': result
                            },
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    } else {
                        $('#serviceResultMicrobiology').empty();
                    }
                });
            });
        });
        // {{-- URINOLOGY --}}
        $(document).ready(function() {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#urinology tr').each(function() {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var reference = $this.find('input[id="service_reference"]').val();
                var input_result = $this.find('input[name^="service_result"]');
                input_result.on('change', function() {
                    var result = $(this).val();
                    if (result) {
                        $.ajax({
                            url: '{{ route('lab.entryresult') }}',
                            type: "POST",
                            data: {
                                'id': id,
                                '_method': $('#method').val(),
                                '_token': $('#token').val(),
                                'service_reference': reference,
                                'service_time_result': $('#service_time_result').val(),
                                'service_handler': $('#service_handler').val(),
                                'service_result': result
                            },
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    } else {
                        $('#serviceResultUrinology').empty();
                    }
                });
            });
        });
        // {{-- BACTERIOLOGY --}}
        $(document).ready(function() {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#bacteriology tr').each(function() {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var reference = $this.find('input[id="service_reference"]').val();
                var input_result = $this.find('input[name^="service_result"]');
                input_result.on('change', function() {
                    var result = $(this).val();
                    if (result) {
                        $.ajax({
                            url: '{{ route('lab.entryresult') }}',
                            type: "POST",
                            data: {
                                'id': id,
                                '_method': $('#method').val(),
                                '_token': $('#token').val(),
                                'service_reference': reference,
                                'service_time_result': $('#service_time_result').val(),
                                'service_handler': $('#service_handler').val(),
                                'service_result': result
                            },
                            cache: false,
                            success: function(data) {
                                console.log(data);
                            }
                        });
                    } else {
                        $('#serviceResultBacteriology').empty();
                    }
                });
            });
        });
    </script>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

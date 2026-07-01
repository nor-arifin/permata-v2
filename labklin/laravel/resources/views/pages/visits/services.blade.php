@extends('layouts.app')

@section('title', 'Request Service')

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
            <h1>Patient Service Request</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Visit</a></div>
                <div class="breadcrumb-item">Service</div>
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
            <form action="{{ route('visits.serviceupdate', $visit->id) }}" id="form-id" method="POST">
                @csrf
                @method('put')
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
                                            style="display: inline-block; text-align:left; font-weight: bold;">Department</label>
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
                {{-- LAB REQUEST --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Laboratory Request</h4>
                    </div>
                    <div class="card-body">
                        {{-- ON EDITING --}}
                        <div class="form-group row">
                            <div class="form-group col-3">
                                <label for="nama_barang">Laboratory Test</label>
                                <select value="{{ old('test_code') }}" class="form-control" id="test_code" required>
                                    <option value="">- Select Test -</option>
                                    @foreach ($laboratories as $lab)
                                        <option value="{{ $lab->test_code ?? '' }}">{{ $lab->test_name ?? '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="test_name" value="">
                            <div class="form-group col-2">
                                <label>LOINC Code</label>
                                <input type="text" id="test_loinc_code" value="" class="form-control">
                            </div>
                            <div class="form-group col-2">
                                <label>Method</label>
                                <input type="text" id="test_method" value="" readonly class="form-control">
                            </div>
                            <div class="form-group col-2">
                                <label>Group</label>
                                <input type="text" id="test_group" value="" readonly class="form-control">
                            </div>
                            <div class="form-group col-2">
                                <label>Price</label>
                                <input type="number" id="test_price" value="" class="form-control" readonly>
                            </div>
                            <div class="form-group col-1">
                                <label for="">&nbsp;</label>
                                <button type="button" class="btn btn-success btn-md btn-block" id="tambah"><i
                                        class="fa fa-plus"></i></button>
                            </div>
                            {{-- SHOW CART FROM TAMBAH LABORATORY TEST --}}
                            <div class="form-group col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-md" id="cart">
                                        <thead>
                                            <tr>
                                                <th>Laboratory Test</th>
                                                <th>LOINC Code</th>
                                                <th>Method</th>
                                                <th>Group</th>
                                                <th>Price</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- SERVICE REQUEST --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Estimate Charge :</h4>
                    </div>
                    <div class="card-body">
                        <b>Total Charge Before Tax : <span>Rp. <b id="total">0</b></span></b>
                    </div>
                </div>
                <div class="card">
                    <div class="card-footer text-right">
                        <a class="btn btn-primary" id="submit" href="javascript:;" onclick="save()">Request
                            Service</a>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@push('scripts')
    {{-- SCRIPT GET LAB ITEM DETAIL --}}
    <script>
        $(document).ready(function () {
            $('#test_code').on('change', function () {
                var test_code = $(this).val();
                // var local = {{ url('/addcartlab') }};
                if (test_code) {
                    $.ajax({
                        url: '/getLab/' + test_code,
                        type: "GET",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data) {
                                $.each(data, function (code, laboratories) {
                                    console.log(laboratories);
                                    document.getElementById('test_name').value =
                                        laboratories.test_name;
                                    document.getElementById('test_loinc_code').value =
                                        laboratories.test_loinc_code;
                                    document.getElementById('test_method').value =
                                        laboratories.test_method;
                                    document.getElementById('test_group').value =
                                        laboratories.test_group;
                                    document.getElementById('test_price').value =
                                        laboratories.test_price;
                                    // a = document.getElementById('tambah');
                                    // a.setAttribute('href',
                                    //     'localhost:9000/add-to-cart/' + laboratories
                                    //     .id);
                                });
                            } else {
                                $('#test_loinc_code').empty();
                                $('#test_method').empty();
                                $('#test_group').empty();
                                $('#test_price').empty();
                            }
                        }
                    });
                } else {
                    $('#test_name').empty();
                }
            });
        });

        //Menambahkan Add Row Dan Delete
        let count = 1;
        let sum = 0;
        // Adding row on click to Add New Row button
        var tambah = $('#tambah').click(function () {
            var test_name = $('#test_name').val();
            var test_code = $('#test_code').val();
            var test_loinc_code = $('#test_loinc_code').val();
            var test_method = $('#test_method').val();
            var test_group = $('#test_group').val();
            var test_price = $('#test_price').val();
            $('#tbody').append("<tr><td><input class='form-control' name='test_name[]' readonly value='" + test_name +
                "'></td> <input type='hidden' class='form-control' readonly name='test_code[]' value='" +
                test_code +
                "'><td> <input class='form-control' readonly name='test_loinc_code[]' value='" +
                test_loinc_code +
                "'></td><td><input class='form-control' readonly name='test_method[]' value='" + test_method +
                "'></td><td><input class='form-control' readonly name='test_group[]' value='" +
                test_group + "'></td><td><input class='form-control'readonly name='test_price[]' value='" +
                test_price +
                "'></td><td><a href='javasript:;'class='btn btn-md btn-danger del'><i class='fa fa-trash'></i></a></td></tr>"
            );
            var sub_total = parseFloat(test_price);
            sum += sub_total
            $('#total').html(sum)
            count++;
        });
        // Removing Row on click to Remove button
        var hapus = $('#tbody').on('click', '.del', function () {
            var test_price = $('#test_price').val();
            var sub_total = parseFloat(test_price);
            sum -= sub_total
            $('#total').html(sum)
            $(this).closest('tr').remove();
        });

        function save() {
            const array = [...document.querySelectorAll("table tbody tr")].map((row) => {
                const [test_name, test_code, test_loinc_code, test_method, test_group, test_price] = [...row
                    .querySelectorAll('td')
                ].map(td => td.textContent.trim());
                var result_name = document.getElementById("test_name").value = test_name
                var result_code = document.getElementById("test_code").value = test_code
                var result_loinc_code = document.getElementById("test_loinc_code").value = test_loinc_code
                var result_method = document.getElementById("test_method").value = test_method
                var result_group = document.getElementById("test_group").value = test_group
                var result_price = document.getElementById("test_price").value = test_price

                return {
                    result_name,
                    result_code,
                    result_loinc_code,
                    result_method,
                    result_group,
                    result_price
                }
            });
            $('#form-id').submit();
        }
    </script>
@endpush
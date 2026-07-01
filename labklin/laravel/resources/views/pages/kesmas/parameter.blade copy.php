@extends('layouts.app')

@section('title', 'Input Parameter')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Input Parameter</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kesmas</a></div>
                <div class="breadcrumb-item">Order</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            {{-- CUSTOMER --}}
            <div class="card">
                <div class="card-header">
                    <h4>Kesmas Order - No. FPPS : {{ $order->order_code }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Customer Code
                                    </label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_code }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Customer
                                        Name</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_name}} / {{ $order->customer_type }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Contact</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_phone }} / {{ $order->customer_email }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Person
                                        In
                                        Charge</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_pic }} / {{ $order->customer_pic_phone }}
                                    </label>
                                </div>
                                <div class="form-inline mb-2">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Address</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_address}}
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card">
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">
                                        Collected By
                                    </label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ ucfirst($order->order_collector) }} /
                                        {{ ucfirst($order->order_sampling_name) }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Collected
                                        Time</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->order_collect }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Received
                                        Time</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->order_receive }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Laboratory
                                        Division</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->order_type }}
                                    </label>
                                </div>
                                <div class="form-inline mb-2">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Number
                                        of
                                        Sample</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->order_num_sample}} Sample
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sample Parameter -->
            <div class="card">
                <div class="card-header">
                    <h4>Sample Parameter</h4>
                </div>
                <div class="card-body">
                    <div id="sampledetail-wrapper">
                        @foreach ($samples as $data)
                        <div class="form-row sampledetail">
                            <div class="form-group col-md-2">
                                <label for="type">Type</label>
                                @php
                                $sample_types = [
                                'AM' => 'Air Minum',
                                'AH' => 'Air Higiene dan Sanitasi',
                                'AL' => 'Air Limbah',
                                'AS' => 'Air Sungai / Danau',
                                'AK' => 'Air Kolam Renang',
                                'MM' => 'Makanan Minuman',
                                'US' => 'Usap Swab',
                                'KU' => 'Kualitas Udara',
                                'OL' => 'Lainnya',
                                ];
                                $sample_type = $sample_types[$data->sample_type] ?? 'Unknown';
                                @endphp
                                <input type="text" class="form-control" name="type" value="{{ $sample_type }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="sampleid">Customer Sample ID</label>
                                <input type="text" class="form-control" name="sampleid" value="{{ $data->sample_id }}"
                                    readonly>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="condition">Laboratory Code</label>
                                <input type="text" class="form-control" name="samplecode"
                                    value="{{ $data->sample_code }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="container">Container</label>
                                <input type="text" class="form-control" name="container"
                                    value="{{ $data->sample_volume }} {{ $data->sample_container }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="charge">Sample Charge</label>
                                <input type="text" class="form-control" name="charge" id="sample_charge"
                                    value="{{ $data->sample_charge }}" readonly>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-end">
                                <div class="text-center btn btn-success btn-lg add-parameter" data-toggle="tooltip"
                                    data-placement="top" title="Select Parameter" id="{{ $data->id }}"
                                    code="{{ $data->sample_code }}">
                                    <i class="fa-solid fa-tags"></i>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="card-footer">
                    <h6>Total Sample Charge : Rp.
                        <span id="totalSampleCharge">{{ $samples->sum('sample_charge') }}</span>
                    </h6>
                </div>
                {{-- END SAMPLE DETAIL --}}
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Additional Charge</h4>
                </div>
                <form action="{{ route('kesmas.createfpps', $order->idcode) }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="form-row" id="additional-charge">
                            <div class="form-group col-md-8">
                                <label for="addtask">Additional Task</label>
                                <input type="text" class="form-control" name="addtask" id="cusnamesaaddtaskmpler"
                                    value="{{ old('addtask') }}" placeholder="*Optional">
                                @error('addtask')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="Add Charge">Add Charge</label>
                                <input type="text" class="form-control" name="addcharge" id="addcharge"
                                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                    value="{{ old('addcharge', '0') }}" placeholder="0">
                                @error('addcharge')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row" id="total-charge">
                            <div class="form-group col-md-12">
                                <label for="totalcharge">Total Charge</label>
                                <input type="text" class="form-control" name="order_total" id="totalcharge"
                                    value="{{ $samples->sum('sample_charge') }}" readonly>
                            </div>
                        </div>
                        <div class="form-row" id="buttonSave">
                            <input type="hidden" name="idcode" value="{{ $order->idcode }}">
                            <div class="form-group col-md-12 text-right">
                                <button type="submit" class="btn btn-primary" id="submitparameter">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- END SAMPLE DETAIL --}}
        </div>
</div>
{{-- END CUSTOMER --}}
</section>
<!-- Modal -->
<div class="modal fade" id="parameterModal" tabindex="-1" role="dialog" aria-labelledby="parameterModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="parameterModalLabel">Select Parameter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="parameterForm">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="sampleId" name="sampleId" readonly>
                    </div>
                    <div class="form-group">
                        <label for="parameter">Laboratory Code</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="sampleCode" name="sampleCode" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button" id="generateCode">Generate</button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="parameter">Parameter</label>
                        <div class="row">
                            <!-- Parameters will be loaded here dynamically -->
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveParameters" disabled>Save changes</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Success',
        text: '{{ session('
        success ') }}',
        timer: 3000,
        showConfirmButton: false
    });
    @endif
});
</script>
<!-- Check totalcharge is not 0 on click submitparameter-->
<script>
$(document).ready(function() {
    $('#submitparameter').on('click', function() {
        var totalCharge = $('#totalcharge').val();
        if (totalCharge == 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: 'Please, select parameter first!',
                timer: 2000,
                showConfirmButton: false
            });
            return false;
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('.add-parameter').on('click', function() {
        var sampleId = $(this).attr('id');
        var sampleCode = $(this).attr('code');
        $('#sampleId').val(sampleId);
        $('#sampleCode').val(sampleCode);
        $('#parameterModal').modal('show');
        $('#generateCode').show();
        $('#saveParameters').prop('disabled', true);
        // Load parameters dynamically
        $.ajax({
            url: '/kesmas/get-parameters/' + sampleId,
            type: 'GET',
            success: function(response) {
                console.log(response);
                var parameters = response.parameters;
                var selectedParameters = response.selectedParameters;
                var parameterForm = $('#parameterForm .row');
                parameterForm.empty(); // Clear previous parameters

                parameters.forEach(function(parameter) {
                    var isChecked = selectedParameters.includes(parameter
                        .parameter_code) ? 'checked' : '';
                    var checkbox =
                        `
                                                                                                                                                                <div class="col-6">
                                                                                                                                                                    <div class="custom-control custom-checkbox">
                                                                                                                                                                        <input type="checkbox" class="custom-control-input" id="parameter-${parameter.id}" name="parameter[]" value="${parameter.parameter_code}" ${isChecked}>
                                                                                                                                                                        <label class="custom-control-label" for="parameter-${parameter.id}">${parameter.parameter_name}</label>
                                                                                                                                                                    </div>
                                                                                                                                                                </div>`;
                    parameterForm.append(checkbox);
                });
            },
            error: function(response) {
                // Handle error response
            }
        });
    });
    //Generate Code
    $('#generateCode').on('click', function() {
        var sampleId = $('#sampleId').val();
        $.ajax({
            url: '/kesmas/check-code/' + sampleId,
            type: 'GET',
            success: function(response) {
                console.log(response);
                var generatedCode = response.generatedCode;
                $('#sampleCode').val(generatedCode);
                //hide generate button
                $('#generateCode').hide();
                $('#saveParameters').prop('disabled', false);
            },
            error: function(response) {
                alert('Error generating code!');
            }
        });
    });
    //Save Parameter
    $('#saveParameters').on('click', function() {
        var sampleId = $('#sampleId').val();
        var sampleCode = $('#sampleCode').val();
        var parameters = [];
        $('#parameterForm input[type="checkbox"]:checked').each(function() {
            parameters.push($(this).val());
        });
        $.ajax({
            url: '/kesmas/save-parameters',
            type: 'POST',
            data: {
                sample_id: sampleId,
                sample_code: sampleCode,
                parameters: parameters,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    $('#parameterModal').modal('hide');
                    //sweetalert
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.success,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    //delay 2s
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                }
            },
            error: function(response) {
                // Handle error response
            }
        });
    });

});
</script>
<!-- Calculate  totalcharge if addcharge has changes-->
<script>
$(document).ready(function() {
    $('#addcharge').on('input', function() {
        var totalSampleCharge = $('#totalSampleCharge').text();
        var addCharge = $(this).val();
        var totalCharge = parseInt(totalSampleCharge) + parseInt(addCharge);
        $('#totalcharge').val(totalCharge);
    });
});
</script>

@endpush
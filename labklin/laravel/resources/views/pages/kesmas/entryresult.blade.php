@extends('layouts.app')

@section('title', 'Entry Kesmas Result ')

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
                <h1>Entry Kesmas - {{ $order->order_type }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Labkesmas</a></div>
                    <div class="breadcrumb-item">Entry Result {{ $order->order_type }}</div>
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
                <div class="card">
                    <div class="card-header">
                        <h4>Input Kesmas Result - {{ $order->order_type }}</h4>
                    </div>
                    @if ($order->order_note != null)
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 text-left">
                                    <div class="alert alert-warning alert-dismissible show fade">
                                        <div class="alert-body text-dark">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            Reject History : <br>
                                            @foreach ($rejections as $reject)
                                                <span><b>{{ $reject->rejection_user }}</b> : {{ $reject->rejection_reason }}</span>
                                            @endforeach
                                            <br>
                                            <span><i>*This rejection history for internal only.</i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="card-body">
                        <div id="accordion">
                            @foreach ($samples as $sample)
                                                    @php
                                                        $sample_types = [
                                                            'AH' => 'Air Higiene dan Sanitasi',
                                                            'AK' => 'Air Kolam Renang',
                                                            'AT' => 'Air Laut',
                                                            'AL' => 'Air Limbah',
                                                            'AM' => 'Air Minum',
                                                            'AU' => 'Air Pemandian Umum',
                                                            'AP' => 'Air SPA',
                                                            'AS' => 'Air Sungai/Danau',
                                                            'LN' => 'Linen',
                                                            'MS' => 'Alat Masak',
                                                            'MM' => 'Makanan Minuman',
                                                            'US' => 'Usap Swab',
                                                            'MT' => 'Media Tanah',
                                                            'KU' => 'Kualitas Udara',
                                                            'OL' => 'Lainnya',
                                                        ];
                                                        $sample_type = $sample_types[$sample->sample_type] ?? 'Unknown';
                                                    @endphp
                                                    {{-- SAMPLE --}}
                                                    <div class="accordion">
                                                        <div class="accordion-header" role="button" data-toggle="collapse"
                                                            data-target="#panel-body-{{ $sample->id }}">
                                                            <h4>{{ $sample->sample_code }} - {{ $sample->sample_id }} - {{ $sample_type }} -
                                                                {{ $sample->sample_note }}
                                                            </h4>
                                                        </div>
                                                        <div class="accordion-body collapse" id="panel-body-{{ $sample->id }}"
                                                            data-parent="#accordion">
                                                            {{-- PARAMETER --}}
                                                            <div class="table-responsive">
                                                                <table class="table-striped table" id="{{ $sample->id }}">
                                                                    <tr class="text-center text-bold">
                                                                        <th>Parameter</th>
                                                                        <th>Result</th>
                                                                        <th>Reference Range</th>
                                                                        <th>Unit</th>
                                                                    </tr>
                                                                    @foreach ($parameters as $detail)
                                                                        @if ($detail->order_sample_id == $sample->id)
                                                                            <tr>
                                                                                <td>{{ $detail->order_parameter_name }}</td>
                                                                                <td>
                                                                                    <form action="{{ route('labkesmas.saveresult', $detail->id) }}"
                                                                                        method="POST" id="entryResult{{ $detail->id }}">
                                                                                        @csrf
                                                                                        <input type="hidden" name="_method" value="PUT" />
                                                                                        <input type="hidden" name="id" value="{{ $detail->id }}" />
                                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                                        <input type="text" class="form-control" name="parameter_result"
                                                                                            value="{{ $detail->order_parameter_result }}" required>
                                                                                    </form>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <form action="{{ route('labkesmas.savereference', $detail->id) }}"
                                                                                        method="POST" id="entryReferece{{ $detail->id }}">
                                                                                        @csrf
                                                                                        <input type="hidden" name="_method" value="PUT" />
                                                                                        <input type="hidden" name="id" value="{{ $detail->id }}" />
                                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                                        <input type="text" class="form-control" name="parameter_reference"
                                                                                            value="{{ $detail->order_parameter_reference_value }}" required>
                                                                                    </form>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <form action="{{ route('labkesmas.saveunit', $detail->id) }}"
                                                                                        method="POST" id="entryUnit{{ $detail->id }}">
                                                                                        @csrf
                                                                                        <input type="hidden" name="_method" value="PUT" />
                                                                                        <input type="hidden" name="id" value="{{ $detail->id }}" />
                                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                                        <input type="text" class="form-control" name="parameter_unit"
                                                                                            value="{{ $detail->order_parameter_unit }}" required>
                                                                                    </form>
                                                                                </td>
                                                                            </tr>
                                                                        @endif
                                                                    @endforeach
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- END SAMPLE --}}
                            @endforeach
                        </div>
                        {{-- BUTTON SAVE RESULT --}}
                        @if ($order->order_process_user == null)
                            <div class="row">
                                <div class="col-12 text-right">
                                    <button class="btn btn-success mt-2 mb-2" id="saveModal{{ $order->idcode }}">Save
                                        All Result
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="row mt-3">
                                <div class="col-12 text-left">
                                    <span class="badge badge-info">This FPPS Result on verification process. You can't modify
                                        parameter
                                        result.</span>
                                </div>
                            </div>
                        @endif
                        {{-- END BUTTON SAVE RESULT --}}
                    </div>
                </div>
            </div>
            {{-- END CUSTOMER --}}
        </section>
@endsection

    @push('scripts')
        <!-- JS Libraies -->
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <!-- Sweet Alert 2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            $(document).ready(function () {
                $('#saveModal{{ $order->idcode }}').on('click', function () {
                    // Check all input name="parameter_result" if empty
                    var empty = false;
                    $('input[name="parameter_result"]').each(function () {
                        if ($(this).val() == '') {
                            empty = true;
                        }
                    });
                    if (empty) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Please fill all the parameter result',
                        });
                        return;
                    }
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You want to save all the result? Click save if you are sure the laboratory results have been entered correctly",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3800b1',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Save'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            //Get idcode from #saveModal $order->idcode
                            var idcode = '{{ $order->idcode }}';
                            var url = '/labkesmas/saveprocess/:idcode';
                            url = url.replace(':idcode', idcode);
                            $.ajax({
                                url: url,
                                type: 'PUT',
                                data: {
                                    _token: '{{ csrf_token() }}'
                                },
                                success: function (response) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: response.message,
                                    });
                                    setTimeout(function () {
                                        window.location.href = '/labkesmas/entry';
                                    }, 2000);
                                },
                                error: function (response) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error',
                                        text: response.responseJSON.message,
                                    });
                                }
                            });
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $('input[name="parameter_result"]').on('change', function () {
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    var data = form.serialize();
                    console.log(data);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.error ||
                                    'Result Entry Failed. This parameter result under verification process.',
                            });
                        }
                    });
                });
            });
        </script>
        <!-- Reference -->
        <script>
            $(document).ready(function () {
                $('input[name="parameter_reference"]').on('change', function () {
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    var data = form.serialize();
                    console.log(data);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.error ||
                                    'Parameter Reference Change Failed. This parameter result under verification process.',
                            });
                        }
                    });
                });
            });
        </script>
        <!-- Unit -->
        <script>
            $(document).ready(function () {
                $('input[name="parameter_unit"]').on('change', function () {
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    var data = form.serialize();
                    console.log(data);
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            });
                        },
                        error: function (response) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.responseJSON.error ||
                                    'Parameter Unit Change Failed. This parameter result under verification process.',
                            });
                        }
                    });
                });
            });
        </script>

    @endpush
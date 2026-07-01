@extends('layouts.app')

@section('title', 'Verification Kesmas Result ')

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
                <h1>Verification Kesmas - {{ $order->order_type }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Labkesmas</a></div>
                    <div class="breadcrumb-item">Verify Result {{ $order->order_type }}</div>
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
                        <h4>Verify Kesmas Result - {{ $order->order_type }}</h4>
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
                                            <li>{{ \Carbon\Carbon::parse($reject->created_at)->format('d-m-Y H:i') }}
                                                <span><b>{{ $reject->rejection_user }}</b> :
                                                    {{ $reject->rejection_reason }}</span>
                                            </li>
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
                                                            <h4>{{ $sample->sample_code }} - {{ $sample->sample_id }} - {{ $sample_type }}</h4>
                                                        </div>
                                                        <div class="accordion-body collapse" id="panel-body-{{ $sample->id }}"
                                                            data-parent="#accordion">
                                                            {{-- PARAMETER --}}
                                                            <div class="table-responsive">
                                                                <table class="table-striped table-bordered table" id="{{ $sample->id }}">
                                                                    <tr class="text-center text-bold">
                                                                        <th>Parameter</th>
                                                                        <th>Result</th>
                                                                        <th>Reference Range</th>
                                                                        <th>Unit</th>
                                                                        <th>Method</th>
                                                                    </tr>
                                                                    @foreach ($parameters as $detail)
                                                                        @if ($detail->order_sample_id == $sample->id)
                                                                            <tr>
                                                                                <td>{{ $detail->order_parameter_name }}</td>
                                                                                <td class="text-center text-bold">{{ $detail->order_parameter_result }}
                                                                                </td>
                                                                                <td class="text-center">{{ $detail->order_parameter_reference_value }}</td>
                                                                                <td class="text-center">{{ $detail->order_parameter_unit }}</td>
                                                                                <td class="text-left" style="max-width: 150px; word-wrap: break-word;">
                                                                                    <form action="{{ route('labkesmas.savemethod', $detail->id) }}"
                                                                                        method="POST" id="entryMethod{{ $detail->id }}">
                                                                                        @csrf
                                                                                        <input type="hidden" name="_method" value="PUT" />
                                                                                        <input type="hidden" name="id" value="{{ $detail->id }}" />
                                                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                                                                        <input type="text" class="form-control" name="parameter_method"
                                                                                            value="{{ $detail->order_parameter_method }}" required>
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
                    </div>
                    <div class="card-header">
                        <h4>Result Note : (Optional)</h4>
                    </div>
                    <div class="card-body">
                        {{-- BUTTON SAVE RESULT --}}
                        @if ($order->order_verify_user == null)
                            <div class="row">
                                <div class="col-12 text-right">
                                    <input type="textarea" name="note_verify" id="note_verify" value="{{ $order->order_note }}"
                                        class="form-control" placeholder="Note" style="width: 100%;">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12 text-right">
                                    <a href="/labkesmas/draftverify/{{ $order->idcode }}" class="btn btn-warning mt-2 mb-2"
                                        target="_blank">
                                        Draft LHU
                                    </a>
                                    <button class="btn btn-success mt-2 mb-2" id="saveModal{{ $order->idcode }}">Verify
                                        All Result
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="row mt-3">
                                <div class="col-12 text-left">
                                    <span class="badge badge-info">This FPPS Result on validation process.</span>
                                </div>
                            </div>
                        @endif
                        {{-- END BUTTON SAVE RESULT --}}
                    </div>
                </div>
                <div class="card">
                    <div ss="card-body">
                        <div class="row m-3">
                            <div class="col-12 text-center">
                                <button class="btn btn-danger" id="reRun"><i class="fa fa-trash"></i> Cancel Result</button>
                            </div>
                        </div>
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
        <!-- Script for save verify -->
        <script>
            document.getElementById('saveModal{{ $order->idcode }}').addEventListener('click', function () {
                let note = document.getElementById('note_verify').value;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to verify all results.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3800b1',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, verify it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        //Get idcode from #saveModal $order->idcode
                        var idcode = '{{ $order->idcode }}';
                        var url = '/labkesmas/updateverify/:idcode';
                        // get var note from #note_verify
                        var note = $('#note_verify').val();
                        url = url.replace(':idcode', idcode);
                        console.log(note);
                        $.ajax({
                            url: url,
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                note: note
                            },
                            success: function (response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.message,
                                });
                                setTimeout(function () {
                                    window.location.href = '/labkesmas/verify';
                                }, 1000);
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
        </script>

        <!-- Script for rerun test-->
        <script>
            document.getElementById('reRun').addEventListener('click', function () {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to re-run the test.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3800b1',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, re-run it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = '/labkesmas/rerun/:idcode';
                        var idcode = '{{ $order->idcode }}';
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
                                    window.location.href = '/labkesmas/verify';
                                }, 1000);
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
        </script>

        <!-- Reference -->
        <script>
            $(document).ready(function () {
                $('input[name="parameter_method"]').on('change', function () {
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

    @endpush
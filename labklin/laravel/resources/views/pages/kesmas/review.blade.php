@extends('layouts.app')

@section('title', 'FPPS - ' . $order->order_code)

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Review FPPS - {{ $order->order_type }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kesmas</a></div>
                    <div class="breadcrumb-item">FPPS</div>
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
                        <h4>FPPS No. : {{ $order->order_code }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Customer
                                            Name</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->customer_name}} / {{ $order->customer_type }} /
                                            {{ $order->customer_code }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Address</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->customer_address}} -
                                            {{ $order->customer_address_detail }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Person In
                                            Charge</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->customer_pic }} / {{ $order->customer_pic_phone }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Contact /
                                            Email</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->customer_phone }} / {{ $order->customer_email }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Sample
                                            Collector</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ ucfirst($order->order_collector) }} by
                                            {{ ucfirst($order->order_sampling_name) }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Sample
                                            Collected</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->order_collect }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Sample
                                            Received</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->order_collect }}
                                        </label>
                                    </div>
                                    <div class="form-inline mb-3">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Number of
                                            Sample
                                        </label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->order_num_sample }} Sample(s)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>
                                            Sample Description
                                        </h4>
                                    </div>
                                    <!-- Table of Sample -->
                                    <div class="table-responsive p-3">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Customer Sample ID</th>
                                                    <th class="text-center">Sample Code</th>
                                                    <th class="text-center">Sample Type</th>
                                                    <th class="text-center">Sample Note</th>
                                                    <th class="text-center">Sample Container</th>
                                                    <th class="text-center">Charge</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($samples as $sample)
                                                                                            <tr>
                                                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_id }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_code }}</td>
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
                                                                                                        'OL' => 'Lainnya'
                                                                                                    ];
                                                                                                    $sample_type = $sample_types[$sample->sample_type] ?? 'Unknown';
                                                                                                @endphp
                                                                                                <td class="text-center">{{ $sample_type }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_note }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_volume }}
                                                                                                    {{ $sample->sample_container }}
                                                                                                </td>
                                                                                                <td class="text-left">
                                                                                                    Rp.
                                                                                                    {{ number_format($parameters->where('order_sample_id', $sample->id)->sum('order_parameter_price'), 0, ',', '.') }}
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td colspan="6">
                                                                                                    <div class="form-group">
                                                                                                        <label class="font-weight-bold">Parameter</label>
                                                                                                        <!-- Label di atas -->
                                                                                                        <ul class="mt-2">
                                                                                                            @foreach ($parameters as $detail)
                                                                                                                @if ($detail->order_sample_id == $sample->id)
                                                                                                                    <li>{{ $detail->order_parameter_name }}</li>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Table of Sample -->
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('kesmas.savereview', $order->idcode) }}" method="POST">
                            @csrf
                            <!-- Abnormality -->
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Abnormality Note</h4>
                                        </div>
                                        <div class="card-body">
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-3 pt-0">
                                                        <b>Abnormality Sample Condition</b>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" id="expired"
                                                                    name="expired" value="on">
                                                                <label class="form-check-label"
                                                                    for="expired">Kadaluarsa</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="preservatives" name="preservatives" value="on">
                                                                <label class="form-check-label" for="preservatives">Tanpa
                                                                    pengawet</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" id="outlab"
                                                                    name="outlab" value="on">
                                                                <label class="form-check-label" for="outlab">Parameter
                                                                    lapangan
                                                                    diukur di laboratorium</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="outpreservatives" name="outpreservatives"
                                                                    value="on">
                                                                <label class="form-check-label"
                                                                    for="outpreservatives">Pengawet
                                                                    tidak
                                                                    sesuai</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox" id="other"
                                                                    value="on">
                                                                <label class="form-check-label" for="other">Lainnya</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group" id="other_abnormality" style="display: none;">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-3 pt-0">
                                                        <b>Other Abnormality</b>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="abnormality_other"
                                                            name="abnormality_other" placeholder="Other Abnormality">
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Abnormality -->
                            <!-- Review -->
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>Review Order</h4>
                                            <div class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                                title="Reject Order" id="reject">
                                                Reject
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-3 pt-0">
                                                        <b>Personnel Capability</b>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_personnel1"
                                                                name="review_personnel" class="custom-control-input"
                                                                required>
                                                            <label class="custom-control-label" for="review_personnel1"
                                                                value="1">Capable</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_personnel2"
                                                                name="review_personnel" class="custom-control-input"
                                                                required>
                                                            <label class="custom-control-label" for="review_personnel2"
                                                                value="0">Not
                                                                Capable</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-3 pt-0"><b>Accommodation
                                                            conditions</b>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_accomodation1"
                                                                name="review_accomodation" class="custom-control-input"
                                                                required>
                                                            <label class="custom-control-label" for="review_accomodation1"
                                                                value="1">Good Condition</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_accomodation2"
                                                                name="review_accomodation" class="custom-control-input"
                                                                required>
                                                            <label class="custom-control-label" for="review_accomodation2"
                                                                value="0">Bad Condition</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-3 pt-0">
                                                        <b>Workload</b>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_workload1" name="review_workload"
                                                                class="custom-control-input" required>
                                                            <label class="custom-control-label" for="review_workload1"
                                                                value="1">Not Overload</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_workload2" name="review_workload"
                                                                class="custom-control-input" required>
                                                            <label class="custom-control-label" for="review_workload2"
                                                                value="0">Overload</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-3 pt-0"><b>Equipment Condition</b>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_equipment1"
                                                                name="review_equipment" class="custom-control-input"
                                                                required>
                                                            <label class="custom-control-label" for="review_equipment1"
                                                                value="1">Ready Functional</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_equipment2"
                                                                name="review_equipment" class="custom-control-input"
                                                                required>
                                                            <label class="custom-control-label" for="review_equipment2"
                                                                value="0">Malfunctioning</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <div class="col-form-label col-sm-3 pt-0"><b>Method Suitability</b>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_method1" name="review_method"
                                                                class="custom-control-input" required>
                                                            <label class="custom-control-label" for="review_method1"
                                                                value="1">Suitable</label>
                                                        </div>
                                                        <div class="custom-control custom-radio custom-control-inline">
                                                            <input type="radio" id="review_method2" name="review_method"
                                                                class="custom-control-input" required>
                                                            <label class="custom-control-label" for="review_method2"
                                                                value="0">Not Suitable</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-form-label col-sm-3"><b>Note</b>
                                                </div>
                                                <div class="col-sm-9">
                                                    <textarea class="form-control" name="review_note"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-form-label col-sm-3"><b class="text-primary">Conclution</b>
                                                </div>
                                                <div class="col-sm-9">
                                                    <select class="form-control selectric" name="review_conclution"
                                                        required>
                                                        <option value="">- Select -</option>
                                                        <option value="Accept">Accept</option>
                                                        <option value="Reject">Reject</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-group text-right">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Review -->
                        </form>
                    </div>
                </div>
                {{-- END CUSTOMER --}}
            </div>
        </section>
    </div>
@endsection
@push('scripts')

    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Reject Sampel -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#other').on('change', function () {
            if ($(this).is(':checked')) {
                $('#other_abnormality').show();
            } else {
                $('#other_abnormality').hide();
            }
        });
    </script>
    <script>
        $('#reject').on('click', function () {
            // Show Modal Confirmation
            Swal.fire({
                title: 'Reject FPPS Order',
                text: 'Are you sure to reject this order?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, Reject!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirect to Reject Page
                    window.location.href = "{{ route('kesmas.reject', $order->idcode) }}";
                }
            });
        });
    </script>

@endpush
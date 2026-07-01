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
                <h1>FPPS - {{ $order->order_type }}</h1>
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
                                                    <th class="text-center">Sample Container</th>
                                                    <th class="text-center">Sample Description</th>
                                                    <th class="text-center">Parameter</th>
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
                                                                                                    $sample_type = $sample_types[$sample->sample_type] ?? 'Unknown';
                                                                                                @endphp
                                                                                                <td class="text-center">{{ $sample_type }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_volume }}
                                                                                                    {{ $sample->sample_container }}
                                                                                                </td>
                                                                                                <td class="text-center">{{ $sample->sample_description }}</td>
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

    <!-- Load Element Sampel -->

@endpush
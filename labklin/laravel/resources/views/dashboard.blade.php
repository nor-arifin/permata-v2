@extends('layouts.app')

@section('title', 'General Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet"
        href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>
            <h2 class="section-title mt-0">Total Statistics</h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Total Patients</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $patients->count() }} </b><span>Patient</span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Total Visits</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $visits->count() }} </b><span>Visit</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Laboratory Order</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $laboratories->count() }} </b><span>Order</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-book-medical"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Medical Reports</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $reports->count() }} </b><span>Report</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @php
                $thisdate = Carbon\Carbon::now()->format('M Y');
            @endphp
            <h2 class="section-title mt-0">Today Statistics  </h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Patients</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $patientd->count() }} </b><span>New Patient</span><br>
                                <div class="text-primary"><sup>Total {{ $patient->count() }} on {{ $thisdate }}</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Visits</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $visitd->count() }} </b><span>Visit</span><br>
                                <div class="text-primary"><sup>Total {{ $visit->count() }} on {{ $thisdate }}</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-flask"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Laboratory Task</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $laboratoryd->count() }} </b><span>Order</span><br>
                                <div class="text-primary"><sup>Total {{ $laboratory->count() }} on {{ $thisdate }}</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-money-check-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Today Revenue</h4>
                            </div>
                            <div class="card-body">
                                <b>Rp. {{ number_format($amountd, 0, ',', '.') }} </b><br>
                                <div class="text-primary"><sup>Total Rp. {{ number_format($amount, 0, ',', '.') }}</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ROLE IS NOT LABORATORY --}}
            @if( auth()->user()->role === 'admin' || auth()->user()->role === 'laboratory' || auth()->user()->role === 'validator')
            <h2 class="section-title mt-0">Laboratory Statistics  </h2>
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-syringe"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Sampling Queue</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $collection }} </b><span>Patient</span><br>
                                <div class="text-primary"><sup>{{ $collectiondone }} Complete Today</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-danger">
                            <i class="fas fa-vials"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Receive Queue</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $receive }} </b><span>Patient</span><br>
                                <div class="text-primary"><sup>{{ $receivedone }} Complete Today</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-microscope"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Test Queue</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $test }} </b><span>Order</span><br>
                                <div class="text-primary"><sup>{{ $testdone }} Complete Today</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-file-medical-alt"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4 class="text-primary">Validation Queue</h4>
                            </div>
                            <div class="card-body">
                                <b>{{ $validation }} </b><span>Report</span><br>
                                <div class="text-primary"><sup>{{ $validationdone }} Validated Today</sup></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- ROLE IS NOT ADMIN --}}
            @if(auth()->user()->role === 'admin')
            <h2 class="section-title mt-0">Overview Chart  </h2>
            <div class="row">
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ date('Y') }} Visit Chart</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myChart2"
                                height="128">
                            </canvas>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>{{ date('Y') }} Revenue Chart</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="myRevenue"
                                height="128">
                            </canvas>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </section>
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>

    <script>
    const ctx = document.getElementById('myChart2');
    new Chart(ctx, {
        type: 'line',
        data: {
            //DATA 01 - 31
        labels: @json($months),
        datasets: [
        {
            label: 'Total Patient',
            data: @json($totalvisits),
            tension: 0.4,
            borderWidth: 5,
            borderColor: 'rgb(252, 84, 75, 1)'
        },
        ]
        },
        options: {
            responsive: true,
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
    </script>
    <script>
    const ctx2 = document.getElementById('myRevenue');
    new Chart(ctx2, {
        type: 'line',
        data: {
            //DATA 01 - 31
        labels: @json($months),
        datasets: [
        {
            label: 'Total Revenue',
            data: @json($totalrevenues),
            tension: 0.4,
            borderWidth: 5,
            borderColor: 'rgb(56, 0, 177)'
        }
        ]
        },
        options: {
            responsive: true,
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });
    </script>
@endsection
@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush

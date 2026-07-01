@extends('layouts.app')

@section('title', 'Kesmas Dashboard')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/jqvmap/dist/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Dashboard</h1>
            </div>

            @php
                $thisdate = Carbon\Carbon::now()->format('Y');
            @endphp

            {{-- ROLE IS ADMIN, LABORATORY, OR VALIDATOR --}}
            @if(
                auth()->user()->role === 'admin' || auth()->user()->role === 'laboratory' || auth()->user()->role ===
                'validator'
            )
                        <h2 class="section-title mt-0">Kesmas Statistics</h2>
                        <div class="row">
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
                                            <b>{{ $receive }} </b><span>Visit</span><br>
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
                                    <div class="card-icon bg-info">
                                        <i class="fas fa-search"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Verify Queue</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $verify }} </b><span>Report</span><br>
                                            <div class="text-primary"><sup>{{ $verifydone }} Verifeid Today</sup></div>
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
                        @if(
                            auth()->user()->division === 'general' || auth()->user()->division === 'kimia'
                        )
                                <h2 class="section-title mt-0">Kimia Test Statistics {{ $thisdate }}</h2>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-primary">
                                                <i class="fas fa-droplet"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Kimia Kesmas Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $kimia }} </b><span>Order</span><br>
                                                    <div class="text-primary"><sup>{{ $kimiadone }} Completed</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-danger">
                                                <i class="fas fa-flask"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Kimia Receive Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $kimiareceive }} </b><span>Order</span><br>
                                                    <div class="text-primary"><sup>{{ $kimiareceived }} Received</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-bong"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Kimia Test Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $kimiatest }} </b><span>Sample</span><br>
                                                    <div class="text-primary"><sup>{{ $kimiatestdone }} Completed</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-info">
                                                <i class="fas fa-search"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Kimia Verify Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $kimiaverify }} </b><span>Report</span><br>
                                                    <div class="text-primary"><sup>{{ $kimiaverifydone }} Verifeid</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
                        @if(
                            auth()->user()->division === 'general' || auth()->user()->division === 'mikro'
                        )
                                <h2 class="section-title mt-0">Mikro Test Statistics {{ $thisdate }}</h2>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-primary">
                                                <i class="fas fa-bacterium"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Mikro Kesmas Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $mikro }} </b><span>Order</span><br>
                                                    <div class="text-primary"><sup>{{ $mikrodone }} Completed</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-danger">
                                                <i class="fas fa-shield-virus"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Mikro Receive Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $mikroreceive }} </b><span>Order</span><br>
                                                    <div class="text-primary"><sup>{{ $mikroreceived }} Received</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-warning">
                                                <i class="fas fa-dna"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Mikro Test Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $mikrotest }} </b><span>Sample</span><br>
                                                    <div class="text-primary"><sup>{{ $mikrotestdone }} Completed</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                        <div class="card card-statistic-1">
                                            <div class="card-icon bg-info">
                                                <i class="fas fa-search"></i>
                                            </div>
                                            <div class="card-wrap">
                                                <div class="card-header">
                                                    <h4 class="text-primary">Mikro Verify Queue</h4>
                                                </div>
                                                <div class="card-body">
                                                    <b>{{ $mikroverify }} </b><span>Report</span><br>
                                                    <div class="text-primary"><sup>{{ $mikroverifydone }} Verifeid</sup></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        @endif
            @endif
        </section>
    </div>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('library/simpleweather/jquery.simpleWeather.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('library/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('library/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/index-0.js') }}"></script>
@endpush
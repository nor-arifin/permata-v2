@extends('layouts.app')

@section('title', 'Laboratory Dashboard')

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
            {{-- ROLE IS NOT LABORATORY --}}
            @if(
                auth()->user()->role === 'admin' || auth()->user()->role === 'laboratory' || auth()->user()->role ===
                'validator'
            )
                        <h2 class="section-title mt-0">Laboratory Statistics</h2>
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
                        @php
                            $thisdate = Carbon\Carbon::now()->format('M Y');
                        @endphp
                        <h2 class="section-title mt-0">Group Test Statistics {{ $thisdate }}</h2>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-droplet"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Hematology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $hematology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $hematologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-bong"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Biochemistry</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $biochemistry }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $biochemistrydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-shield-virus"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Immunology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $immunology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $immunologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-bacterium"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Microbiology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $microbiology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $microbiologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-dna"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Genomics</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $genomics }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $genomicsdone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-syringe"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Toxicology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $toxicology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $toxicologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-biohazard"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Serology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $serology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $serologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-prescription-bottle"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Urinology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $urinology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $urinologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-bacteria"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Bacteriology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $bacteriology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $bacteriologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-diagnoses"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Parasitology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $parasitology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $parasitologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-viruses"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Virology</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $virology }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $virologydone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                                <div class="card card-statistic-1">
                                    <div class="card-icon bg-primary">
                                        <i class="fas fa-cannabis"></i>
                                    </div>
                                    <div class="card-wrap">
                                        <div class="card-header">
                                            <h4 class="text-primary">Other</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>{{ $other }} </b><span>Test</span><br>
                                            <div class="text-primary"><sup>{{ $otherdone }} Complete Today</sup></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
            @endif
            {{-- ROLE IS NOT ADMIN --}}
            @if(auth()->user()->role === 'admin')
                <h2 class="section-title mt-0">Group Test Chart</h2>
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ date('Y') }} Group Test Chart</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myBar" height="128">
                                </canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ date('M Y') }} Group Test Chart</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="myBar2" height="128">
                                </canvas>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </section>
    </div>
    <script src="{{ asset('library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        const ctx = document.getElementById('myBar');
        new Chart(ctx, {
            type: 'bar',
            data: {
                //DATA 01 - 31
                labels: @json($group),
                datasets: [{
                    label: '',
                    data: @json($totalorder),
                    borderWidth: 1,
                    backgroundColor: [
                        'rgb(56, 0, 177)',
                        'rgb(252, 84, 75)',
                        'rgb(255, 164, 38)',
                        'rgb(71, 195, 99)'
                    ],
                    borderColor: [
                        'rgb(56, 0, 177)',
                        'rgb(252, 84, 75)',
                        'rgb(255, 164, 38)',
                        'rgb(71, 195, 99)'
                    ]
                },]
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
        const ctx2 = document.getElementById('myBar2');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                //DATA 01 - 31
                labels: @json($monthgroup),
                datasets: [{
                    label: '',
                    data: @json($monthtotalorder),
                    borderWidth: 1,
                    backgroundColor: [
                        'rgb(56, 0, 177)',
                        'rgb(252, 84, 75)',
                        'rgb(255, 164, 38)',
                        'rgb(71, 195, 99)'
                    ],
                    borderColor: [
                        'rgb(56, 0, 177)',
                        'rgb(252, 84, 75)',
                        'rgb(255, 164, 38)',
                        'rgb(71, 195, 99)'
                    ]
                },]
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
@extends('layouts.app')

@section('title', 'Laboratory Report')

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
                <div class="breadcrumb-item">Report</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Laboratory Report</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <form method="GET" action="{{ route('lab.report') }}">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search" name="search">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="clearfix mb-3"></div>
                            <div class="table-responsive">
                                <table class="table-striped table">
                                    <tr class="text-center">
                                        <th>No.</th>
                                        <th>Date</th>
                                        <th>No Reg</th>
                                        <th>Patient Name</th>
                                        <th>Departement</th>
                                        <th>Turn Around Time</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($services as $lab)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        @php
                                        $date = $lab->created_at;
                                        $date = date('d-m-Y', strtotime($date));
                                        @endphp
                                        <td style="white-space: nowrap;">{{ $date }}</td>
                                        <td>{{ $lab->service_visit_registration_id }}</td>
                                        <td class="text-left">{{ $lab->patient_name }}
                                            ({{ ucfirst($lab->patient_gender) }})</td>
                                        <td>{{ $lab->visit_patient_dept }}</td>
                                        <td class="text-center" style="white-space: nowrap;">
                                            @php
                                            $progress = new DateTime($lab->visit_time_sampling);
                                            $now = new DateTime($lab->visit_time_validation);
                                            $intervald = date_diff($progress, $now)->format('%d');
                                            $intervalh = date_diff($progress, $now)->format('%h');
                                            $intervalm = date_diff($progress, $now)->format('%i');
                                            if ($intervald <= 0) { $days="" ; } else { $day=sprintf("%02d", $intervald);
                                                $days=$day . "D" ; } if ($intervalh <=0) { $hours=" 00H" ; } else {
                                                $hour=sprintf("%02d", $intervalh); $hours=" " . $hour . "H" ; } if
                                                ($intervalm <=0) { $minutes="00M" ; } else { $minute=sprintf( "%02d" ,
                                                $intervalm ); $minutes=" " . $minute . "M" ; } @endphp
                                                {{ $days . $hours . $minutes }} </td>
                                        <td style="white-space: nowrap;">
                                            <a href='{{ route('print.labreport', $lab->service_visit_registration_id) }}'
                                                data-toggle="tooltip" data-placement="top" title="Print Lab Report"
                                                target="_blank" class="btn btn-sm btn-primary btn-icon ml-2">
                                                <i class="fa fa-print"></i>
                                            </a>
                                            <a href='{{ route('lab.notifresult', $lab->service_visit_registration_id) }}'
                                                data-toggle="tooltip" data-placement="top" title="Send Lab Report"
                                                class="btn btn-sm btn-info btn-icon ml-2">
                                                <i class="fa fa-paper-plane"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $services->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
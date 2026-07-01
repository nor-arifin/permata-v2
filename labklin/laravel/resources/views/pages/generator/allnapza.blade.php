@extends('layouts.app')

@section('title', 'Laboratory Validation')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Generator Surat Napza</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Generator</a></div>
                    <div class="breadcrumb-item">All Napza</div>
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
                                <h4>Surat Keterangan Napza</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('all.napza') }}">
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
                                            <th>SK Napza</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($allnapza as $item)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ date('d-m-Y', strtotime($item->created_at)) }}</td>
                                                <td>{{ $item->service_visit_registration_id }}</td>
                                                <td class="text-left">{{ $item->patient_name }}
                                                    ({{ ucfirst($item->patient_gender) }})</td>
                                                <td>{{ $item->visit_patient_dept }}</td>
                                                <!-- Check  {{ $item->service_visit_registration_id }} is already on table register_napza-->
                                                @php
                                                    $surat = \DB::table('register_napza')->where(
                                                        'letter_napza_lhu',
                                                        $item->service_visit_registration_id
                                                    )->first();
                                                @endphp
                                                @if ($surat)
                                                    <td><span class="badge badge-success">{{ $surat->letter_napza_number }}</span>
                                                    </td>
                                                    <td style="white-space: nowrap;">
                                                        <a href='{{ route('gen.napza', $item->service_visit_registration_id) }}'
                                                            data-toggle="tooltip" data-placement="top" title="Print"
                                                            class="btn btn-sm btn-primary btn-icon ml-2">
                                                            <i class="fa fa-print"></i>
                                                        </a>
                                                    </td>
                                                @else
                                                    <td><span class="badge badge-error">Not Found</span></td>
                                                    <td style="white-space: nowrap;">
                                                        <a href='{{ route('generator.napza', $item->service_visit_registration_id) }}'
                                                            data-toggle="tooltip" data-placement="top" title="View Resume"
                                                            class="btn btn-sm btn-info btn-icon ml-2">
                                                            <i class="fa fa-search"></i>
                                                        </a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $allnapza->links() }}
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
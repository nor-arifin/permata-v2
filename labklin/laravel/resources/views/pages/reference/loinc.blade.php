@extends('layouts.app')

@section('title', 'LOINC')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>LOINC References</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Reference</a></div>
                    <div class="breadcrumb-item"><a href="#">LOINC</a></div>
                    <div class="breadcrumb-item">All List</div>
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
                                <h4>All LOINC</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('loinc.list') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search by Name"
                                                name="name">
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
                                            <th style="width: 10%;">LOINC Code</th>
                                            <th>Display</th>
                                            <th>Component</th>
                                            <th>Scale</th>
                                            <th>Method</th>
                                            <th>Unit</th>
                                        </tr>
                                        @foreach ($loinc as $item)
                                            <tr>
                                                <td>{{ $item->loinc_code }}</td>
                                                <td>{{ $item->loinc_display }}</td>
                                                <td>{{ $item->loinc_component }}</td>
                                                <td>{{ $item->loinc_scale}}</td>
                                                <td>{{ $item->loinc_method }}</td>
                                                <td>{{ $item->loinc_unitofmeasure }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $loinc->withQueryString()->links() }}
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
    <!-- JS Libraries -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
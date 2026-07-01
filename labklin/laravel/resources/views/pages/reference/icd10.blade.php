@extends('layouts.app')

@section('title', 'ICD-10')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>ICD-10 References</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Reference</a></div>
                    <div class="breadcrumb-item"><a href="#">ICD-10</a></div>
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
                                <h4>All ICD-10</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('icd.list') }}">
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
                                            <th style="width: 10%;">ICD-10 Code</th>
                                            <th>English</th>
                                            <th>Indonesian</th>
                                        </tr>
                                        @foreach ($icd10 as $item)
                                            <tr>
                                                <td>{{ $item->icd10_code }}</td>
                                                <td>{{ $item->icd10_en }}</td>
                                                <td>{{ $item->icd10_id }}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $icd10->withQueryString()->links() }}
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
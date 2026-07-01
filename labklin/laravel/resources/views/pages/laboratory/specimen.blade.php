@extends('layouts.app')

@section('title', 'Laboratory Collection')

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
                    <div class="breadcrumb-item">Collection</div>
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
                                <h4>To Be Collect</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                </div>
                                <div class="clearfix mb-3"></div>
                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr class="text-center">
                                            <th>No.</th>
                                            <th>Container</th>
                                            <th>Quantity</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($specimens as $lab)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $lab->test_container }}</td>
                                            <td>{{ $lab->test_specimen_vol}}</td>
                                            <td>
                                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal{{ $lab->service_visit_registration_id }}" data-id="{{ $lab->service_visit_registration_id }}"><i class="fas fa-eyedropper"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{-- {{ $specimens->withQueryString()->links() }} --}}
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
{{-- DATA TEST MODAL --}}
<script>
    var noreg = button.data('id');
    $(document).ready( function () {
        $("#item").DataTable({
            processing: true,
            serverSide: false,
            // type : "get",
            ajax: '/data-lab/loadservice/'+noreg,
            columns:
            [
                { data:'test_container', name: 'test_container'},
            ]
        });
    });
</script>
{{-- END TEST MODAL --}}
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush

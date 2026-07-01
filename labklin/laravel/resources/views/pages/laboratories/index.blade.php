@extends('layouts.app')

@section('title', 'Laboratoty Tests')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <script>
        function formatRupiah(angka) {
            // Ubah angka menjadi format nominal uang (misal: 1000000 -> Rp1.000.000)
            var rupiah = 'Rp' + angka.replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
            return rupiah;
        }
    </script>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Laboratoty Test</h1>
                <div class="section-header-button">
                    <a href="{{ route('laboratory.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Laboratoty Test</a></div>
                    <div class="breadcrumb-item">All Laboratoty Test</div>
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
                                <h4>All Laboratoty Tests</h4>
                                <div class="card-header-action">
                                    <a href="{{ route('export.labtest') }}" class="btn btn-success"><i
                                            class="fa fa-file-excel" aria-hidden="true"></i> Export Data</a>
                                    <a href="#" id="import-button" class="btn btn-primary"><i class="fa fa-upload"
                                            aria-hidden="true"></i> Import Data</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('laboratory.index') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search" name="name">
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
                                            <th>Code</th>
                                            <th>LOINC</th>
                                            <th>Name</th>
                                            <th>Group</th>
                                            <th>Method</th>
                                            <th>Category</th>
                                            <th>Price</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($laboratories as $lab)
                                                                            <tr>
                                                                                <td class="text-center">
                                                                                    {{ $lab->test_code}}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $lab->test_loinc_code}}
                                                                                </td>
                                                                                <td>
                                                                                    <strong>{{ $lab->test_name }}</strong>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $lab->test_group }} - {{ $lab->test_subgroup }}
                                                                                </td>
                                                                                <td>
                                                                                    {{ $lab->test_method }}
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    {{ $lab->test_category }} Test
                                                                                </td>
                                                                                <td class="text-left">
                                                                                    @php
                                                                                        $price = $lab->test_price;
                                                                                        $price = number_format($price, 0, ',', '.');
                                                                                    @endphp
                                                                                    <strong>Rp. {{ $price }}</strong>
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    @if ($lab->test_active == 'active')
                                                                                        <div class="badge badge-pill badge-success float-right mb-1">
                                                                                            {{ ucfirst($lab->test_active) }}
                                                                                        </div>
                                                                                    @elseif ($lab->test_active == 'inactive')
                                                                                        <div class="badge badge-pill badge-danger float-right mb-1">
                                                                                            {{ ucfirst($lab->test_active) }}
                                                                                        </div>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    <div class="d-flex justify-content-center">
                                                                                        <a href='{{ route('laboratory.edit', $lab->id) }}'
                                                                                            class="btn btn-sm btn-warning btn-icon">
                                                                                            <i class="fas fa-edit"></i>
                                                                                        </a>
                                                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                                                            data-toggle="modal" data-target="#deleteModal{{ $lab->id }}"><i
                                                                                                class="fas fa-trash"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </td>
                                                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $laboratories->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    {{-- MODAL DELETE--}}
    @foreach ($laboratories as $lab)
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $lab->id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do you really to test master {{ $lab->test_name }} ? This process will detele the test and subtest
                            from database.</p>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <form action="{{ route('laboratory.destroy', $lab->id) }}" method="POST" class="ml-2">
                            <input type="hidden" name="_method" value="DELETE" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <button class="btn btn-sm btn-danger btn-icon confirm-delete">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- END MODAL DELETE --}}
    {{-- MODAL IMPORT --}}
    <div class="modal fade" tabindex="-1" role="dialog" id="importModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Import Data Laboratory</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('import.labtest') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div ss="form-group">
                            <label for="importFile">Choose File</label>
                            <input type="file" class="form-control" id="importFile" name="file" required>
                            <small class="form-text text-danger">This action is dangerous task for system, please contact
                                your developer team before import.</small>
                            <small class="form-text text-muted">Accepted file types: .xlsx, .xls</small>
                        </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('import-button').addEventListener('click', function () {
            $('#importModal').modal('show');
        });
    </script>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
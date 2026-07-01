@extends('layouts.app')

@section('title', 'Patient')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Patients</h1>
            <div class="section-header-button">
                <a href="{{ route('patients.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Patients</a></div>
                <div class="breadcrumb-item">All Patient</div>
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
                            <h4>All Patients</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <form method="GET" action="{{ route('patients.index') }}">
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
                                        <th>Name</th>
                                        <th>Medical Record</th>
                                        <th>IHS Number</th>
                                        <th>Birthdate / Age</th>
                                        <th>ID Number</th>
                                        <th>Gender</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($patients as $patient)
                                                                        <tr>
                                                                            <td>{{ $patient->patient_name }}</td>
                                                                            <td class="text-center">{{ $patient->patient_mr }}</td>
                                                                            <td class="text-center">{{ $patient->patient_ihs }}</td>
                                                                            @php
                                                                                //Script Patient Age
                                                                                $patient_birthdate = $patient->patient_birthdate;
                                                                                $now = date("Y-m-d");

                                                                                $birthDate = new DateTime($patient_birthdate);
                                                                                $today = new DateTime($now);
                                                                                if ($birthDate > $today) {
                                                                                    $age = "0 Tahun";
                                                                                }
                                                                                $y = $today->diff($birthDate)->y;
                                                                                $m = $today->diff($birthDate)->m;
                                                                                $d = $today->diff($birthDate)->d;
                                                                                // $umur = $y." tahun ".$m." bulan ".$d." hari";
                                                                                $age = $y . " Tahun";
                                                                            @endphp
                                                                            <td class="text-center">{{ $patient->patient_birthdate }}
                                                                                <h6><span class="badge badge-pill badge-primary">{{ $age }}</span></h6>
                                                                            </td>
                                                                            <td class="text-center">{{ $patient->patient_nik }}</td>
                                                                            <td class="text-center">
                                                                                @if($patient->patient_gender == 'male')
                                                                                    <div title="Male Patient" class="badge badge-pill badge-info">
                                                                                        <i class="fas fa-male"></i> M
                                                                                    </div>
                                                                                @elseif($patient->patient_gender == 'female')
                                                                                    <div title="Female Patient" class="badge badge-pill badge-pink">
                                                                                        <i class="fas fa-female"></i> F
                                                                                    </div>
                                                                                @else
                                                                                    <div title="None Definite Patient" class="badge badge-pill badge-warning">
                                                                                        <i class="fas fa-female"></i> N
                                                                                    </div>
                                                                                @endif
                                                                            </td>
                                                                            <td class="text-center">
                                                                                @if ($patient->patient_status == 'active')
                                                                                    <div class="text-success" title="Patient Verifeid IHS Successfully"><i
                                                                                            class="fa-solid fa-circle-check"></i></div>
                                                                                @elseif ($patient->patient_status == 'registered')
                                                                                    <div class="text-warning" title="Processing to Verification IHS"><i
                                                                                            class="fa-solid fa-spinner"></i></div>
                                                                                @else
                                                                                    <div class="text-danger" title="Patient Not Activated"><i
                                                                                            class="fa-solid fa-circle-xmark"></i></div>
                                                                                @endif
                                                                            </td>
                                                                            <td>
                                                                                <div class="d-flex justify-content-center">
                                                                                    <a href='{{ route('patients.edit', $patient->id) }}'
                                                                                        class="btn btn-sm btn-warning btn-icon">
                                                                                        <i class="fas fa-edit"></i>
                                                                                    </a>
                                                                                     <a href='{{ route('print.record', $patient->patient_mr) }}' target="_blank"
                                                                                         class="btn btn-sm btn-primary btn-icon ml-2">
                                                                                        <i class="fas fa-credit-card"></i>
                                                                                    </a>
                                                                                    <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                                                        data-toggle="modal" data-target="#deleteModal{{ $patient->id }}"><i
                                                                                            class="fas fa-trash"></i>
                                                                                    </button>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $patients->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- MODAL DELETE--}}
@foreach ($patients as $patient)
    <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $patient->id }}">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete data {{ $patient->patient_name }} ? This action is not reversible and all data
                        of medical record will be lost.</p>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="ml-2">
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
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
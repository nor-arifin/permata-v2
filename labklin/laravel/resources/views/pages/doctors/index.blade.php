@extends('layouts.app')

@section('title', 'Doctors')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Doctor</h1>
                <div class="section-header-button">
                    <a href="{{ route('doctors.create') }}" class="btn btn-primary">Add New</a>
                </div>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Doctor</a></div>
                    <div class="breadcrumb-item">All Doctor</div>
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
                                <h4>All Doctors</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('doctors.index') }}">
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
                                            <th>Phone</th>
                                            <th>Gender</th>
                                            <th>Speciality</th>
                                            <th>Photo</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach ($doctors as $doctor)
                                            <tr>
                                                <td>{{ $doctor->doctor_name }}
                                                </td>
                                                <td>
                                                    {{ $doctor->doctor_phone }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($doctor->doctor_gender == 'male')
                                                    <button class="btn btn-sm btn-info">M</button>
                                                    @elseif ($doctor->doctor_gender == 'female')
                                                    <button class="btn btn-sm btn-warning">F</button>
                                                    @else
                                                    <button class="btn btn-sm btn-danger">N</button>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $doctor->doctor_speciality }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($doctor->doctor_photo)
                                                        <img src="{{ asset($doctor->doctor_photo) }}" alt="image" width="50px" height="50px" class="rounded-circle profile-widget-picture">
                                                        @else
                                                        <img src="{{ asset('img/avatar/avatar-1.png') }}" alt="image" width="50px" height="50px" class="rounded-circle profile-widget-picture">
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a href='{{ route('doctors.edit', $doctor->id) }}'
                                                            class="btn btn-sm btn-warning btn-icon">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                        data-toggle="modal" data-target="#deleteModal{{ $doctor->id }}"><i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $doctors->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

{{-- MODAL DELETE--}}
@foreach ($doctors as $doctor)
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $doctor->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really to delete data {{ $doctor->doctor_name }} ?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('doctors.destroy', $doctor->id) }}" method="POST" class="ml-2">
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

@extends('layouts.app')

@section('title', 'Doctor Schedules')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Doctor Schedules</h1>
            <div class="section-header-button">
                <a href="{{ route('doctor-schedules.create') }}" class="btn btn-primary">Add New</a>
            </div>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Doctor</a></div>
                <div class="breadcrumb-item">All Doctor Schedules</div>
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
                            <h4>All Doctors Schedules</h4>
                        </div>
                        <div class="card-body">
                            <div class="float-right">
                                <form method="GET" action="{{ route('doctor-schedules.index') }}">
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
                                        <th>Speciality</th>
                                        <th>Day</th>
                                        <th>Time</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    @foreach ($doctorschedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->doctor->doctor_name }}
                                        </td>
                                        <td>
                                            {{ $schedule->doctor->doctor_speciality }}
                                        </td>
                                        <td class="text-center">
                                            {{ $schedule->day }}
                                        </td>
                                        <td class="text-center">
                                            {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                        </td>
                                        <td class="text-center">
                                            @if ($schedule->status == 'active')
                                            <button class="btn btn-sm btn-success"><i
                                                    class="fa-solid fa-circle-check"></i></button>
                                            @elseif ($schedule->status == 'inactive')
                                            <button class="btn btn-sm btn-danger"><i
                                                    class="fa-solid fa-circle-xmark"></i></button>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <a href='{{ route('doctor-schedules.edit', $schedule->id) }}'
                                                    class="btn btn-sm btn-warning btn-icon">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                    data-toggle="modal" data-target="#deleteModal{{ $schedule->id }}"><i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                            <div class="float-right">
                                {{ $doctorschedules->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
{{-- MODAL DELETE--}}
@foreach ($doctorschedules as $schedule)
<div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $schedule->id }}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Do you really to delete schedule {{ $schedule->doctor->doctor_name }} at {{ $schedule->day }} {{ $schedule->start_time }} - {{ $schedule->end_time }} ?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <form action="{{ route('doctor-schedules.destroy', $schedule->id) }}" method="POST" class="ml-2">
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
<script src="{{ asset('library/prismjs/prism.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/bootstrap-modal.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('js/page/features-posts.js') }}"></script>
<script src="{{ asset('js/page/modules-ion-icons.js') }}"></script>
@endpush

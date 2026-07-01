@extends('layouts.app')

@section('title', 'Laboratory Receive')

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
                    <div class="breadcrumb-item">Receive</div>
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
                                <h4>To Be Receive</h4>
                            </div>
                            <div class="card-body">
                                <div class="float-right">
                                    <form method="GET" action="{{ route('lab.index') }}">
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
                                            <th>Collect Time</th>
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
                                                                                    {{ $lab->visit_time_sampling }}
                                                                                </td>
                                                                                <td style="white-space: nowrap;">
                                                                                    <button title="Receive" class="btn btn-sm btn-success btn-icon ml-2"
                                                                                        data-toggle="modal"
                                                                                        data-target="#showModal{{ $lab->service_visit_registration_id }}"><i
                                                                                            class="fa-solid fa-check-double"></i>
                                                                                    </button>
                                                                                    <button title="Reject"
                                                                                        class="btn btn-sm btn-danger btn-icon confirm-delete ml-2"
                                                                                        data-toggle="modal"
                                                                                        data-target="#deleteModal{{ $lab->service_visit_registration_id }}"><i
                                                                                            class="fa-brands fa-r-project"></i>
                                                                                    </button>
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
    {{-- MODAL DETAILS --}}
    @foreach ($services as $lab)
        <div class="modal fade" tabindex="-1" role="dialog" id="showModal{{ $lab->service_visit_registration_id }}">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">List Specimen To Be Receive</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table-striped table" id="receive">
                                {{-- QUERY SPECIMENT LIST WHERE visit_registration_id == service_visit_registration_id --}}
                                @php
                                    $regno = $lab->service_visit_registration_id;
                                    $specimens = DB::table('services_detail')
                                        ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
                                        //where not NULL
                                        ->where('services_detail.service_visit_registration_id', $regno)
                                        ->select(
                                            'services_detail.*',
                                            'laboratories.test_container',
                                            'laboratories.test_specimen',
                                            'laboratories.test_specimen_vol'
                                        )
                                        ->orderBy('laboratories.test_container', 'asc')
                                        ->get();
                                @endphp
                                <tr class="text-center">
                                    <th>No</th>
                                    <th>Specimen Container</th>
                                    <th>Quantity</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($specimens as $sample)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $sample->test_container }} - {{ $sample->service_name }}</td>
                                        <td>{{ $sample->test_specimen_vol}}</td>

                                        @if ($sample->service_specimen_id !== null)
                                            <td class="text-center text-success" data-toggle="tooltip" data-placement="top"
                                                title="Success to FHIR">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </td>
                                        @else
                                            @if ($sample->service_servicerequest_id != null)
                                                <td class="text-center">
                                                    <form action="" method="POST" class="ml-2" id="sendSpecimen{{$sample->id}}">
                                                        <input type="hidden" name="_method" id="method" value="PUT" />
                                                        <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                                                        <input type="hidden" name="id" id="id_data" value="{{$sample->id}}" />
                                                        <input type="hidden" name="visit_time_receive" id="visit_time_receive"
                                                            value="{{ date('Y-m-d\TH:i:sP') }}" />
                                                        <input type="hidden" name="visit_receive_by" id="visit_receive_by"
                                                            value="{{ Auth::user()->name }}" />
                                                        <input type="checkbox" name="specimen" value="1" id="serviceSpecimen">
                                                        {{-- <button class="btn btn-sm btn-success btn-icon" id="makespecimen" st><i
                                                                class="fa fa-paper-plane" aria-hidden="true"></i></button> --}}
                                                    </form>
                                                    <div class="text-center text-success" data-toggle="tooltip" data-placement="top"
                                                        title="Success to FHIR" id="successSpecimen{{$sample->id}}" style="display: none">
                                                        <i class="fa fa-check" aria-hidden="true"></i>
                                                </td>
                                            @else
                                                <td class="text-center text-danger" data-toggle="tooltip" data-placement="top"
                                                    title="Service Request Not Found On FHIR">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <form action="{{ route('lab.updatereceive', $regno) }}" method="POST" class="ml-2">
                            <input type="hidden" name="_method" value="PUT" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            {{-- NOTES SPECIMEN COLLECTION --}}
                            <div class="form-group">
                                <label for="notes">Notes <i>(Optional)</i></label>
                                <input type="text" value="{{ $sample->service_notes }}" class="form-control"
                                    name="service_notes">
                            </div>
                            <input type="hidden" name="visit_time_receive" value="{{ date('Y-m-d\TH:i:sP') }}" />
                            <input type="hidden" name="visit_receive_by" value="{{ Auth::user()->name }}" />
                            <div class="form-group">
                                <p>Received at {{ date('Y-m-d H:i:s') }} By {{ Auth::user()->name }}</p>
                                <button class="btn btn-sm btn-success btn-icon float-right">
                                    Receive
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- END MODAL DETAILS --}}
        {{-- MODAL RECEIVE --}}
        <div class="modal fade" tabindex="-1" role="dialog" id="deleteModal{{ $lab->service_visit_registration_id }}">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Reject Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure to reject specimen {{ $lab->patient_name }} - {{$lab->service_visit_registration_id}} ?
                            This action requires you to re-collect the specimen, please provide reasons for this rejection
                            below.</p>
                        <form action="{{ route('lab.rejectreceive', $regno) }}" method="POST" class="ml-2">
                            <input type="hidden" name="_method" value="PUT" />
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            {{-- NOTES SPECIMEN COLLECTION --}}
                            <div class="form-group">
                                <label for="notes">Reason</label>
                                <input type="text" value="{{ $sample->service_notes }}" class="form-control"
                                    name="service_notes">
                            </div>
                            <div class="form-group">
                                <p>Reject at {{ date('Y-m-d H:i:s') }} By {{ Auth::user()->name }}</p>
                                <button class="btn btn-sm btn-danger btn-icon float-right">
                                    Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    {{-- END MODAL RECEIVE --}}
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
            //agar dapet data dan id yang berbeda
            $('#receive tr').each(function () {
                var $this = $(this);
                var id = $this.find('input[id="id_data"]').val();
                var time_receive = $this.find('input[id="visit_time_receive"]').val();
                var receive_by = $this.find('input[id="visit_receive_by"]').val();
                // var reference = $this.find('input[id="service_reference"]').val();
                var check = $this.find('input[name^="specimen"]');
                check.on('change', function () {
                    var checked = $(this).val();
                    if (checked) {
                        $.ajax({
                            url: '{{ config('app.url') }}/lab/makespecimen/' + id,
                            type: 'POST',
                            data: $('form')
                                .serialize(), // Remember that you need to have your csrf token included
                            dataType: 'json',
                            cache: false,
                            success: function (data) {
                                if (data.success ==
                                    true) { //CEK APAKAH DATA RESOURCE ADA, cek console.log
                                    document.getElementById('sendSpecimen' + id).style
                                        .display = 'none';
                                    document.getElementById('successSpecimen' + id).style
                                        .display = 'block';
                                    console.log(data);
                                    // console.log(data);
                                } else {
                                    document.getElementById('sendSpecimen' + id).style
                                        .display = 'block';
                                    document.getElementById('successSpecimen' + id).style
                                        .display = 'none';
                                    console.log(data);
                                };
                            }
                        });
                    } else {
                        $('#serviceSpecimen').empty();
                    }
                });
            });
        });
    </script>
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
@endpush
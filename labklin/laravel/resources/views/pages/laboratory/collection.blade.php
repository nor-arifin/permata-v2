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
                                        <th>Medical Record</th>
                                        <th>Patient Name</th>
                                        <th>Departement</th>
                                        <th>Waiting Time</th>
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
                                        <td>{{ $lab->service_visit_patient_mr }} / {{ $lab->patient_ihs }}</td>
                                        <td class="text-left">{{ $lab->patient_name }}
                                            ({{ ucfirst($lab->patient_gender) }})</td>
                                        <td>{{ $lab->visit_patient_dept }}</td>
                                        <td class="text-center" style="white-space: nowrap;">
                                            @if ($lab->visit_time_sampling == null)
                                            @php
                                            $now = new DateTime(date('Y-m-d H:i:s'));
                                            @endphp
                                            @else
                                            @php
                                            $now = new DateTime($lab->visit_time_sampling);
                                            @endphp
                                            @endif
                                            @php
                                            $progress = new DateTime($lab->visit_date_progress);
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
                                            @if ($lab->visit_time_sampling == null)
                                            <button class="btn btn-sm btn-primary btn-icon confirm-delete ml-2"
                                                data-toggle="modal"
                                                data-target="#showModal{{ $lab->service_visit_registration_id }}"><i
                                                    class="fas fa-syringe"></i>
                                            </button>
                                            @endif
                                             <a href="{{ route('print.label', $lab->service_visit_registration_id) }}" target="_blank"
                                                 class="btn btn-sm btn-info btn-icon ml-2" title="Print Barcode"><i
                                                    class="fas fa-barcode"></i></a>
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
                <h5 class="modal-title">List Specimen To Be Collect</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table-striped table" id="specimen">
                        {{-- QUERY SPECIMENT LIST WHERE visit_registration_id == service_visit_registration_id --}}
                        @php
                        $regno = $lab->service_visit_registration_id;
                        $specimens = DB::table('services_detail')
                        ->join('laboratories', 'services_detail.service_code', '=', 'laboratories.test_code')
                        //where not NULL
                        ->where('services_detail.service_visit_registration_id', $regno)
                        ->select(
                        'services_detail.*',
                        'laboratories.test_name',
                        'laboratories.test_container',
                        'laboratories.test_specimen',
                        'laboratories.test_specimen_vol'
                        )
                        // ->groupBy('laboratories.test_container')
                        ->orderBy('laboratories.test_container', 'asc')
                        ->get();
                        @endphp
                        <tr class="text-center">
                            <th>Test</th>
                            <th>Specimen Container</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($specimens as $sample)
                        <tr class="text-center">
                            <td class="text-left">{{ $sample->test_name}}</td>
                            <td class="text-left">{{ $sample->test_container }}</td>
                            <td>{{ $sample->test_specimen_vol}}</td>
                            @if ($sample->service_servicerequest_id !== null)
                            <td class="text-center text-success" data-toggle="tooltip" data-placement="top"
                                title="Success to FHIR">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </td>
                            @else
                            <td class="text-center">
                                <form action="" method="POST" class="ml-2" id="sendRequest{{$sample->id}}">
                                    <input type="hidden" name="_method" id="method" value="PUT" />
                                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}" />
                                    <input type="hidden" name="id" id="id_data" value="{{$sample->id}}" />
                                    <input type="hidden" name="visit_time_sampling" id="visit_time_sampling"
                                        value="{{ date('Y-m-d\TH:i:sP') }}" />
                                    <input type="hidden" name="visit_sampling_by" id="visit_sampling_by"
                                        value="{{ Auth::user()->name }}" />
                                    <input type="checkbox" name="service_request" value="1" id="serviceRequest">
                                </form>
                                <div class="text-center text-success" data-toggle="tooltip" data-placement="top"
                                    title="Success to FHIR" id="successRequest{{$sample->id}}" style="display: none">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </table>
                </div>
                <form action="{{ route('lab.updatesampling', $regno) }}" method="POST" class="ml-2">
                    <input type="hidden" name="_method" value="PUT" />
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    {{-- NOTES SPECIMEN COLLECTION --}}
                    <div class="form-group">
                        <label for="notes">Notes <i>(Optional)</i></label>
                        <input type="text" class="form-control" name="service_notes">
                    </div>
                    <input type="hidden" name="visit_time_sampling" value="{{ date('Y-m-d\TH:i:sP') }}" />
                    <input type="hidden" name="visit_sampling_by" value="{{ Auth::user()->name }}" />
                    <div class="form-group">
                        <p>Collected at {{ date('Y-m-d H:i:s') }} By {{ Auth::user()->name }}</p>
                        <button class="btn btn-sm btn-success btn-icon float-right">
                            Collect
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
{{-- END MODAL DETAILS --}}
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    //beri id pada table agar dapet id yang berbeda ketika input karena harus dilakukan penggulangan
    //agar dapet data dan id yang berbeda
    $('#specimen tr').each(function() {
        var $this = $(this);
        var id = $this.find('input[id="id_data"]').val();
        var time_sampling = $this.find('input[id="visit_time_sampling"]').val();
        var sampling_by = $this.find('input[id="visit_sampling_by"]').val();
        var check = $this.find('input[name^="service_request"]');
        check.on('change', function() {
            var checked = $(this).val();
            if (checked) {
                $.ajax({
                    url: '{{ config('app.url') }}/lab/makeservicerequest/' + id,
                    type: 'POST',
                    data: $('form')
                        .serialize(), // Remember that you need to have your csrf token included
                    dataType: 'json',
                    cache: false,
                    success: function(data) {
                        if (data.success ==
                            true) { //CEK APAKAH DATA RESOURCE ADA, cek console.log
                            document.getElementById('sendRequest' + id).style
                                .display = 'none';
                            document.getElementById('successRequest' + id).style
                                .display = 'block';
                            console.log(data);
                            // console.log(data);
                        } else {
                            document.getElementById('sendRequest' + id).style
                                .display = 'block';
                            document.getElementById('successRequest' + id).style
                                .display = 'none';
                            console.log(data);
                        };
                    }
                });
            } else {
                $('#serviceRequest').empty();
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
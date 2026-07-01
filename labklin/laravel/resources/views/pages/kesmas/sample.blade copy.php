@extends('layouts.app')

@section('title', 'Input Sample')

@push('style')
<!-- CSS Libraries -->
<link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

<link rel="stylesheet" href="{{ asset('modules/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Input Sample</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Kesmas</a></div>
                <div class="breadcrumb-item">Order</div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    @include('layouts.alert')
                </div>
            </div>
            {{-- CUSTOMER --}}
            <div class="card">
                <div class="card-header">
                    <h4>Kesmas Order - No. FPPS : {{ $order->order_code }}
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Customer Code
                                    </label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_code }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Customer
                                        Name</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_name}} / {{ $order->customer_type }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Contact</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_phone }} / {{ $order->customer_email }}
                                    </label>
                                </div>
                                <div class="form-inline">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Person In
                                        Charge</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_pic }} / {{ $order->customer_pic_phone }}
                                    </label>
                                </div>
                                <div class="form-inline mb-2">
                                    <label class="col-sm-3 mt-2"
                                        style="display: inline-block; text-align:left; font-weight: bold;">Address</label>
                                    <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                        : {{ $order->customer_address}} -
                                        {{ $order->customer_address_detail }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END CUSTOMER --}}
            <form action="{{ route('kesmas.update', $order->idcode) }}" method="POST">
                @csrf
                @method('PUT')
                {{-- SAMPLE --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Sample Description
                            <input type="hidden" name="order_id" value="{{ $order->idcode }}">
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <label class="col-form-label">Sample Collected By :</label>
                                    <div class="selectgroup d-flex mt-2">
                                        <label class="selectgroup-item">
                                            <input type="radio" name="order_collector" value="customer"
                                                class="selectgroup-input" {{ old('order_collector')=='customer'
                                                ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Customer</span>
                                        </label>
                                        <label class="selectgroup-item">
                                            <input type="radio" name="order_collector" value="laboratory"
                                                class="selectgroup-input" {{ old('order_collector', 'laboratory'
                                                )=='laboratory' ? 'checked' : '' }}>
                                            <span class="selectgroup-button">Laboratory</span>
                                        </label>
                                    </div>
                                    @error('order_collector')
                                    <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row" id="laboratory">
                            <div class="form-group col-md-6">
                                <label for="labnamesampler">Sampling Officer</label>
                                <select class="form-control" name="labnamesampler" id="labnamesampler" required>
                                    <option value="Petugas">- Select -</option>
                                    @foreach ($samplers as $sampler)
                                    <option value="{{ $sampler->id }}">{{ $sampler->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="labphonesampler">Phone</label>
                                <input type="text" class="form-control" name="labphonesampler" id="labphonesampler"
                                    value="08" placeholder="Kontak Pengambil Sampel" required>
                            </div>
                        </div>
                        <div class="form-row" id="customer" style="display: none;">
                            <div class="form-group col-md-6">
                                <label for="cusnamesampler">Sampling Officer</label>
                                <input type="text" class="form-control" name="cusnamesampler" id="cusnamesampler"
                                    value="{{ old('cusnamesampler', 'Pelanggan') }}" placeholder="Nama Pengambil Sampel"
                                    required>
                                @error('cusnamesampler')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cusphonesampler">Phone</label>
                                <input type="text" class="form-control" name="cusphonesampler" id="cusphonesampler"
                                    value="{{ old('cusphonesampler', '08') }}" placeholder="Kontak Pengambil Sampel"
                                    required>
                                @error('cusphonesampler')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row" id="timesampling">
                            <div class="form-group col-md-6">
                                <label for="timesampling">Time Sampling</label>
                                <input type="text" class="form-control datetimepicker" name="timesampling"
                                    id="timesampling" value="{{ old('timesampling') }}">
                                @error('timesampling')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="timereceived">Time Receive</label>
                                <input type="text" class="form-control datetimepicker" name="timereceived"
                                    id="timereceived" value="{{ old('timereceived') }}">
                                @error('timereceived')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row" id="sampledescription">
                            <div class="form-group col-md-6">
                                <label for="division">Laboratory Division</label>
                                <select class="form-control" name="division" id="division" required>
                                    <option value="">- Select -</option>
                                    <option value="Kimia">Kimia</option>
                                    <option value="Mikrobiologi">Mikrobiologi</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="quantity">Number of samples</label>
                                <input type="number" min="1" value="{{ old('quantity', 1) }}" class="form-control"
                                    name="quantity" id="quantity" required>
                                @error('quantity')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END SAMPLE --}}
                {{-- SAMPLE DETAIL --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Sample Identity
                        </h4>
                    </div>
                    <div class="card-body">
                        <div id="sampledetail-wrapper">
                            <div class="form-row sampledetail">
                                <div class="form-group col-md-2">
                                    <label for="type">Type</label>
                                    <select class="form-control" name="type[]" required>
                                        <option value="">- Select -</option>
                                        <option value="AH">Air Higiene dan Sanitasi</option>
                                        <option value="AK">Air Kolam Renang</option>
                                        <option value="AT">Air Laut</option>
                                        <option value="AL">Air Limbah</option>
                                        <option value="AM">Air Minum</option>
                                        <option value="AU">Air Pemandian Umum</option>
                                        <option value="AP">Air SPA</option>
                                        <option value="AS">Air Sungai/Danau</option>
                                        <option value="LN">Linen</option>
                                        <option value="MS">Alat Masak</option>
                                        <option value="MM">Makanan Minuman</option>
                                        <option value="US">Usap Swab</option>
                                        <option value="MT">Media Tanah</option>
                                        <option value="KU">Kualitas Udara</option>
                                        <option value="OL">Other</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="sampleid">Customer Sample ID</label>
                                    <input type="text" class="form-control" name="sampleid[]" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="condition">Laboratory Coder</label>
                                    <select class="form-control" name="samplecode[]" id="samplecode[]" required>
                                        <option value="">- Select -</option>
                                        <option value="KA">Kimia Air</option>
                                        <option value="MA">Mikrobiologi Air</option>
                                        <option value="MM">Mikrobiologi Makanan</option>
                                        <option value="US">Mikrobiologi Usap Swab</option>
                                        <option value="KU">Mikrobiologi Kualitas Udara</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for="volume">Volume</label>
                                    <input type="text" class="form-control" name="volume[]" required>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="container">Container</label>
                                    <select class="form-control" name="container[]" required>
                                        <option value="">- Select -</option>
                                        <option value="Botol Kaca">Botol Kaca</option>
                                        <option value="Botol Plastik">Botol Plastik</option>
                                        <option value="Botol Steril">Botol Steril</option>
                                        <option value="Cawan Steril">Cawan Steril</option>
                                        <option value="Gelas Steril">Gelas Steril</option>
                                        <option value="Plastik Klip">Plastik Klip</option>
                                        <option value="Plastik Steril">Plastik Steril</option>
                                        <option value="Khusus">Khusus / Lainnya</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="description">Description</label>
                                    <select class="form-control" name="description[]" required>
                                        <option value="">- Select -</option>
                                        <option value="Jernih">Jernih</option>
                                        <option value="Keruh">Keruh</option>
                                        <option value="Padat">Padat</option>
                                        <option value="Cair">Cair</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1 d-flex align-items-end">
                                    <div class="text-center btn btn-success btn-lg add-row">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                    <div class="text-center btn btn-danger btn-lg remove-row" style="display: none;">
                                        <i class="fas fa-minus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- END SAMPLE DETAIL --}}
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection
@push('scripts')

<!-- JS Libraies -->
<script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('modules/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

<script src="{{ asset('modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>

<!-- Page Specific JS File -->
<script src="{{ asset('modules/cleave-js/dist/cleave.min.js') }}"></script>
<script src="{{ asset('js/page/features-posts.js') }}"></script>
<script src="{{ asset('js/page/forms-advanced-forms.js') }}"></script>

<!-- Load Element Sampel -->
<script>
    $(document).ready(function () {
        $('#division').change(function () {
            var division = $(this).val();
            var sampleCodeSelect = $('select[name="samplecode[]"]');
            sampleCodeSelect.empty(); // Clear existing options
            if (division === 'Kimia') {
                sampleCodeSelect.append('<option value="KA">Kimia Air</option>');
            } else {
                sampleCodeSelect.append('<option value="MA">Mikrobiologi Air</option>');
                sampleCodeSelect.append('<option value="MM">Mikrobiologi Makanan</option>');
                sampleCodeSelect.append('<option value="US">Mikrobiologi Usap Swab</option>');
                sampleCodeSelect.append('<option value="KU">Mikrobiologi Kualitas Udara</option>');
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('input[type=radio][name=order_collector]').change(function () {
            if (this.value == 'customer') {
                // change sytle display to block
                $('#customer').show();
                $('#laboratory').hide();
            } else if (this.value == 'laboratory') {
                $('#customer').hide();
                $('#laboratory').show();
            }
        });
    });
</script>
<!-- Get Sampler Data -->
<script>
    $(document).ready(function () {
        $('#labnamesampler').change(function () {
            var samplerID = $(this).val();
            if (samplerID) {
                $.ajax({
                    url: '/kesmas/get-sampler/' + samplerID,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#labphonesampler').val(data.phone);
                    }
                });
            } else {
                $('#labphonesampler').val('');
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $("#sampledetail-wrapper").on("click", ".add-row", function () {
            let newRow = $(".sampledetail:first").clone(); // Salin baris pertama
            newRow.find("input").val(""); // Kosongkan input
            newRow.find("select").val(""); // Kosongkan select
            newRow.find(".add-row").hide(); // Sembunyikan tombol tambah pada baris baru
            newRow.find(".remove-row").show(); // Tampilkan tombol hapus
            $("#sampledetail-wrapper").append(newRow); // Tambahkan baris baru
        });

        $("#sampledetail-wrapper").on("click", ".remove-row", function () {
            $(this).closest(".sampledetail").remove(); // Hapus baris saat tombol "-" ditekan
        });
    });
</script>
<script>
    // Count Row sampledetail update on add or remove row
    function updateRowCount() {
        let rowCount = $(".sampledetail").length;
        console.log("Total Rows: " + rowCount);
    }
    $(document).ready(function () {
        updateRowCount(); // Initial count

        $("#sampledetail-wrapper").on("click", ".add-row", function () {
            updateRowCount(); // Update count on add
        });

        $("#sampledetail-wrapper").on("click", ".remove-row", function () {
            updateRowCount(); // Update count on remove
        });
    });

    function updateRowCount() {
        let rowCount = $(".sampledetail").length;
        console.log("Total Rows: " + rowCount);
        $("#quantity").val(rowCount); // Insert rowCount to element id quantity
    }
</script>

@endpush
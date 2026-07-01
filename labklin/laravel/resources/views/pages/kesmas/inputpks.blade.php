@extends('layouts.app')

@section('title', 'Payment - ' . $order->order_code)

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('modules/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">

@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Input Payment PKS - {{ $order->order_type }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Kesmas</a></div>
                    <div class="breadcrumb-item">Input Payment</div>
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
                        <h4>FPPS No. : {{ $order->order_code }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Customer
                                            Name</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->customer_name}} / {{ $order->customer_type }} /
                                            {{ $order->customer_code }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Address</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->customer_address}} -
                                            {{ $order->customer_address_detail }}
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
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Contact /
                                            Email</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->customer_phone }} / {{ $order->customer_email }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Sample
                                            Collector</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ ucfirst($order->order_collector) }} by
                                            {{ ucfirst($order->order_sampling_name) }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Sample
                                            Collected</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->order_collect }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Sample
                                            Received</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->order_collect }}
                                        </label>
                                    </div>
                                    <div class="form-inline mb-3">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Number of
                                            Sample
                                        </label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $order->order_num_sample }} Sample(s)
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>
                                            Sample Description
                                        </h4>
                                    </div>
                                    <!-- Table of Sample -->
                                    <div class="table-responsive p-3">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th class="text-center">Customer Sample ID</th>
                                                    <th class="text-center">Sample Code</th>
                                                    <th class="text-center">Sample Type</th>
                                                    <th class="text-center">Sample Container</th>
                                                    <th class="text-center">Sample Description</th>
                                                    <th class="text-center">Charge</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($samples as $sample)
                                                                                            <tr>
                                                                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_id }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_code }}</td>
                                                                                                @php
                                                                                                    $sample_types = [
                                                                                                        'AM' => 'Air Minum',
                                                                                                        'AH' => 'Air Higiene dan Sanitasi',
                                                                                                        'AL' => 'Air Limbah',
                                                                                                        'AS' => 'Air Sungai / Danau',
                                                                                                        'AK' => 'Air Kolam Renang',
                                                                                                        'MM' => 'Makanan Minuman',
                                                                                                        'US' => 'Usap Swab',
                                                                                                        'KU' => 'Kualitas Udara',
                                                                                                        'OL' => 'Lainnya',
                                                                                                    ];
                                                                                                    $sample_type = $sample_types[$sample->sample_type] ?? 'Unknown';
                                                                                                @endphp
                                                                                                <td class="text-center">{{ $sample_type }}</td>
                                                                                                <td class="text-center">{{ $sample->sample_volume }}
                                                                                                    {{ $sample->sample_container }}
                                                                                                </td>
                                                                                                <td class="text-center">{{ $sample->sample_description }}</td>
                                                                                                <td class="text-left">
                                                                                                    Rp.
                                                                                                    {{ number_format($parameters->where('order_sample_id', $sample->id)->sum('order_parameter_price'), 0, ',', '.') }}
                                                                                                </td>
                                                                                            </tr>
                                                                                            <tr>
                                                                                                <td></td>
                                                                                                <td colspan="6">
                                                                                                    <div class="form-group">
                                                                                                        <label class="font-weight-bold">Parameter</label>
                                                                                                        <!-- Label di atas -->
                                                                                                        <ul class="mt-2">
                                                                                                            @foreach ($parameters as $detail)
                                                                                                                @if ($detail->order_sample_id == $sample->id)
                                                                                                                    <li>{{ $detail->order_parameter_name }}</li>
                                                                                                                @endif
                                                                                                            @endforeach
                                                                                                        </ul>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- End Table of Sample -->
                                </div>
                            </div>
                        </div>
                        <!-- Review -->
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4>Review Order</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-form-label col-sm-3"><b>Conclution</b>
                                            </div>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control"
                                                    value="{{ $review->review_conclution }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-form-label col-sm-3"></div>
                                            <div class="col-sm-9">
                                                Review By <b class="text-primary">{{ $review->review_name }}</b> at
                                                {{ $review->created_at }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END Review -->
                        <!-- Bill Summary -->
                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <form action="{{ route('payment.paypks', $order->idcode) }}" method="POST">
                                    @csrf
                                    @method('GET')
                                    <div class="card">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4>PKS No. {{ $order->payment_mou_number }}</h4>
                                            <div class="btn btn-danger" data-toggle="tooltip" data-placement="top"
                                                title="Reject Order" id="reject">
                                                Due Date :
                                                {{ date('d-m-Y', strtotime($order->payment_mou_duedate)) }}
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-group row">
                                                        <label class="col-sm-8 col-form-label text-right mt-2">Total</label>
                                                        <div class="col-sm-4">
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Rp</div>
                                                                </div>
                                                                <input type="text" class="form-control @error('order_total')
                                                                    is-invalid
                                                                @enderror" name="order_total" id="order_total"
                                                                    onKeyup="hitung();" value="{{ $order->order_total }}"
                                                                    placeholder="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                                    required readonly>
                                                                @error('order_total')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-4">
                                                            <label>Payment Method</label>
                                                            <select name="order_payment_method" class="form-control"
                                                                id="order_payment_method" onchange="showDiv(this)" required>
                                                                <option value="">- Select Method -</option>
                                                                <option value="Cash">Cash</option>
                                                                <option value="Credit Card">Credit Card</option>
                                                                <option value="Debit Card">Debit Card</option>
                                                                <option value="Qris">QRiS</option>
                                                                <option value="Transfer">Transfer</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Amount</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Rp</div>
                                                                </div>
                                                                <input type="text" class="form-control @error('order_payment_amount')
                                                                    is-invalid
                                                                @enderror" name="order_payment_amount"
                                                                    id="order_payment_amount" onKeyup="hitung();"
                                                                    value="{{old('order_payment_amount')}}" placeholder="0"
                                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                                    required>
                                                                @error('order_payment_amount')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Remaining</label>
                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <div class="input-group-text">Rp</div>
                                                                </div>
                                                                <input type="text" class="form-control @error('order_payment_remaining')
                                                                    is-invalid
                                                                @enderror" name="order_payment_remaining"
                                                                    id="order_payment_remaining" onKeyup="hitung();"
                                                                    value="{{old('order_payment_remaining')}}"
                                                                    placeholder="0" required readonly>
                                                                @error('order_payment_remaining')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- DETAIL METHOD -->
                                            {{-- CREDIT CARD --}}
                                            <div class="row" id="credit_card" style="display: none">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Card Number</label>
                                                            <input type="text" class="form-control" name="card_number"
                                                                placeholder="Card Number">
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            <label>CVC</label>
                                                            <input type="text" class="form-control" name="card_cvc"
                                                                placeholder="CVC"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                                minlength="3" maxlength="3">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label>Card Holder Name</label>
                                                            <input type="text" class="form-control" name="card_holder"
                                                                placeholder="Holder Name">
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            <label>Card Expired</label>
                                                            <input type="text" class="form-control" name="card_month"
                                                                placeholder="MM"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                                minlength="2" maxlength="2" min="01" max="12">
                                                        </div>
                                                        <div class="form-group col-md-1">
                                                            <label>&nbsp;</label>
                                                            @php
                                                                $year = date('Y');
                                                                $maxyear = $year + 10;
                                                            @endphp
                                                            <input type="text" class="form-control" name="card_year"
                                                                placeholder="YYYY"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                                minlength="4" maxlength="4" min="{{ $year }}"
                                                                max="{{ $maxyear }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- TRANSFER --}}
                                            <div class="row" id="transfer" style="display: none">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Bank Name</label>
                                                            <select class="form-control" name="transfer_bank_name">
                                                                <option value="">- Select Bank -</option>
                                                                <option value="BCA">BCA</option>
                                                                <option value="BRI">BRI</option>
                                                                <option value="BNI">BNI</option>
                                                                <option value="Mandiri">Mandiri</option>
                                                                <option value="BSI">BSI</option>
                                                                <option value="Kalteng">Kalteng</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <label>Nama Akun</label>
                                                            <input type="text" class="form-control"
                                                                name="transfer_account_name" placeholder="Account Name">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label>Transaction Date</label>
                                                            <input type="text" class="form-control"
                                                                name="transfer_transaction_date"
                                                                value="{{ date('Y-m-d H:i:s') }}"
                                                                placeholder="Transaction Date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- DEBIT --}}
                                            <div class="row" id="debit_card" style="display: none">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>Bank Name</label>
                                                            <select class="form-control" name="debit_bank_name">
                                                                <option value="">- Select Bank -</option>
                                                                <option value="BCA">BCA</option>
                                                                <option value="BRI">BRI</option>
                                                                <option value="BNI">BNI</option>
                                                                <option value="Mandiri">Mandiri</option>
                                                                <option value="BSI">BSI</option>
                                                                <option value="Kalteng">Kalteng</option>
                                                                <option value="Other">Other</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <label>Ref Number</label>
                                                            <input type="text" class="form-control" name="debit_ref_number"
                                                                placeholder="Reference Number">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label>Transaction Date</label>
                                                            <input type="text" class="form-control"
                                                                name="debit_transaction_date"
                                                                value="{{ date('Y-m-d H:i:s') }}"
                                                                placeholder="Transaction Date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- PKS --}}
                                            <div class="row" id="pks" style="display: none">
                                                <div class="col-12 col-md-12 col-lg-12">
                                                    <div class="form-row">
                                                        <div class="form-group col-md-5">
                                                            <label>MoU Number</label>
                                                            <input type="text" class="form-control" id="mou_number"
                                                                name="mou_number" placeholder="MoU Number">
                                                        </div>
                                                        <div class="form-group col-md-5">
                                                            <label>Due date</label>
                                                            <input type="date" class="form-control" name="mou_duedate"
                                                                placeholder="Due Date">
                                                        </div>
                                                        <div class="form-group col-md-2">
                                                            <label>Transaction Date</label>
                                                            <input type="text" class="form-control"
                                                                name="mou_transaction_date"
                                                                value="{{ date('Y-m-d H:i:s') }}"
                                                                placeholder="Transaction Date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-footer text-right">
                                            <button type="submit" class="btn btn-primary" id="payment">Update
                                                Payment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- END CUSTOMER --}}
            </div>
        </section>
    </div>
@endsection

{{-- SCRIPT PAYMENT METHOD --}}
<script>
    function showDiv(select) {
        if (select.value == "Credit Card") {
            document.getElementById('credit_card').style.display = "block";
            document.getElementById('debit_card').style.display = "none";
            document.getElementById('transfer').style.display = "none";
            document.getElementById('pks').style.display = "none";
            document.getElementById('mou_number').required = false;
        } else if (select.value == "Transfer") {
            document.getElementById('credit_card').style.display = "none";
            document.getElementById('debit_card').style.display = "none";
            document.getElementById('transfer').style.display = "block";
            document.getElementById('pks').style.display = "none";
            document.getElementById('mou_number').required = false;
        } else if (select.value == "Debit Card") {
            document.getElementById('credit_card').style.display = "none";
            document.getElementById('debit_card').style.display = "block";
            document.getElementById('transfer').style.display = "none";
            document.getElementById('pks').style.display = "none";
            document.getElementById('mou_number').required = false;
        } else {
            document.getElementById('credit_card').style.display = "none";
            document.getElementById('debit_card').style.display = "none";
            document.getElementById('transfer').style.display = "none";
            document.getElementById('pks').style.display = "none";
            document.getElementById('mou_number').required = false;
        }
    }
</script>

{{-- SCRIPT HITUNG --}}
<script>
    function hitung() {
        var total = document.getElementById('order_total').value;
        var payment = document.getElementById('order_payment_amount').value;
        var remaining = document.getElementById('order_payment_remaining').value;
        var result = total - payment;
        document.getElementById('order_payment_remaining').value = result;
    }
</script>
@push('scripts')

    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>

    <!-- Reject Sampel -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- SCRIPT check order_payment_remaining must 0 -->
    <script>
        $('#payment').on('click', function () {
            var remaining = document.getElementById('order_payment_remaining').value;
            if (remaining != 0) {
                Swal.fire({
                    title: 'Payment Failed',
                    text: 'Remaining Payment must be 0',
                    icon: 'error',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
                return false;
            }
        });
    </script>

@endpush
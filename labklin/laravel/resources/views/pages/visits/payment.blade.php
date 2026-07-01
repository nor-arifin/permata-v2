@extends('layouts.app')

@section('title', 'Bill Payment')

@push('style')
    <!-- Other meta tags -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Bill Payment</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Visit</a></div>
                    <div class="breadcrumb-item">Payment</div>
                </div>
            </div>
            {{-- FORM VALIDATION ALERT --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                            <span>×</span>
                        </button>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            {{-- END FORM VALIDATION ALERT --}}
            <div class="section-body">
                {{-- PATIENT --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Patient Detail - No. Reg : {{ $visit->visit_registration_id }}
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Medical
                                            Record</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $visit->visit_patient_mr }} / {{ $patient->patient_ihs }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Patient
                                            Name</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $visit->visit_patient_name }}
                                            ({{ ucfirst($patient->patient_gender) }})
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Birth
                                            Date</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            @php
                                                $age = \Carbon\Carbon::parse($patient->patient_birthdate)->age;
                                            @endphp
                                            : {{ $patient->patient_birthdate }} ({{ $age }} Years Old)
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Plan</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $visit->visit_patient_status }}
                                        </label>
                                    </div>
                                    <div class="form-inline mb-2">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Address</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $patient->patient_address_line }} -
                                            {{ $patient->patient_address_city }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Doctor</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $visit->visit_doctor_name }} / {{ $visit->visit_doctor_id }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Departement</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $visit->visit_patient_dept }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Status</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $visit->visit_status_timeline }}
                                        </label>
                                    </div>
                                    <div class="form-inline">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Service
                                            Start</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            : {{ $visit->visit_date_arrived }}
                                        </label>
                                    </div>
                                    <div class="form-inline mb-2">
                                        <label class="col-sm-3 mt-2"
                                            style="display: inline-block; text-align:left; font-weight: bold;">Service
                                            Finish</label>
                                        <label class="col-sm-8 mt-2" style="display: inline-block; text-align:left;">
                                            @if ($visit->visit_date_finished == null)
                                                : Still Active
                                            @else
                                                : {{ $visit->visit_date_finished }}
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- DETAIL BILLING --}}
                <div class="card">
                    <div class="card-header">
                        <h4>Laboratory Order</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table-striped table-hover table">
                                    <tr class="text-center">
                                        <th class="w-5">No.</th>
                                        <th class="w-20">Date Request</th>
                                        <th class="w-10">Service Code</th>
                                        <th class="w-40">Service Name</th>
                                        <th class="w-10">Group</th>
                                        <th class="w-5" colspan="2">Charge</th>
                                        <th class="w-5">Action</th>
                                    </tr>
                                    @foreach ($services as $service)
                                                                    <tr>
                                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                                        @php
                                                                            $date = $service->created_at;
                                                                            $date = date('d-m-Y', strtotime($date));
                                                                        @endphp
                                                                        <td class="text-center">{{ $date }}</td>
                                                                        <td>{{ $service->service_code }}</td>
                                                                        <td>{{ $service->service_name }}</td>
                                                                        @php
                                                                            if ($service->service_loinc_code == null) {
                                                                                $type = "Service - ";
                                                                            } else {
                                                                                $type = "Lab - ";
                                                                            }
                                                                        @endphp
                                                                        <td class="text-center">{{ $type . "" . $service->service_group }}</td>
                                                                        @php
                                                                            $price = $service->service_price;
                                                                            $price = number_format($price, 0, ',', '.');
                                                                        @endphp
                                                                        <td class="text-right">Rp.</td>
                                                                        <td class="text-right">{{ $price }}</td>
                                                                        <td class="text-center">
                                                                            <button class="btn btn-danger btn-md  delete-service"
                                                                                data-id="{{ $service->id }}">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                            <script>
                                                                                document.querySelectorAll('.delete-service').forEach(button => {
                                                                                    button.addEventListener('click', function (e) {
                                                                                        e.preventDefault();
                                                                                        const serviceId = this.getAttribute('data-id');
                                                                                        Swal.fire({
                                                                                            title: 'Anda Yakin?',
                                                                                            text: "Pastikan pembatalan order telah dikonfirmasi ke dokter dan sampling !",
                                                                                            icon: 'warning',
                                                                                            showCancelButton: true,
                                                                                            confirmButtonColor: '#d33',
                                                                                            cancelButtonColor: '#3085d6',
                                                                                            confirmButtonText: 'Yakin !'
                                                                                        }).then((result) => {
                                                                                            if (result.isConfirmed) {
                                                                                                fetch(`/visits/deleteservices/${serviceId}`, {
                                                                                                    method: 'GET',
                                                                                                    headers: {
                                                                                                        'X-CSRF-TOKEN': document
                                                                                                            .querySelector(
                                                                                                                'meta[name="csrf-token"]'
                                                                                                            )
                                                                                                            .getAttribute(
                                                                                                                'content')
                                                                                                    }
                                                                                                })
                                                                                                    .then(response => response
                                                                                                        .json())
                                                                                                    .then(data => {
                                                                                                        if (data.success) {
                                                                                                            Swal.fire(
                                                                                                                'Deleted!',
                                                                                                                'The service has been deleted.',
                                                                                                                'success'
                                                                                                            ).then(() => {
                                                                                                                location
                                                                                                                    .reload();
                                                                                                            });
                                                                                                        } else {
                                                                                                            Swal.fire(
                                                                                                                'Error!',
                                                                                                                'There was an error deleting the service.',
                                                                                                                'error'
                                                                                                            );
                                                                                                        }
                                                                                                    })
                                                                                                    .catch(error => {
                                                                                                        Swal.fire(
                                                                                                            'Error!',
                                                                                                            'There was an error processing your request.',
                                                                                                            'error'
                                                                                                        );
                                                                                                    });
                                                                                            }
                                                                                        });
                                                                                    });
                                                                                });
                                                                            </script>
                                                                        </td>
                                                                    </tr>
                                    @endforeach
                                    <tr class="text-black">
                                        <td colspan="5" class="text-right">Total</td>
                                        <td class="text-right">Rp.</td>
                                        <td class="text-right">
                                            @php
                                                //SUM PRICE
                                                $total = 0;
                                                foreach ($services as $service) {
                                                    $total += $service->service_price;
                                                }
                                            @endphp
                                            <b>Rp. {{ number_format($total, 0, ',', '.') }}</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- BILLING --}}
                <form action="{{ route('visits.updatepayment', $visit->id) }}" id="form-id" method="POST">
                    @csrf
                    @method('put')
                    <div class="card">
                        <div class="card-header">
                            <h4>Bill Summary</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-group row">
                                        <label class="col-sm-8 col-form-label text-right mt-2">Sub Total</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input type="text" class="form-control @error('visit_payment_charge')
                                                    is-invalid
                                                @enderror" name="visit_payment_charge" id="visit_payment_charge"
                                                    onKeyup="hitung();" value="{{ $total }}" placeholder="0"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                    readonly>
                                                @error('visit_payment_charge')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8 col-form-label text-right mt-2">Discount</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input type="text" class="form-control @error('visit_payment_discount')
                                                    is-invalid
                                                @enderror" name="visit_payment_discount" id="visit_payment_discount"
                                                    onKeyup="hitung();" value="0" placeholder="0"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                    required>
                                                @error('visit_payment_discount')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-8 col-form-label text-right mt-2">Total</label>
                                        <div class="col-sm-4">
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input type="text" class="form-control @error('visit_payment_total')
                                                    is-invalid
                                                @enderror" name="visit_payment_total" id="visit_payment_total"
                                                    onKeyup="hitung();" value="{{ $total }}" placeholder="0"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                    required>
                                                @error('visit_payment_total')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- BILLING --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Payment Settlement</h4>
                        </div>
                        <div class="card-body">
                            <div ss="row">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label>Payment Method</label>
                                            <select name="visit_payment_method" class="form-control"
                                                id="visit_payment_method" onchange="showDiv(this)" required>
                                                <option value="">- Select Method -</option>
                                                <option value="BPJS">BPJS</option>
                                                <option value="Cash">Cash</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Debit Card">Debit Card</option>
                                                <option value="Insurance">Insurance</option>
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
                                                <input type="text" class="form-control @error('visit_payment_amount')
                                                    is-invalid
                                                @enderror" name="visit_payment_amount" id="visit_payment_amount"
                                                    onKeyup="hitung();" value="{{old('visit_payment_amount')}}"
                                                    placeholder="0"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                    required>
                                                @error('visit_payment_amount')
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
                                                <input type="text" class="form-control @error('visit_payment_remaining')
                                                    is-invalid
                                                @enderror" name="visit_payment_remaining" id="visit_payment_remaining"
                                                    onKeyup="hitung();" value="{{old('visit_payment_remaining')}}"
                                                    placeholder="0" required readonly>
                                                @error('visit_payment_remaining')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                            <input type="text" class="form-control" name="card_cvc" placeholder="CVC"
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
                                            <input type="text" class="form-control" name="card_month" placeholder="MM"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                minlength="2" maxlength="2" min="01" max="12">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label>&nbsp;</label>
                                            @php
                                                $year = date('Y');
                                                $maxyear = $year + 10;
                                            @endphp
                                            <input type="text" class="form-control" name="card_year" placeholder="YYYY"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                minlength="4" maxlength="4" min="{{ $year }}" max="{{ $maxyear }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- DEBIT CARD --}}
                            <div class="row" id="debit_card" style="display: none">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>Bank Name</label>
                                            <select class="form-control" name="bank_name">
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
                                            <input type="text" class="form-control" name="ref_number"
                                                placeholder="Reference Number">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Transaction Date</label>
                                            <input type="text" class="form-control" name="transaction_date"
                                                value="{{ date('Y-m-d H:i:s') }}" placeholder="Transaction Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- BPJS --}}
                            <div class="row" id="bpjs" style="display: none">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>BPJS Number</label>
                                            <input type="text" class="form-control" name="bpjs_number"
                                                value="{{ $visit->visit_patient_account }}" placeholder="BPJS Number"
                                                minlength="16" maxlength="16">
                                        </div>
                                        <div class="form-group col-md-5">
                                            <label>SEP Number</label>
                                            <input type="text" class="form-control" name="bpjs_sep"
                                                placeholder="SEP Number">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Transaction Date</label>
                                            <input type="text" class="form-control" name="bpjs_date"
                                                value="{{ date('Y-m-d H:i:s') }}" placeholder="Transaction Date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- TRANSFER --}}
                            <div ss="row" id="transfer" style="display: none">
                                <div class="col-12 col-md-12 col-lg-12">
                                    <div class="form-row">
                                        <div class="form-group col-md-5">
                                            <label>Bank Name</label>
                                            <select class="form-control" name="bank_name">
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
                                            <input type="text" class="form-control" name="account_name"
                                                placeholder="Account Name">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label>Transaction Date</label>
                                            <input type="text" class="form-control" name="transaction_date"
                                                value="{{ date('Y-m-d H:i:s') }}" placeholder="Transaction Date">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Update Payment</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
<!-- Load SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- SCRIPT PAYMENT METHOD --}}
<script>
    function showDiv(select) {
        if (select.value == "Credit Card") {
            document.getElementById('credit_card').style.display = "block";
            document.getElementById('debit_card').style.display = "none";
            document.getElementById('bpjs').style.display = "none";
        } else if (select.value == "BPJS") {
            document.getElementById('credit_card').style.display = "none";
            document.getElementById('debit_card').style.display = "none";
            document.getElementById('bpjs').style.display = "block";
        } else if (select.value == "Debit Card") {
            document.getElementById('credit_card').style.display = "none";
            document.getElementById('debit_card').style.display = "block";
            document.getElementById('bpjs').style.display = "none";
        } else {
            document.getElementById('credit_card').style.display = "none";
            document.getElementById('debit_card').style.display = "none";
            document.getElementById('bpjs').style.display = "none";
        }
    }
</script>
{{-- END PAYMENT METHOD --}}
<!-- SCRIPT HITUNG PEMBAYARAN -->
<script>
    function hitung() {
        var subtotal = document.getElementById('visit_payment_charge').value;
        var discount = document.getElementById('visit_payment_discount').value;
        var amount = document.getElementById('visit_payment_amount').value;
        var totalpay = (parseInt(subtotal)) - (parseInt(discount));
        var payment = (parseInt(subtotal)) - (parseInt(discount)) - (parseInt(amount));
        if (!isNaN(totalpay) && amount <= 0) {
            document.getElementById('visit_payment_total').value = totalpay;
            document.getElementById('visit_payment_remaining').value = totalpay;
        } else if (!isNaN(totalpay) && amount > 0) {
            document.getElementById('visit_payment_total').value = subtotal;
            document.getElementById('visit_payment_remaining').value = payment;
        } else {
            document.getElementById('visit_payment_total').value = subtotal;
            document.getElementById('visit_payment_remaining').value = totalpay;
        }
    }
</script>
<!-- END SCRIPT HITUNG -->
@push('scripts')
@endpush
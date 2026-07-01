@extends('layouts.app')

@section('title', 'Form Kesmas Order')

@push('style')
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
                <h1>Form Kesmas Order</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Kesmas Orders</div>
                </div>
            </div>
            <div class="section-body">
                <form action="{{ route('kesmas.store') }}" method="POST">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4>New Kesmas Order</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="col-sm-4 mt-0">
                                    <label>Kesmas Laboratory Form</label>
                                </div>
                                <div class="form-group col-sm-4 mt-0">
                                    <label>FPPS Number</label>
                                    <input type="text" class="form-control @error('order_code')
                                        is-invalid
                                    @enderror" name="order_code" value="{{ $nextcode }}" placeholder="FPPS Number"
                                        readonly>
                                    @error('order_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-4 mt-0">
                                    <label>Registration Date</label>
                                    <input type="text" class="form-control @error('order_date')
                                        is-invalid
                                    @enderror" name="order_date" value="{{ date('Y-m-d H:i:s') }}"
                                        placeholder="Order Date" readonly>
                                    @error('order_date')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- CUSTOMER --}}
                    <div class="card">
                        <div class="card-header">
                            <h4>Customer Detail</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Customer ID</label>
                                <div class="col-sm-7 mt-2">
                                    <div class="input-group">
                                        <select name="customer_code" id="customer_code" class="form-control select2">
                                            <option value="">- Select Customer -</option>
                                            @foreach ($customers as $customer)
                                                <option value="{{ $customer->customer_code }}">{{ $customer->customer_code }} -
                                                    {{ $customer->customer_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2 mt-2">
                                    {{-- BUTTON NEW PATIENT --}}
                                    <a href="{{ route('customers.create') }}"
                                        class="btn btn-success btn-lg btn-block btn-icon-split">
                                        <i class="fas fa-plus"></i> New Customer
                                    </a>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Customer Name</label>
                                <div class="col-sm-9 mt-2">
                                    <input type="text" class="form-control @error('customer_name')
                                        is-invalid
                                    @enderror" name="customer_name" value="{{ old('customer_name') }}"
                                        id="customer_name" placeholder="Customer Name" readonly>
                                    @error('customer_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Address</label>
                                <div class="col-sm-9 mt-2">
                                    <input type="text" class="form-control @error('customer_address')
                                        is-invalid
                                    @enderror" name="customer_address" value="{{ old('customer_address') }}"
                                        id="customer_address" placeholder="Customer Address" readonly>
                                    @error('customer_address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Customer Contact</label>
                                <div class="col-sm-4 mt-2">
                                    <input type="text" class="form-control @error('customer_phone')
                                        is-invalid
                                    @enderror" name="customer_phone" value="{{ old('customer_phone') }}"
                                        id="customer_phone" placeholder="Phone" readonly>
                                    @error('customer_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-5 mt-2">
                                    <input type="text" class="form-control @error('customer_email')
                                        is-invalid
                                    @enderror" name="customer_email" value="{{ old('customer_email') }}"
                                        id="customer_email" placeholder="email@customer.com" readonly>
                                    @error('customer_email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 mt-2 col-form-label">Person In Charge</label>
                                <div class="col-sm-4 mt-2">
                                    <input type="text" class="form-control @error('customer_pic')
                                        is-invalid
                                    @enderror" name="customer_pic" value="{{ old('customer_pic') }}" id="customer_pic"
                                        placeholder="PIC Name">
                                    @error('customer_pic')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-sm-5 mt-2">
                                    <input type="text" class="form-control @error('customer_pic_phone')
                                        is-invalid
                                    @enderror" name="customer_pic_phone" value="{{ old('customer_pic_phone') }}"
                                        id="customer_pic_phone" placeholder="PIC Phone">
                                    @error('customer_pic_phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <input type="hidden" name="order_total" value="0" id="order_total">
                        <input type="hidden" name="order_user" value="{{ auth()->user()->id }}" id="order_user">
                        <div class="card-footer text-right">
                            <button class="btn btn-primary" type="submit">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    {{-- MODAL PATIENT LIST --}}
    {{-- END MODAL PATIENT LIST --}}
@endsection
@push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('modules/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script>
        $(document).ready(function () {
            $('#customer_code').change(function () {
                var customerCode = $(this).val();
                if (customerCode) {
                    $.ajax({
                        url: '/customers/get-detail/' + customerCode,
                        type: 'GET',
                        dataType: 'json',
                        success: function (data) {
                            $('#customer_name').val(data.customer_name);
                            $('#customer_address').val(data.customer_address);
                            $('#customer_phone').val(data.customer_phone);
                            $('#customer_email').val(data.customer_email);
                            $('#customer_pic').val(data.customer_pic);
                            $('#customer_pic_phone').val(data.customer_pic_phone);
                        }
                    });
                } else {
                    $('#customer_name').val('');
                    $('#customer_address').val('');
                    $('#customer_phone').val('');
                    $('#customer_email').val('');
                    $('#customer_pic').val('');
                    $('#customer_pic_phone').val('');
                }
            });
        });
    </script>
@endpush
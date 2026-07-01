@extends('layouts.app')

@section('title', 'Form Parameters Test')

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
                <h1>Form Parameter Tests</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Forms</a></div>
                    <div class="breadcrumb-item">Parameter Test</div>
                </div>
            </div>
            <div class="section-body">
                <form action="{{ route('parameter.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                {{-- LOCAL CODE --}}
                                <div class="card-header">
                                    <h4>Kesmas Parameter Code</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label mt-2">Parameter Code</label>
                                        <div class="col-sm-10 mt-2">
                                            <input type="text" class="form-control @error('parameter_code')
                                                is-invalid
                                            @enderror" name="parameter_code"
                                                onkeyup="this.value = this.value.toUpperCase();"
                                                value="{{ old('parameter_code') }}" id="parameter_code"
                                                placeholder="Unique 3 Digit Alfabetic Code" minlength="3" maxlength="3"
                                                required>
                                            @error('parameter_code')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Parameter Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('parameter_name')
                                                is-invalid
                                            @enderror" name="parameter_name" value="{{ old('parameter_name') }}"
                                                placeholder="Parameter Name" required>
                                            @error('parameter_name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Parameter Group</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_group" value="{{ old('parameter_group') }}"
                                                class="form-control" id="parameter_group" required>
                                                <option value="">- Select Group -</option>
                                                <option value="KA">Kimia Kesmas</option>
                                                <option value="MK">Mikro Kesmas</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Parameter Sub Group</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_subgroup" value="{{ old('parameter_subgroup') }}"
                                                class="form-control" id="parameter_subgroup" required>
                                                <option value="">- Select Sub Group -</option>
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
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Specimen Type</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_specimen" value="{{ old('parameter_specimen') }}"
                                                class="form-control" id="parameter_specimen" required>
                                                <option value="">- Select Specimen -</option>
                                                <option value="Air">Air</option>
                                                <option value="Makanan">Makanan</option>
                                                <option value="Material">Material</option>
                                                <option value="Swab">Swab</option>
                                                <option value="Udara">Udara</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Parameter Method</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control @error('parameter_method')
                                                is-invalid
                                            @enderror" name="parameter_method" id="parameter_method"
                                                value="{{ old('parameter_method') }}" placeholder="Parameter Method"
                                                required>
                                            @error('parameter_method')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Specimen Container</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_container" value="{{ old('parameter_container') }}"
                                                class="form-control" id="parameter_container" required>
                                                <option value="">- Select Container -</option>
                                                <option value="Cryo Tube">Cryotube</option>
                                                <option value="Borosilicate Glass Bottle">Borosilicate Glass Bottle</option>
                                                <option value="Glass Bottle">Glass Bottle</option>
                                                <option value="Gas Bottle">Gas Bottle</option>
                                                <option value="Plastic Bottle">Plastic Bottle</option>
                                                <option value="Sterile Bottle">Sterile Bottle</option>
                                                <option value="Sterile Pot">Sterile Pot</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Turn Around Time (days)</label>
                                        <div class="col-sm-4">
                                            <input type="number" class="form-control @error('parameter_time')
                                                is-invalid
                                            @enderror" name="parameter_time" id="parameter_time"
                                                value="{{ old('parameter_time') }}" placeholder="7" required>
                                            @error('parameter_time')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Result Scale</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_reference_type"
                                                value="{{ old('parameter_reference_type') }}" class="form-control"
                                                id="parameter_reference_type" required>
                                                <option value="">- Select Scale -</option>
                                                <option value="Qn">Quantitative</option>
                                                <option value="Ord">Ordinal</option>
                                                <option value="Nar">Narrative</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Parameter Accredition</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_acreditation"
                                                value="{{ old('parameter_reference_type') }}" class="form-control"
                                                id="parameter_reference_type" required>
                                                <option value="">- Select Accredition -</option>
                                                <option value="ISO">ISO</option>
                                                <option value="KALK">KALK</option>
                                                <option value="KAN">KAN</option>
                                                <option value="KLHK">KLHK</option>
                                                <option value="NA">Not Accredited</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Reference</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control @error('parameter_reference_value')
                                                is-invalid
                                            @enderror" name="parameter_reference_value" id="parameter_reference_value"
                                                value="{{ old('parameter_reference_value') }}"
                                                placeholder="Reference Value">
                                            @error('parameter_method')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <label class="col-sm-2 col-form-label">Unit</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control @error('parameter_unit')
                                                is-invalid
                                            @enderror" name="parameter_unit" id="parameter_unit"
                                                value="{{ old('parameter_unit') }}" placeholder="Unit of Measure">
                                            @error('parameter_method')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Parameter Description</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control @error('parameter_description')
                                                is-invalid
                                            @enderror" name="parameter_description" id="parameter_description"
                                                value="{{ old('parameter_description') }}"
                                                placeholder="Parameter Description" required>
                                            @error('parameter_description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                {{-- CATEGORY --}}
                                <div class="card-header" id="CategoryHeader">
                                    <h4>Parameter Category</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Parameter Category</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_category" value="{{ old('parameter_category') }}"
                                                class="form-control" id="parameter_category" required>
                                                <option value="">- Select Category -</option>
                                                <option value="Panel">Panel</option>
                                                <option value="Sub Panel">Sub Panel</option>
                                                <option value="Single">Single</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label" id="partoflabel">Part of</label>
                                        <div class="col-sm-4" id="partofform">
                                            <select name="parameter_parent" class="form-control selectric @error('parameter_parent')
                                            is-invalid @enderror">
                                                <option value="">- Select Panel -</option>
                                                @foreach ($panels as $panel)
                                                    <option value="{{ $panel->parameter_code}}">{{ $panel->parameter_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Parameter Status</label>
                                        <div class="col-sm-4">
                                            <select name="parameter_status" value="{{ old('parameter_status') }}"
                                                class="form-control" id="parameter_status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-2 col-form-label">Price</label>
                                        <div class="col-sm-4">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">Rp</div>
                                                </div>
                                                <input type="text" class="form-control @error('parameter_price')
                                                    is-invalid
                                                @enderror" name="parameter_price" id="parameter_price"
                                                    value="{{ old('parameter_price') }}" placeholder="50000"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                    required>
                                                @error('parameter_price')
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
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-footer text-right">
                                        <button class="btn btn-primary">Submit</button>
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
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <script>
        document.getElementById("parameter_name").addEventListener("keyup", function () {
            const inputValue = this.value;
            const titleCaseValue = inputValue.replace(/\w\S*/g, (txt) => txt.charAt(0).toUpperCase() + txt.substr(1)
                .toLowerCase());
            this.value = titleCaseValue;
        });
    </script>
    <script>
        function hanyaHuruf(evt) {
            const charCode = evt.which || evt.keyCode;
            // Hanya izinkan huruf (a-z dan A-Z)
            if ((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122)) {
                return true;
            } else {
                return false;
            }
        }
    </script>
    {{-- SELECTED CATEGORY--}}
    <script>
        $(document).ready(function () {
            $('#parameter_category').change(function () {
                console.log("change");
                var category = document.getElementById('parameter_category').value;
                if (category == "Sub Panel") {
                    document.getElementById('partoflabel').style.display = 'block';
                    document.getElementById('partofform').style.display = 'block';
                } else {
                    document.getElementById('partoflabel').style.display = 'none';
                    document.getElementById('partofform').style.display = 'none';
                }
            });
        });
    </script>
@endpush
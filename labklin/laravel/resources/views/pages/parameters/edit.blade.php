@extends('layouts.app')

@section('title', 'Edit Parameter')

@push('style')
<link rel="stylesheet" href="{{ asset('library/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Parameter</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Edit Parameter</div>
            </div>
        </div>

        <div class="section-body">
            <form action="{{ route('parameter.update', $parameters->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Kesmas Parameter Code</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Parameter Code</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('parameter_code') is-invalid @enderror"
                                            name="parameter_code"
                                            value="{{ old('parameter_code', $parameters->parameter_code) }}"
                                            id="parameter_code" placeholder="3 Digit Alfabetic Code" minlength="3"
                                            maxlength="3" onkeyup="this.value = this.value.toUpperCase();" required>
                                        @error('parameter_code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Parameter Name</label>
                                    <div class="col-sm-10">
                                        <input type="text"
                                            class="form-control @error('parameter_name') is-invalid @enderror"
                                            name="parameter_name"
                                            value="{{ old('parameter_name', $parameters->parameter_name) }}"
                                            placeholder="Parameter Name" required>
                                        @error('parameter_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Parameter Group</label>
                                    <div class="col-sm-4">
                                        <select name="parameter_group" class="form-control" id="parameter_group"
                                            required>
                                            <option value="">- Select Group -</option>
                                            <option value="KA" @selected($parameters->parameter_group == 'KA')>Kimia
                                                Kesmas</option>
                                            <option value="MK" @selected($parameters->parameter_group == 'MK')>Mikro
                                                Kesmas</option>
                                            <option value="Other" @selected($parameters->parameter_group ==
                                                'Other')>Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Parameter Sub Group</label>
                                    <div class="col-sm-4">
                                        <select name="parameter_subgroup" class="form-control" id="parameter_subgroup"
                                            required>
                                            <option value="">- Select Sub Group -</option>
                                            <option value="AH" @selected($parameters->parameter_subgroup == 'AH')>Air
                                                Higiene dan Sanitasi</option>
                                            <option value="AK" @selected($parameters->parameter_subgroup == 'AK')>Air
                                                Kolam Renang</option>
                                            <option value="AT" @selected($parameters->parameter_subgroup == 'AL')>Air
                                                Laut</option>
                                            <option value="AL" @selected($parameters->parameter_subgroup == 'AL')>Air
                                                Limbah</option>
                                            <option value="AM" @selected($parameters->parameter_subgroup == 'AM')>Air
                                                Minum</option>
                                            <option value="AU" @selected($parameters->parameter_subgroup == 'AU')>Air
                                                Pemandian Umum</option>
                                            <option value="AP" @selected($parameters->parameter_subgroup == 'AP')>Air
                                                SPA</option>
                                            <option value="AS" @selected($parameters->parameter_subgroup == 'AS')>Air
                                                Sungai/Danau</option>
                                            <option value="LN" @selected($parameters->parameter_subgroup == 'LN')>Linen
                                            </option>
                                            <option value="MS" @selected($parameters->parameter_subgroup == 'MS')>Alat
                                                Masak</option>
                                            <option value="MM" @selected($parameters->parameter_subgroup ==
                                                'MM')>Makanan Minuman</option>
                                            <option value="US" @selected($parameters->parameter_subgroup == 'US')>Usap
                                                Swab</option>
                                            <option value="MT" @selected($parameters->parameter_subgroup == 'MT')>Media
                                                Tanah</option>
                                            <option value="KU" @selected($parameters->parameter_subgroup ==
                                                'KU')>Kualitas Udara</option>
                                            <option value="OL" @selected($parameters->parameter_subgroup == 'OL')>Other
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Specimen Type</label>
                                    <div class="col-sm-4">
                                        <select name="parameter_specimen" class="form-control" id="parameter_specimen"
                                            required>
                                            <option value="">- Select Specimen -</option>
                                            <option value="Air"
                                                {{ old('parameter_specimen', $parameters->parameter_specimen) == 'Air' ? 'selected' : '' }}>
                                                Air</option>
                                            <option value="Makanan"
                                                {{ old('parameter_specimen', $parameters->parameter_specimen) == 'Makanan' ? 'selected' : '' }}>
                                                Makanan</option>
                                            <option value="Material"
                                                {{ old('parameter_specimen', $parameters->parameter_specimen) == 'Material' ? 'selected' : '' }}>
                                                Material</option>
                                            <option value="Swab"
                                                {{ old('parameter_specimen', $parameters->parameter_specimen) == 'Swab' ? 'selected' : '' }}>
                                                Swab</option>
                                            <option value="Udara"
                                                {{ old('parameter_specimen', $parameters->parameter_specimen) == 'Udara' ? 'selected' : '' }}>
                                                Udara</option>
                                            <option value="Other"
                                                {{ old('parameter_specimen', $parameters->parameter_specimen) == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Parameter Method</label>
                                    <div class="col-sm-4">
                                        <input type="text"
                                            class="form-control @error('parameter_method') is-invalid @enderror"
                                            name="parameter_method" id="parameter_method"
                                            value="{{ old('parameter_method', $parameters->parameter_method) }}"
                                            placeholder="Parameter Method" required>
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
                                        <select name="parameter_container" class="form-control" id="parameter_container"
                                            required>
                                            <option value="">- Select Container -</option>
                                            <option value="Cryo Tube"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Cryo Tube' ? 'selected' : '' }}>
                                                Cryotube</option>
                                            <option value="Borosilicate Glass Bottle"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Borosilicate Glass Bottle' ? 'selected' : '' }}>
                                                Borosilicate Glass Bottle</option>
                                            <option value="Glass Bottle"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Glass Bottle' ? 'selected' : '' }}>
                                                Glass Bottle</option>
                                            <option value="Gas Bottle"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Gas Bottle' ? 'selected' : '' }}>
                                                Gas Bottle</option>
                                            <option value="Plastic Bottle"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Plastic Bottle' ? 'selected' : '' }}>
                                                Plastic Bottle</option>
                                            <option value="Sterile Bottle"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Sterile Bottle' ? 'selected' : '' }}>
                                                Sterile Bottle</option>
                                            <option value="Sterile Pot"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Sterile Pot' ? 'selected' : '' }}>
                                                Sterile Pot</option>
                                            <option value="Other"
                                                {{ old('parameter_container', $parameters->parameter_container) == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Turn Around Time (days)</label>
                                    <div class="col-sm-4">
                                        <input type="number"
                                            class="form-control @error('parameter_time') is-invalid @enderror"
                                            name="parameter_time" id="parameter_time"
                                            value="{{ old('parameter_time', $parameters->parameter_time) }}"
                                            placeholder="7" required>
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
                                        <select name="parameter_reference_type" class="form-control"
                                            id="parameter_reference_type" required>
                                            <option value="">- Select Scale -</option>
                                            <option value="Qn"
                                                {{ old('parameter_reference_type', $parameters->parameter_reference_type) == 'Qn' ? 'selected' : '' }}>
                                                Quantitative</option>
                                            <option value="Ord"
                                                {{ old('parameter_reference_type', $parameters->parameter_reference_type) == 'Ord' ? 'selected' : '' }}>
                                                Ordinal</option>
                                            <option value="Nar"
                                                {{ old('parameter_reference_type', $parameters->parameter_reference_type) == 'Nar' ? 'selected' : '' }}>
                                                Narrative</option>
                                            <option value="Other"
                                                {{ old('parameter_reference_type', $parameters->parameter_reference_type) == 'Other' ? 'selected' : '' }}>
                                                Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Parameter Accredition</label>
                                    <div class="col-sm-4">
                                        <select name="parameter_acreditation" class="form-control"
                                            id="parameter_reference_type" required>
                                            <option value="">- Select Accredition -</option>
                                            <option value="ISO"
                                                {{ old('parameter_acreditation', $parameters->parameter_acreditation) == 'ISO' ? 'selected' : '' }}>
                                                ISO</option>
                                            <option value="KALK"
                                                {{ old('parameter_acreditation', $parameters->parameter_acreditation) == 'KALK' ? 'selected' : '' }}>
                                                KALK</option>
                                            <option value="KAN"
                                                {{ old('parameter_acreditation', $parameters->parameter_acreditation) == 'KAN' ? 'selected' : '' }}>
                                                KAN</option>
                                            <option value="KLHK"
                                                {{ old('parameter_acreditation', $parameters->parameter_acreditation) == 'KLHK' ? 'selected' : '' }}>
                                                KLHK</option>
                                            <option value="NA"
                                                {{ old('parameter_acreditation', $parameters->parameter_acreditation) == 'NA' ? 'selected' : '' }}>
                                                Not Accredited</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Reference</label>
                                    <div class="col-sm-4">
                                        <input type="text"
                                            class="form-control @error('parameter_reference_value') is-invalid @enderror"
                                            name="parameter_reference_value" id="parameter_reference_value"
                                            value="{{ old('parameter_reference_value', $parameters->parameter_reference_value) }}"
                                            placeholder="Reference Value">
                                        @error('parameter_reference_value')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <label class="col-sm-2 col-form-label">Unit</label>
                                    <div class="col-sm-4">
                                        <input type="text"
                                            class="form-control @error('parameter_unit') is-invalid @enderror"
                                            name="parameter_unit" id="parameter_unit"
                                            value="{{ old('parameter_unit', $parameters->parameter_unit) }}"
                                            placeholder="Unit of Measure">
                                        @error('parameter_unit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Parameter Category</label>
                                    <div class="col-sm-4">
                                        <select name="parameter_category" class="form-control" id="parameter_category"
                                            required>
                                            <option value="">- Select Category -</option>
                                            <option value="Panel" @selected($parameters->parameter_category ==
                                                'Panel')>Panel</option>
                                            <option value="Sub Panel" @selected($parameters->parameter_category == 'Sub
                                                Panel')>Sub Panel</option>
                                            <option value="Single" @selected($parameters->parameter_category ==
                                                'Single')>Single</option>
                                        </select>
                                    </div>

                                    <label class="col-sm-2 col-form-label">Part of (if Sub Panel)</label>
                                    <div class="col-sm-4">
                                        <select name="parameter_parent" class="form-control selectric">
                                            <option value="">- Select Panel -</option>
                                            @foreach ($panels as $panel)
                                            <option value="{{ $panel->parameter_code }}" @selected($parameters->
                                                parameter_parent == $panel->parameter_code)>
                                                {{ $panel->parameter_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Parameter Price</label>
                                    <div class="col-sm-4">
                                        <div class="input-group mb-2">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">Rp</div>
                                            </div>
                                            <input type="text"
                                                class="form-control @error('parameter_price') is-invalid @enderror"
                                                name="parameter_price"
                                                value="{{ old('parameter_price', $parameters->parameter_price) }}"
                                                placeholder="50000"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                                            @error('parameter_price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <label class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-4">
                                        <select name="parameter_status" class="form-control" id="parameter_status"
                                            required>
                                            <option value="active" @selected($parameters->parameter_status ==
                                                'active')>Active</option>
                                            <option value="inactive" @selected($parameters->parameter_status ==
                                                'inactive')>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button class="btn btn-primary">Update</button>
                                <a href="{{ route('parameter.index') }}" class="btn btn-secondary">Cancel</a>
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
<script src="{{ asset('library/select2/dist/js/select2.full.min.js') }}"></script>
<script>
$(document).ready(function() {
    $('#parameter_category').change(function() {
        var category = $(this).val();
        if (category == "Sub Panel") {
            $('#partoflabel, #partofform').show();
        } else {
            $('#partoflabel, #partofform').hide();
        }
    }).trigger('change'); // trigger untuk menyesuaikan tampilan saat pertama kali halaman dimuat
});
</script>
@endpush
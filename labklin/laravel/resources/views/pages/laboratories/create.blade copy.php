@extends('layouts.app')

@section('title', 'Form Laboratory Test')

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
            <h1>Form Laboratory Tests</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Forms</a></div>
                <div class="breadcrumb-item">Laboratory Test</div>
            </div>
        </div>
        <div class="section-body">
            <form action="{{ route('laboratory.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            {{-- LOINC CODE --}}
                            <div class="card-header">
                                <h4>Laboratory Test Code - LOINC Terminology</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label mt-2">LOINC Code</label>
                                    <div class="col-sm-2 mt-2">
                                        <div class="input-group">
                                            <input type="text" name="test_loinc_code"
                                                value="{{ old('test_loinc_code') }}" id="test_loinc_code"
                                                class="form-control" placeholder="Code" aria-label="">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="button" data-toggle="modal"
                                                    data-target="#modal-loinc"><i
                                                        class="fas fa-search d-none d-sm-inline"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-7 mt-2">
                                        <input type="text" class="form-control @error('test_loinc_display')
                                                is-invalid
                                            @enderror" name="test_loinc_display"
                                            value="{{ old('test_loinc_display') }}" id="test_loinc_display"
                                            placeholder="LOINC Display" required readonly>
                                        @error('test_loinc_display')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label mt-2"></label>
                                    <div class="col-sm-3 mt-2">
                                        <input type="text" class="form-control @error('test_loinc_component')
                                                is-invalid
                                            @enderror" name="test_loinc_component"
                                            value="{{ old('test_loinc_component') }}" id="test_loinc_component"
                                            placeholder="Component" readonly>
                                        @error('test_loinc_component')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2 mt-2">
                                        <input type="text" class="form-control @error('test_loinc_method')
                                                is-invalid
                                            @enderror" name="loinc_method" value="{{ old('test_loinc_method') }}"
                                            id="test_loinc_method" placeholder="Method" readonly>
                                        @error('test_loinc_method')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2 mt-2">
                                        <input type="text" class="form-control @error('test_loinc_unitofmeasure')
                                                is-invalid
                                            @enderror" name="test_loinc_unitofmeasure"
                                            value="{{ old('test_loinc_unitofmeasure') }}" id="test_loinc_unitofmeasure"
                                            placeholder="Unit" readonly>
                                        @error('test_loinc_unitofmeasure')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm-2 mt-2">
                                        <input type="text" class="form-control @error('test_loinc_scale')
                                                is-invalid
                                            @enderror" name="test_loinc_scale" value="{{ old('test_loinc_scale') }}"
                                            id="test_loinc_scale" placeholder="Skala" readonly>
                                        @error('test_loinc_scale')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- LOCAL CODE --}}
                            <div class="card-header">
                                <h4>Laboratory Test Code - Local Terminology</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label mt-2">Test Code</label>
                                    <div class="col-sm-10 mt-2">
                                        <input type="text" class="form-control @error('test_code')
                                                is-invalid
                                            @enderror" name="test_code"
                                            onkeyup="this.value = this.value.toUpperCase();"
                                            value="{{ old('test_code') }}" id="test_code"
                                            placeholder="Unique 3 Digit Alfabetic Code" minlength="3" maxlength="3"
                                            required>
                                        @error('test_code')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Test Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control @error('test_name')
                                                is-invalid
                                            @enderror" name="test_name" value="{{ old('test_name') }}"
                                            placeholder="Test Name" required>
                                        @error('test_name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Test Group</label>
                                    <div class="col-sm-4">
                                        <select name="test_group" value="{{ old('test_group') }}" class="form-control"
                                            id="test_group" required>
                                            <option value="">- Select Group -</option>
                                            <option value="Bacteriology">Bacteriology</option>
                                            <option value="Biochemistry">Biochemistry</option>
                                            <option value="Genomics">Genomics</option>
                                            <option value="Hematology">Hematology</option>
                                            <option value="Immunology">Immunology</option>
                                            <option value="Microbiology">Microbiology</option>
                                            <option value="Parasitology">Parasitology</option>
                                            <option value="Serology">Serology</option>
                                            <option value="Toxicology">Toxicology</option>
                                            <option value="Urinology">Urinology</option>
                                            <option value="Virology">Virology</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Test Sub Group</label>
                                    <div class="col-sm-4">
                                        <select name="test_subgroup" value="{{ old('test_subgroup') }}"
                                            class="form-control" id="test_subgroup" required>
                                            <option value="">- Select Sub Group -</option>
                                            <option value="Anemia">Anemia</option>
                                            <option value="Cardiac">Cardiac</option>
                                            <option value="Diabetes">Diabetes</option>
                                            <option value="Drug">Drug</option>
                                            <option value="Fertility">Fertility</option>
                                            <option value="Gastric">Gastric</option>
                                            <option value="Hemostasis">Hemostasis</option>
                                            <option value="Immune">Immune</option>
                                            <option value="Infectious">Infectious</option>
                                            <option value="Imflamatory">Imflamatory</option>
                                            <option value="Ion">Ion</option>
                                            <option value="Lipid">Lipid</option>
                                            <option value="Liver">Liver</option>
                                            <option value="Pancreatic">Pancreatic</option>
                                            <option value="Renal">Renal</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Specimen Type</label>
                                    <div class="col-sm-4">
                                        <select name="test_specimen" value="{{ old('test_specimen') }}"
                                            class="form-control" id="test_specimen" required>
                                            <option value="">- Select Specimen -</option>
                                            <option value="Arterial Blood">Arterial Blood</option>
                                            <option value="Capillary Blood">Capillary Blood</option>
                                            <option value="Cerebrospinal Fluid">Cerebrospinal Fluid</option>
                                            <option value="Feaces">Feaces</option>
                                            <option value="Serum">Serum</option>
                                            <option value="Skin Scraping">Skin Scraping</option>
                                            <option value="Sputum">Sputum</option>
                                            <option value="Swab">Swab</option>
                                            <option value="Urine">Urine</option>
                                            <option value="Urine 24H">Urine 24H</option>
                                            <option value="Plasma Citrate 1:4">Plasma Citrate 1:4</option>
                                            <option value="Plasma Citrate 1:9">Plasma Citrate 1:9</option>
                                            <option value="Plasma Heparin">Plasma Heparin</option>
                                            <option value="Preparat">Preparat</option>
                                            <option value="Vaginal Secret">Vaginal Secret</option>
                                            <option value="Whole Blood EDTA">Whole Blood EDTA</option>
                                            <option value="Whole Blood Citrate">Whole Blood Citrate</option>
                                            <option value="Whole Blood Plain">Whole Blood Plain</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Test Method</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control @error('test_method')
                                                is-invalid
                                            @enderror" name="test_method" id="test_method"
                                            value="{{ old('test_method') }}" placeholder="Test Method" required>
                                        @error('test_method')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Specimen Container</label>
                                    <div class="col-sm-4">
                                        <select name="test_container" value="{{ old('test_container') }}"
                                            class="form-control" id="test_container" required>
                                            <option value="">- Select Container -</option>
                                            <option value="Plain Tube">Plain - Red Tube</option>
                                            <option value="Sterile Pot">Sterile Pot</option>
                                            <option value="Clean Pot">Clean Pot</option>
                                            <option value="EDTA - Purple Tube">EDTA - Purple Tube</option>
                                            <option value="PST - Light Green Tube">PST - Light Green Tube</option>
                                            <option value="SST - Yellow Tube">SST - Yellow Tube</option>
                                            <option value="Citrate - Light Blue Tube">Citrate - Light Blue Tube</option>
                                            <option value="Heparine - Green Tube">Heparine - Green Tube</option>
                                            <option value="TE - Dark Blue Tube">TE - Dark Blue Tube</option>
                                            <option value="Fluoride - Light Gray Tube">Fluoride - Light Gray Tube
                                            </option>
                                            <option value="Bactect Tube">Bactect Tube</option>
                                            <option value="Amies Medium">Amies Medium</option>
                                            <option value="Viral Transport Medium">Viral Transport Medium</option>
                                            <option value="Non Container">Non Container</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Specimen Volume</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control @error('test_specimen_vol')
                                                is-invalid
                                            @enderror" name="test_specimen_vol" id="test_specimen_vol"
                                            value="{{ old('test_specimen_vol') }}" placeholder="3 mL" required>
                                        @error('test_specimen_vol')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Result Scale</label>
                                    <div class="col-sm-4">
                                        <select name="test_resulttype" value="{{ old('test_resulttype') }}"
                                            class="form-control" id="test_resulttype" required>
                                            <option value="">- Select Scale -</option>
                                            <option value="Qn">Quantitative</option>
                                            <option value="Ord">Ordinal</option>
                                            <option value="OrdQn">Quantitative or Ordinal</option>
                                            <option value="Nom">Nominal</option>
                                            <option value="Nar">Narrative</option>
                                            <option value="Doc">Document</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label">Unit</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control @error('test_unit')
                                                is-invalid
                                            @enderror" name="test_unit" id="test_unit" value="{{ old('test_unit') }}"
                                            placeholder="Unit of Measure">
                                        @error('test_method')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- LOCAL CODE --}}
                            <div class="card-header" id="ReferenceHeader" style="display: none">
                                <h4>Test Reference Value</h4>
                            </div>
                            {{-- QUANTITATIVE --}}
                            <div class="card-body" id="Qn" style="display: none">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label>Rate Plan</label>
                                            <input type="text" value="General" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label>Minimum</label>
                                            <input type="text" name="test_min_general" id="test_min_general"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label>Maximum</label>
                                            <input type="text" name="test_max_general" id="test_max_general"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <label>Unit</label>
                                            <input type="text" name="test_unit_general" id="test_unit_general"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Normal Value Display</label>
                                            <input type="text" name="test_normal_general" id="test_normal_general"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Male" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_min_male" id="test_min_male"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_max_male" id="test_max_male"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_unit_male" id="test_unit_male"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="test_normal_male" id="test_normal_male"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Female" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_min_female" id="test_min_female"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_max_female" id="test_max_female"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_unit_female" id="test_unit_female"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="test_normal_female" id="test_normal_female"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Child" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_min_child" id="test_min_child"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_max_child" id="test_max_child"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_unit_child" id="test_unit_child"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="test_normal_child" id="test_normal_child"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Baby" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_min_baby" id="test_min_baby"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_max_baby" id="test_max_baby"
                                                class="form-control">
                                        </div>
                                        <div class="form-group col-md-1">
                                            <input type="text" name="test_unit_baby" id="test_unit_baby"
                                                class="form-control" readonly>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <input type="text" name="test_normal_baby" id="test_normal_baby"
                                                class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- ORDINAL --}}
                            <div class="card-body" id="Ord" style="display: none">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label>Rate Plan</label>
                                            <input type="text" value="General" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label>Normal Value</label>
                                            <select name="test_normal_general_ord"
                                                value="{{ old('test_normal_general_ord') }}" class="form-control"
                                                id="test_normal_general_ord">
                                                <option value="">- Select -</option>
                                                <option value="Negative">Negative</option>
                                                <option value="Positive">Positive</option>
                                                <option value="Reactive">Reactive</option>
                                                <option value="Non Reactive">Non Reactive</option>
                                                <option value="Intemediate">Intemediate</option>
                                                <option value="Indeterminate">Indeterminate</option>
                                                <option value="1+">1+</option>
                                                <option value="2+">2+</option>
                                                <option value="3+">3+</option>
                                                <option value="4+">4+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Male" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <select name="test_normal_male_ord"
                                                value="{{ old('test_normal_male_ord') }}" class="form-control"
                                                id="test_normal_male_ord">
                                                <option value="">- Select -</option>
                                                <option value="Negative">Negative</option>
                                                <option value="Positive">Positive</option>
                                                <option value="Reactive">Reactive</option>
                                                <option value="Non Reactive">Non Reactive</option>
                                                <option value="Intemediate">Intemediate</option>
                                                <option value="Indeterminate">Indeterminate</option>
                                                <option value="1+">1+</option>
                                                <option value="2+">2+</option>
                                                <option value="3+">3+</option>
                                                <option value="4+">4+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Female" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <select name="test_normal_female_ord"
                                                value="{{ old('test_normal_female_ord') }}" class="form-control"
                                                id="test_normal_female_ord">
                                                <option value="">- Select -</option>
                                                <option value="Negative">Negative</option>
                                                <option value="Positive">Positive</option>
                                                <option value="Reactive">Reactive</option>
                                                <option value="Non Reactive">Non Reactive</option>
                                                <option value="Intemediate">Intemediate</option>
                                                <option value="Indeterminate">Indeterminate</option>
                                                <option value="1+">1+</option>
                                                <option value="2+">2+</option>
                                                <option value="3+">3+</option>
                                                <option value="4+">4+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Child" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <select name="test_normal_child_ord"
                                                value="{{ old('test_normal_child_ord') }}" class="form-control"
                                                id="test_normal_child_ord">
                                                <option value="">- Select -</option>
                                                <option value="Negative">Negative</option>
                                                <option value="Positive">Positive</option>
                                                <option value="Reactive">Reactive</option>
                                                <option value="Non Reactive">Non Reactive</option>
                                                <option value="Intemediate">Intemediate</option>
                                                <option value="Indeterminate">Indeterminate</option>
                                                <option value="1+">1+</option>
                                                <option value="2+">2+</option>
                                                <option value="3+">3+</option>
                                                <option value="4+">4+</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Baby" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <select name="test_normal_baby_ord"
                                                value="{{ old('test_normal_baby_ord') }}" class="form-control"
                                                id="test_normal_baby_ord">
                                                <option value="">- Select -</option>
                                                <option value="Negative">Negative</option>
                                                <option value="Positive">Positive</option>
                                                <option value="Reactive">Reactive</option>
                                                <option value="Non Reactive">Non Reactive</option>
                                                <option value="Intemediate">Intemediate</option>
                                                <option value="Indeterminate">Indeterminate</option>
                                                <option value="1+">1+</option>
                                                <option value="2+">2+</option>
                                                <option value="3+">3+</option>
                                                <option value="4+">4+</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- OTHER --}}
                            <div class="card-body" id="Other" style="display: none">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label>Rate Plan</label>
                                            <input type="text" value="General" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <label>Normal Value</label>
                                            <input type="text" name="test_normal_general_other"
                                                id="test_normal_general_other" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Male" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" name="test_normal_male_other" id="test_normal_male_other"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Female" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" name="test_normal_female_other"
                                                id="test_normal_female_other" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Child" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" name="test_normal_child_other"
                                                id="test_normal_child_other" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <input type="text" value="Baby" class="form-control border-0" disabled>
                                        </div>
                                        <div class="form-group col-md-9">
                                            <input type="text" name="test_normal_baby_other" id="test_normal_baby_other"
                                                class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- CATEGORY --}}
                            <div class="card-header" id="CategoryHeader">
                                <h4>Test Category</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Test Category</label>
                                    <div class="col-sm-4">
                                        <select name="test_category" value="{{ old('test_category') }}"
                                            class="form-control" id="test_category" required>
                                            <option value="">- Select Category -</option>
                                            <option value="Panel">Panel</option>
                                            <option value="Sub Panel">Sub Panel</option>
                                            <option value="Single">Single</option>
                                        </select>
                                    </div>
                                    <label class="col-sm-2 col-form-label" id="partoflabel">Part of</label>
                                    <div class="col-sm-4" id="partofform">
                                        <select name="test_partof" class="form-control selectric @error('test_partof')
                                            is-invalid @enderror">
                                            <option value="">- Select Panel -</option>
                                            @foreach ($panels as $panel)
                                            <option value="{{ $panel->test_code}}">{{ $panel->test_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Test Status</label>
                                    <div class="col-sm-4">
                                        <select name="test_active" value="{{ old('test_active') }}" class="form-control"
                                            id="test_active" required>
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
                                            <input type="text" class="form-control @error('test_price')
                                                    is-invalid
                                                @enderror" name="test_price" id="test_price"
                                                value="{{ old('test_price') }}" placeholder="15000"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*?)\..*/g, '$1')"
                                                required>
                                            @error('test_price')
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

{{-- MODAL LOINC LIST --}}
<div class="modal fade" id="modal-loinc">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">LOINC List</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body table-responsive">
                <table id="datatables" class="table-striped table-hover table" width="100%">
                    <thead>
                        <tr class="text-center">
                            <th>Code</th>
                            <th>Display</th>
                            <th>Component</th>
                            <th>Method</th>
                            <th>Scale</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- ISI TABLE BODY ADA PADA AJAX DIBAWAH --}}
                        {{-- BUTTON DIATUR PADA CONTROLLER --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- END MODAL LOINC --}}
    @endsection
    @push('scripts')
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/modules-datatables.js') }}"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            processing: true,
            serverSide: true,
            ajax: "/data-loinc/jsonvisit",
            columns: [{
                    data: 'loinc_code',
                    name: 'loinc_code',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'loinc_display',
                    name: 'loinc_display',
                    className: 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'loinc_component',
                    name: 'loinc_component',
                    className: 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'loinc_method',
                    name: 'loinc_method',
                    className: 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'loinc_scale',
                    name: 'loinc_scale',
                    className: 'text-left',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    className: 'text-center',
                    orderable: false,
                    searchable: false
                },
            ],
        })
    });
    </script>
    {{-- LOAD DATA DARI MODAL SELECTED --}}
    <script>
    $(document).ready(function() {
        $(document).on('click', '#select', function() {
            var test_loinc_code = $(this).data('code');
            var test_loinc_display = $(this).data('display');
            var test_loinc_component = $(this).data('component');
            var test_loinc_method = $(this).data('method');
            var test_loinc_unitofmeasure = $(this).data('unitofmeasure');
            var test_loinc_scale = $(this).data('scale');
            $('#test_loinc_code').val(test_loinc_code);
            $('#test_loinc_display').val(test_loinc_display);
            $('#test_loinc_component').val(test_loinc_component);
            $('#test_loinc_method').val(test_loinc_method);
            $('#test_loinc_unitofmeasure').val(test_loinc_unitofmeasure);
            $('#test_loinc_scale').val(test_loinc_scale);
            // HIDE MODAL SETELAH SELECT
            $('#modal-loinc').modal('hide');
        })
    });
    </script>

    <script>
    document.getElementById("test_name").addEventListener("keyup", function() {
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
    {{-- UNIT--}}
    <script>
    $(document).ready(function() {
        $('#test_unit').change(function() {
            console.log("change");
            var unit = document.getElementById('test_unit').value;
            if (unit == "") {
                document.getElementById('test_unit_general').value = "";
                document.getElementById('test_unit_male').value = "";
                document.getElementById('test_unit_female').value = "";
                document.getElementById('test_unit_child').value = "";
                document.getElementById('test_unit_baby').value = "";
            } else {
                document.getElementById('test_unit_general').value = unit;
                document.getElementById('test_unit_male').value = unit;
                document.getElementById('test_unit_female').value = unit;
                document.getElementById('test_unit_child').value = unit;
                document.getElementById('test_unit_baby').value = unit;
            }
        });
    });
    </script>
    {{-- SELECTED CATEGORY--}}
    <script>
    $(document).ready(function() {
        $('#test_category').change(function() {
            console.log("change");
            var category = document.getElementById('test_category').value;
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
    {{-- SELECTED SCALE--}}
    <script>
    $(document).ready(function() {
        $('#test_resulttype').change(function() {
            console.log("change");
            var scale = document.getElementById('test_resulttype').value;
            if (scale == "Qn") {
                document.getElementById('ReferenceHeader').style.display = 'block';
                document.getElementById('Qn').style.display = 'block';
                document.getElementById('Ord').style.display = 'none';
                document.getElementById('Other').style.display = 'none';
            } else if (scale == "Ord") {
                document.getElementById('ReferenceHeader').style.display = 'block';
                document.getElementById('Qn').style.display = 'none';
                document.getElementById('Ord').style.display = 'block';
                document.getElementById('Other').style.display = 'none';
            } else {
                document.getElementById('ReferenceHeader').style.display = 'block';
                document.getElementById('Qn').style.display = 'none';
                document.getElementById('Ord').style.display = 'none';
                document.getElementById('Other').style.display = 'block';
            }
        });
    });
    </script>
    {{-- GENERATE NORMAL GENERAL--}}
    <script>
    $(document).ready(function() {
        $('#test_max_general').change(function() {
            console.log("change");
            var test_min_general = document.getElementById('test_min_general').value;
            var test_max_general = document.getElementById('test_max_general').value;
            var to = " - ";
            if (test_max_general != "" && test_min_general != "") {
                document.getElementById('test_normal_general').value = test_min_general + to +
                    test_max_general;
            } else {
                document.getElementById('test_normal_general').value = "";
            }
        });
    });
    </script>
    {{-- GENERATE NORMAL MALE--}}
    <script>
    $(document).ready(function() {
        $('#test_max_male').change(function() {
            console.log("change");
            var test_min_male = document.getElementById('test_min_male').value;
            var test_max_male = document.getElementById('test_max_male').value;
            var to = " - ";
            if (test_max_male != "" && test_min_male != "") {
                document.getElementById('test_normal_male').value = test_min_male + to + test_max_male;
            } else {
                document.getElementById('test_normal_male').value = "";
            }
        });
    });
    </script>
    {{-- GENERATE NORMAL FEMALE--}}
    <script>
    $(document).ready(function() {
        $('#test_max_female').change(function() {
            console.log("change");
            var test_min_female = document.getElementById('test_min_female').value;
            var test_max_female = document.getElementById('test_max_female').value;
            var to = " - ";
            if (test_max_female != "" && test_min_female != "") {
                document.getElementById('test_normal_female').value = test_min_female + to +
                    test_max_female;
            } else {
                document.getElementById('test_normal_female').value = "";
            }
        });
    });
    </script>
    {{-- GENERATE NORMAL CHILD--}}
    <script>
    $(document).ready(function() {
        $('#test_max_child').change(function() {
            console.log("change");
            var test_min_child = document.getElementById('test_min_child').value;
            var test_max_child = document.getElementById('test_max_child').value;
            var to = " - ";
            if (test_max_child != "" && test_min_child != "") {
                document.getElementById('test_normal_child').value = test_min_child + to +
                    test_max_child;
            } else {
                document.getElementById('test_normal_child').value = "";
            }
        });
    });
    </script>
    {{-- GENERATE NORMAL BABY--}}
    <script>
    $(document).ready(function() {
        $('#test_max_baby').change(function() {
            console.log("change");
            var test_min_baby = document.getElementById('test_min_baby').value;
            var test_max_baby = document.getElementById('test_max_baby').value;
            var to = " - ";
            if (test_max_baby != "" && test_min_baby != "") {
                document.getElementById('test_normal_baby').value = test_min_baby + to + test_max_baby;
            } else {
                document.getElementById('test_normal_baby').value = "";
            }
        });
    });
    </script>
    @endpush
@extends('layouts.app')

@section('title', 'LOINC')

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
                <h1>LOINC Master</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Import</a></div>
                    <div class="breadcrumb-item">Loinc</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="section-title">Terminology LOINC</h2>
                                <p class="section-lead">
                                    LOINC is an international standard initiated by Regenstrief in 1994 to identify
                                    radiological examinations, documents, surveys, etc., making it easier to understand
                                    codes because it consists of a group of identifications, names and codes to identify
                                    condition measurements, observations and health documents.
                                </p>
                                <p class="section-lead">
                                    LOINC terminology consists of the LOINC code and the LOINC name/term. LOINC consists of
                                    more than 90,000 codes in numeric (number) format. The LOINC code structure consists of
                                    3 to 7 characters with the last digit called the check digit and is always located after
                                    the hyphen. Check digits are always numbers 0-9 which serve to help avoid errors in code
                                    transcription.
                                </p>
                                <p class="section-lead">
                                    For more information: <a href="https://loinc.org/">https://loinc.org/</a> or <a
                                        href="https://satusehat.kemkes.go.id/platform/docs/id/terminology/loinc/">SATUSEHAT
                                        Documentation</a>
                                </p>
                                <div class="form-group">
                                    <div class="text-right mt-2">
                                        <a class="btn btn-info"
                                            href="https://drive.google.com/u/0/uc?id=1NMpZ3NuzsrCtK2onOYXxlQ4OmUEi5KTi&export=download"><i
                                                class="fa fa-download" aria-hidden="true"></i> LOINC Laboratory Terminology
                                            V1.1</a>
                                        <a class="btn btn-success" href="{{ route('export.loinc') }}"><i
                                                class="fa fa-file-excel" aria-hidden="true"></i> Export Excel LOINC</a>
                                        <button class="btn btn-primary" id="show-import-loinc">
                                            <i class="fa fa-upload" aria-hidden="true"></i> Import Excel LOINC
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card" id="import-loinc" style="display: none;">
                            <div class="card-header">
                                <h2 class="section-title">Import LOINC Master</h2>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('import.loinc') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="custom-file col-12 col-md-12 col-lg-12">
                                        <input type="file" class="custom-file-input" name="file" id="file">
                                        <label class="custom-file-label" for="file">Choose file .xlsx</label>
                                    </div>
                                    <div class="text-right mt-2">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"
                                                aria-hidden="true"></i> Import LOINC</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h2 class="section-title">LOINC Answer List</h2>
                                <p class="section-lead">
                                    Across many domains, the meaning of a particular observation can be best understood in
                                    the context of the set oossible answers (result values). For example, the
                                    questions/items in standardized assessment instruments often have highly specialized,
                                    fixed answer lists. Additionally, because many of the answer choices are highly
                                    specialized, few are represented by existing codes in reference terminologies. For these
                                    reasons, we have created a structured Answer List representation in LOINC, where each
                                    Answer List contains a set of Answer strings and their unique Answer codes.
                                </p>
                                <p class="section-lead">
                                    For more information regarding Answer Lists, strings, and codes, and their relationships
                                    to LOINC terms, see Section 9.2 "LOINC Answers (LA) and Answer Lists (LL)" of the <a
                                        href="https://loinc.org/answer-file/">LOINC Users' Guide.</a>
                                </p>
                                <div class="form-group">
                                    <div class="text-right mt-2">
                                        <a class="btn btn-success" href="{{ route('export.answerloinc') }}"><i
                                                class="fa fa-file-excel" aria-hidden="true"></i> Export Answer List</a>
                                        <button class="btn btn-primary" id="show-import-answer">
                                            <i class="fa fa-upload" aria-hidden="true"></i> Import Answer List
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card" id="import-answer" style="display: none;">
                            <div class="card-header">
                                <h2 class="section-title">Import Answer List</h2>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('import.loincanswer') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="custom-file col-12 col-md-12 col-lg-12">
                                        <input type="file" class="custom-file-input" name="file" id="file">
                                        <label class="custom-file-label" for="file">Choose file .xlsx</label>
                                    </div>
                                    <div class="text-right mt-2">
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-upload"
                                                aria-hidden="true"></i> Import Answer List</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(document).ready(function () {
            $('#show-import-loinc').click(function () {
                $('#import-loinc').toggle();
            });

            $('#show-import-answer').click(function () {
                $('#import-answer').toggle();
            });
        });
    </script>
@endsection

@push('scripts')

@endpush
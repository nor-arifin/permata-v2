<div class="navbar-bg"></div>
<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i
                        class="fas fa-search"></i></a></li>
        </ul>
        <div class="search-element">
            <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
            <div class="search-result">
                <div class="search-header">
                    References
                </div>
                <div class="search-item">
                    <a href="{{ route('icd.list') }}" target="_blank">
                        <img class="mr-3 rounded" width="30" src="{{ asset('img/products/product-3-50.png') }}"
                            alt="product">
                        ICD-10 List
                    </a>
                </div>
                <div class="search-item">
                    <a href="{{ route('loinc.list') }}" target="_blank">
                        <img class="mr-3 rounded" width="30" src="{{ asset('img/products/product-2-50.png') }}"
                            alt="product">
                        LOINC List
                    </a>
                </div>
                <div class="search-header">
                    Library
                </div>
                <div class="search-item" id="ihsstatus">
                    <a href="#" data-id="a7a02bd3-0650-445c-ac9c-cb237e38fb0d">
                        <!-- <a href="#" data-id="100149133"> -->
                        <!-- Replace '123' with the actual ID you want to send -->
                        <div class="search-icon bg-primary mr-3 text-white">
                            <i class="fas fa-laptop"></i>
                        </div>
                        SATUSEHAT Status
                    </a>
                </div>
            </div>
        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#ihsstatus a').on('click', function (e) {
                e.preventDefault(); // Menghindari refresh halaman

                // Get the ID from the data attribute
                var id = $(this).data('id');

                $.ajax({
                    url: '{{ url("/getorganization") }}/' + id, // URL ke route getorganization dengan id
                    method: 'GET', // Menggunakan metode GET
                    success: function (response) {
                        console.log(response);
                        // Cek jika respon sukses
                        if (response && response.message) {
                            // Tampilkan SweetAlert2 dengan pesan sukses
                            Swal.fire({
                                title: 'Connected',
                                text: response.data[1].name,
                                icon: 'success', // Ikon sukses
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        // Jika ada error (misalnya gagal koneksi ke server)
                        Swal.fire({
                            title: 'Error',
                            text: xhr.responseJSON.message ||
                                'Terjadi kesalahan, coba lagi.',
                            icon: 'error', // Ikon error
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });
    </script>


    <ul class="navbar-nav navbar-right">
        @if (in_array(auth()->user()->stage, ['clinic', 'general']))
                <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                        class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
                    <div class="dropdown-menu dropdown-list dropdown-menu-right">
                        <div class="dropdown-header">Messages</div>
                        <div class="dropdown-list-content dropdown-list-message">
                            {{-- QUERY GET DATA VISIT IS NOT FINISHED --}}
                            @php
                                // $notifications = \App\Models\Visit::where('visit_status_timeline', '!=', 'Finished')->get();
                                //QUERY GET JOIN VISITS AND SERVICES_DETAIL
                                $notifications = \App\Models\Visit::join(
                                    'services_detail',
                                    'services_detail.service_visit_registration_id',
                                    '=',
                                    'visits.visit_registration_id'
                                )
                                    ->where('visit_status_timeline', '!=', 'Finished')
                                    ->where('service_loinc_code', '!=', null)
                                    ->groupBy('visit_registration_id')
                                    ->get();
                            @endphp
                        @foreach ($notifications as $notification)
                                            <a href="{{ route('lab.show', $notification->visit_registration_id) }}"
                                            class="dropdown-item dropdown-item-unread">
                                            <div class="dropdown-item-avatar">
                                                <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle">
                                                <div class="is-online"></div>
                                            </div>
                                            <div class="dropdown-item-desc">
                                                <b>{{$notification->visit_doctor_name}}</b>
                                                <p>I'm recently order laboratory test for {{$notification->visit_patient_name}}
                                                ({{$notification->visit_patient_mr}}) with ICD-10
                                                    {{$notification->visit_icd10_display}}.
                                                </p>
                                                        @php
                                                            $progress = new DateTime($notification->visit_date_progress);
                                                            $now = new DateTime(date('Y-m-d H:i:s'));
                                                            $intervalh = date_diff($progress, $now)->format('%h');
                                                            $intervalm = date_diff($progress, $now)->format('%i');
                                                            if ($intervalh <= 0) {
                                                                $hours = "";
                                                            } else {
                                                                $hour = sprintf("%02d", $intervalh);
                                                                $hours = " " .
                                                                    $hour . " Hours";
                                                            }
                                                            if ($intervalm <= 0) {
                                                                $minutes = "00M";
                                                            } else {
                                                                $minute = sprintf("%02d", $intervalm);
                                                                $minutes = " " . $minute . " Minutes";
                                                        } @endphp
                                                            <div class="time">
                                                        {{ $hours . $minutes }} Ago
                                        </div>
                                </div>
                                </a>
                        @endforeach
                    </div>
                    <div class="dropdown-footer text-center">
                        <a href="{{ route('lab.index') }}">View All <i class="fas fa-chevron-right"></i></a>
                    </div>
                    </div>
                </li>
        @endif
        <li class="dropdown"><a href="#" data-toggle="dropdown"
                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                @if(auth()->user()->photo == null)
                    <img alt="image" src="{{ asset('img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                @else
                    <img alt="image" src="{{ asset(auth()->user()->photo) }}"
                        class="img-fluid rounded-circle profile-widget-picture mr-1">
                @endif
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ auth()->user()->role }}</div>
                <a href="{{ url('profile/' . auth()->user()->id) }}" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> Profile
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item has-icon text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
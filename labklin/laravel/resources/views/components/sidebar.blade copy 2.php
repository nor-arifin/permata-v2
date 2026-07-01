<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            {{-- APPS LOGO --}}
            <a href="{{ url('home') }}">
                <img alt="image" src="{{ asset('storage/logo/1.jpg') }}" height="40px" width="100"
                    class="img-fluid profile-widget-picture"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('home') }}">LabKlin Systems</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $menu === 'dashboard' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-area-chart"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' general' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('home') }}">General Dashboard</a>
                    </li>
                    <li class='{{ $submenu === ' dashboardlab' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('dashboardlab') }}">Clinic Dashboard</a>
                    </li>
                    <li class='{{ $submenu === ' dashboardkesmas' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Kesmas Dashboard</a>
                    </li>
                </ul>
            </li>
            @if (in_array(auth()->user()->stage, ['general', 'clinic', 'finance']))
            <li class="menu-header">Clinic</li>
            @endif
            @if (in_array(auth()->user()->role, ['admin', 'staff']))
            <li class="nav-item dropdown {{ $menu === 'registration' ? 'active' : '' }}">
                <a href=" #" class="nav-link has-dropdown"><i class="fas fa-user-plus"></i><span>Registration</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' patients' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('patients.index') }}">Patient</a>
                    </li>
                    <li class=' {{ $submenu === ' consents' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('consents.index') }}">Informed Consent</a>
                    </li>
                </ul>
            </li>
            @endif
            @if (in_array(auth()->user()->role, ['admin', 'staff', 'finance']))
            <li class=" nav-item dropdown {{ $menu === 'visit' ? 'active' : '' }}"> <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-book-medical"></i><span>Administration
                        Clinic</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' outpatient' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('visits.index') }}">Patient Visit</a>
                    </li>
                    @if (auth()->user()->stage === 'finance')
                    <li class=' {{ $submenu === ' payment' ? 'active' : '' }}'> <a class="nav-link" href="#">Payment</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (in_array(auth()->user()->role, ['admin', 'laboratory', 'validator', 'verifier']))
            <li class="nav-item dropdown {{ $menu === 'laboratory' ? 'active' : '' }}">
                <a href=" #" class="nav-link has-dropdown"><i class="fas fa-vials"></i><span>Clinical
                        Laboratory</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' order' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('lab.index') }}">Laboratory Status</a>
                    </li>
                    <li class=' {{ $submenu === ' collection' ? 'active' : '' }}'> <a class=" nav-link"
                            href="{{ route('collection') }}">Specimen Collection</a>
                    </li>
                    <li class='{{ $submenu === ' receive' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('receive') }}">Specimen Receive</a>
                    </li>
                    <li class='{{ $submenu === ' result' ? 'active' : '' }}'> <a class=" nav-link"
                            href="{{ route('result') }}">Result Entry</a>
                    </li>
                    @if (in_array(auth()->user()->role, ['admin', 'validator']))
                    <li class='{{ $submenu === ' validation' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('validation') }}">Result Validation</a>
                    </li>
                    <li class=' {{ $submenu === ' report' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('lab.report') }}">Laboratory Report</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (in_array(auth()->user()->stage, ['general', 'kesmas', 'finance']))
            <li class=" menu-header">Kesmas</li>
            @endif
            @if (in_array(auth()->user()->role, ['admin', 'staff']))
            <li class="nav-item dropdown {{ $menu === 'registration-km' ? 'active' : '' }}">
                <a href=" #" class="nav-link has-dropdown"><i class="far fa-building"></i><span>Registration</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' customers' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('customers.index') }}">Customer</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $menu === 'administration-km' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-clipboard"></i><span>Administration
                        Kesmas</span></a>
                <ul class="dropdown-menu">
                    @if (in_array(auth()->user()->role, ['admin', 'staff']))
                    <li class=' {{ $submenu === ' order-km' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('kesmas.index')}}">Kesmas Order</a>
                    </li>
                    @endif
                    @if (auth()->user()->role === 'finance')
                    <li class='{{ $submenu === ' payment-km' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('payment.kesmas')}}">Payment</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            @if (in_array(auth()->user()->role, ['admin', 'laboratory', 'validator', 'verifier']))
            <li class=" nav-item dropdown {{ $menu === 'labkesmas' ? 'active' : '' }}"> <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-flask"></i><span>Kesmas
                        Laboratory</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' order' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('labkesmas') }}">Laboratory
                            Status</a>
                    </li>
                    <li class=' {{ $submenu === ' receive-km' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('labkesmas.receive') }}">Sample
                            Receive</a>
                    </li>
                    <li class='{{ $submenu === ' entry-km' ? 'active' : '' }}'> <a class=" nav-link"
                            href="{{ route('labkesmas.entry') }}">Result
                            Entry</a>
                    </li>
                    <li class='{{ $submenu === ' verify-km' ? 'active' : '' }}'> <a class=" nav-link"
                            href="{{ route('labkesmas.verify') }}">Result
                            Verify</a>
                    </li>
                    @if (auth()->user()->role === 'admin' || auth()->user()->role === 'validator')
                    <li class='{{ $submenu === ' validation-km' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('labkesmas.validity') }}">Result Validation</a>
                    </li>
                    <li class=' {{ $submenu === ' report-km' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('labkesmas.report') }}">Laboratory Report</a>
                    </li>
                    @endif
                </ul>
            </li>
            @endif
            {{-- ONLY ROLE ADMIN --}}
            @if (auth()->user()->role === 'admin')
            <li class=" menu-header">Data Management</li>
            <li class="nav-item dropdown {{ $menu === 'report' ? 'active' : '' }}">
                <a href=" #" class="nav-link has-dropdown"><i class="fas fa-chart-line"></i><span>Report</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' reportvisit' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('report.visit') }}">Visit Report</a>
                    </li>
                    <li class=' {{ $submenu === ' reportlaboratory' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('report.laboratory') }}">Laboratory Report</a>
                    </li>
                    <li class='{{ $submenu === ' reportrevenue' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('report.revenue') }}">Revenue Report</a>
                    </li>
                    <li class='{{ $submenu === ' reportpersonel' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('report.personel') }}">Personel Report</a>
                    </li>
                </ul>
            </li>
            <li class=" menu-header">Administator</li>
            <li class="nav-item dropdown {{ $menu === 'setting' ? 'active' : '' }}">
                <a href=" #" class="nav-link has-dropdown"><i class="fa-solid fa-gear"></i><span>Setting</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' users' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.index') }}">User</a>
                    </li>
                    <li class=' {{ $submenu === ' profile' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ url('profile/' . auth()->user()->id) }}">Profile</a>
                    </li>
                    <li class='{{ $submenu === ' profileclinic' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('profileclinic.edit', 1) }}">Profile Organization</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item dropdown {{ $menu === 'master' ? 'active' : '' }}"> <a href="#"
                    class="nav-link has-dropdown"><i class="fa-solid fa-sliders"></i><span>Master Data
                        Clinic</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' organizations' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('organizations.index') }}">Organization Master</a>
                    </li>
                    <li class=' {{ $submenu === ' locations' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('locations.index') }}">Location Master</a>
                    </li>
                    <li class='{{ $submenu === ' doctors' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('doctors.index') }}">Doctor Master</a>
                    </li>
                    <li class='{{ $submenu === ' patients' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('patients.serverside') }}">Patient Master</a>
                    </li>
                    <li class='{{ $submenu === ' doctorschedules' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('doctor-schedules.index') }}">Schedule Master</a>
                    </li>
                    <li class='{{ $submenu === ' loinc' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('loinc') }}">Loinc Master</a>
                    </li>
                    <li class='{{ $submenu === ' laboratory' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('laboratory.index') }}">Laboratory Master</a>
                    </li>
                </ul>
            </li>
            <li class=" nav-item dropdown {{ $menu === 'kesmas' ? 'active' : '' }}"> <a href="#"
                    class="nav-link has-dropdown"><i class="fa-solid fa-sliders"></i><span>Master
                        Data
                        Kesmas</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === ' parameter' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('parameter.index') }}">Parameters Master</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $menu === 'database' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-database"></i><span>Database
                        Management</span></a>
                <ul class="dropdown-menu">
                    <li class=' {{ $submenu === ' syncup' ? 'active' : '' }}'> <a class="nav-link"
                            href="{{ route('merge.data') }}">Syncronize to Cloud</a>
                    </li>
                    <li class='{{ $submenu === ' syncdown' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('merge.back') }}">Syncronize from Cloud</a>
                    </li>
                    <li class='{{ $submenu === ' backup' ? 'active' : '' }}'>
                        <a class=" nav-link" href="{{ route('backup.manager') }}">Backup Manager</a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>

        <div class=" hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i>
                Documentation
            </a>
        </div>
    </aside>
</div>
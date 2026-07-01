<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            {{-- APPS LOGO --}}
            <a href="{{ url('home') }}">
            <img alt="image" src="{{ asset('storage/logo/1.jpg') }}" height="50px" width="100" class="img-fluid profile-widget-picture"></a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{ url('home') }}">LabKlin Systems</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $menu === 'dashboard' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-area-chart"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === 'general' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('home') }}">General Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $menu === 'registration' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Registration</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === 'patients' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('patients.index') }}">Patient</a>
                    </li>
                    <li class='{{ $submenu === 'consents' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('consents.index') }}">Informed Consent</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $menu === 'visit' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Visit</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === 'outpatient' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('visits.index') }}">Outpatient Visit</a>
                    </li>
                    <li class='{{ $submenu === 'inpatient' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Inpatient Visit</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $menu === 'anamneses' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Anamneses</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === 'condition' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Condition</a>
                    </li>
                    <li class='{{ $submenu === 'allergy' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Allergy Intollerance</a>
                    </li>
                    <li class='{{ $submenu === 'medication' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Medication Statement</a>
                    </li>
                    <li class='{{ $submenu === 'observation' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Observation</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $menu === 'laboratory' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-book"></i><span>Laboratory</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === 'order' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('lab.index') }}">Laboratory Order</a>
                    </li>
                    <li class='{{ $submenu === 'collection' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('collection') }}">Specimen Collection</a>
                    </li>
                    <li class='{{ $submenu === 'receive' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('receive') }}">Specimen Receive</a>
                    </li>
                    <li class='{{ $submenu === 'specimen' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Result Entry</a>
                    </li>
                    <li class='{{ $submenu === 'specimen' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Result Validation</a>
                    </li>
                    <li class='{{ $submenu === 'specimen' ? 'active' : '' }}'>
                        <a class="nav-link" href="#">Laboratory Report</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Administator</li>
            <li class="nav-item dropdown {{ $menu === 'setting' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-gear"></i><span>Setting</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === 'users' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('users.index') }}">User</a>
                    </li>
                    <li class='{{ $submenu === 'profile' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ url('profile/'.auth()->user()->id) }}">Profile</a>
                    </li>
                    <li class='{{ $submenu === 'profileclinic' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('profileclinic.edit', 1) }}">Profile Organization</a>
                    </li>
                </ul>
            </li>
            <li class="nav-item dropdown {{ $menu === 'master' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fa-solid fa-sliders"></i><span>Master Data</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ $submenu === 'organizations' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('organizations.index') }}">Organization Master</a>
                    </li>
                    <li class='{{ $submenu === 'locations' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('locations.index') }}">Location Master</a>
                    </li>
                    <li class='{{ $submenu === 'doctors' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('doctors.index') }}">Doctor Master</a>
                    </li>
                    <li class='{{ $submenu === 'patients' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('patients.serverside') }}">Patient Master</a>
                    </li>
                    <li class='{{ $submenu === 'doctorschedules' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('doctor-schedules.index') }}">Schedule Master</a>
                    </li>
                    <li class='{{ $submenu === 'loinc' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('loinc') }}">Loinc Master</a>
                    </li>
                    <li class='{{ $submenu === 'laboratory' ? 'active' : '' }}'>
                        <a class="nav-link" href="{{ route('laboratory.index') }}">Laboratory Master</a>
                    </li>
                </ul>
            </li>
        </ul>

        <div class="hide-sidebar-mini mt-4 mb-4 p-3">
            <a href="https://getstisla.com/docs" class="btn btn-primary btn-lg btn-block btn-icon-split">
                <i class="fas fa-rocket"></i> Documentation
            </a>
        </div>
    </aside>
</div>

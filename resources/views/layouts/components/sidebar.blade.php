<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-hospital"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Medic - Web</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Request::routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Tables -->
    {{-- Pasien: semua role bisa akses --}}
    <li class="nav-item {{ Request::routeIs('patient.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('patient.index') }}">
            <i class="fa-solid fa-hospital-user"></i>
            <span>Pasien</span></a>
    </li>

    {{-- Tanda Vital: dokter dan superadmin --}}
    @hasanyrole('dokter|superadmin|admin')
    <li class="nav-item {{ Request::routeIs('type-vital.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('type-vital.index') }}">
            <i class="fa-solid fa-heart-pulse"></i>
            <span>Tanda Vital</span></a>
    </li>
    @endhasanyrole

    {{-- Pemeriksaan: dokter dan superadmin --}}
    @hasanyrole('dokter|superadmin')
    <li class="nav-item {{ Request::routeIs('checkup.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('checkup.index') }}">
            <i class="fa-solid fa-stethoscope"></i>
            <span>Pemeriksaan</span></a>
    </li>
    @endhasanyrole

    {{-- Resep: apoteker dan superadmin --}}
    @hasanyrole('apoteker|superadmin')
    <li class="nav-item {{ Request::routeIs('prescription.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('prescription.index') }}">
            <i class="fa-solid fa-receipt"></i>
            <span>Resep</span></a>
    </li>
    @endhasanyrole

    {{-- Obat: apoteker dan superadmin --}}
    @hasanyrole('apoteker|superadmin|admin|dokter')
    <li class="nav-item {{ Request::routeIs('medicine.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('medicine.index') }}">
            <i class="fa-solid fa-pills"></i>
            <span>Medicine</span></a>
    </li>
    @endhasanyrole

    {{-- User: hanya superadmin --}}
    @role('superadmin')
    <li class="nav-item {{ Request::routeIs('user.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fa fa-user"></i>
            <span>User</span></a>
    </li>
    @endrole

    {{-- Log: hanya superadmin --}}
    @role('superadmin')
    <li class="nav-item {{ Request::routeIs('log-activity.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('log-activity.index') }}">
            <i class="fa fa-history"></i>
            <span>Log</span></a>
    </li>
    @endrole




    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>

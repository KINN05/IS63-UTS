<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-school"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SIMSIS</div>
    </a>

    <hr class="sidebar-divider my-0">

    {{-- Menu: Dashboard --}}
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Data Master</div>

    {{-- Menu: Kelas --}}
    <li class="nav-item {{ request()->routeIs('kelas.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('kelas.index') }}">
            <i class="fas fa-fw fa-chalkboard"></i>
            <span>Kelas</span>
        </a>
    </li>

    {{-- Menu: Siswa --}}
    <li class="nav-item {{ request()->routeIs('siswa.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('siswa.index') }}">
            <i class="fas fa-fw fa-user-graduate"></i>
            <span>Siswa</span>
        </a>
    </li>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">Akademik</div>

    {{-- Menu: Nilai --}}
    <li class="nav-item {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('nilai.index') }}">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Nilai Siswa</span>
        </a>
    </li>

    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
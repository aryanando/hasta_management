<!-- Sidebar -->
{{-- @dd(Session('user_data')) --}}

@php
    $userData = Session('user_data');
@endphp
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Admin
            <sup>{{ isset($data['small_tittle']) ? $data['small_tittle'] : '' }}</sup>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $data['active_page'] == 'dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/karu') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    @if (isUnit(20, $userData) || isAdmin())
        <!-- Heading -->
        <div class="sidebar-heading">
            Pasien
        </div>

        <li class="nav-item {{ $data['active_page'] == 'manage-pasien' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#pasienManagement"
                aria-expanded="true" aria-controls="pasienManagement">
                <i class="fas fa-fw fa-calendar-days"></i>
                <span>Manage Pasien</span>
            </a>
            <div id="pasienManagement" class="collapse {{ $data['active_page'] == 'manage-pasien' ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Data Pasien</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'cari-pasien' ? 'active' : '' }}"
                        href="{{ url('/pasien/cari') }}"><i
                            class="fa-regular fa-calendar-check mr-2"></i><span>Cari</span></a>
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

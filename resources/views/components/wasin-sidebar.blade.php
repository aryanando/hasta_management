<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
        </div>
        <div class="sidebar-brand-text mx-3">Admin <sup>Wasin</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{$data['active_page'] == 'dashboard' ? 'active' : ''}}">
        <a class="nav-link" href="{{url('/wasin')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Absensi
    </div>

    <li class="nav-item {{$data['active_page'] == 'laporan' ? 'active' : ''}}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-calendar-days"></i>
            <span>Laporan</span>
        </a>
        <div id="collapseTwo" class="collapse {{$data['active_page'] == 'laporan' ? 'show' : ''}}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Cuti / Izin</h6>
                <a class="collapse-item {{$data['active_page_child'] == 'cuti' ? 'active' : ''}}" href="{{url('/wasin/cuti')}}"><i class="fa-regular fa-calendar-check mr-2"></i><span>Cuti</span></a>
                <a class="collapse-item {{$data['active_page_child'] == 'izin' ? 'active' : ''}}" href="{{url('/wasin/izin')}}"><i class="fa-solid fa-users mr-2"></i><span>Izin</span></a>
                <h6 class="collapse-header">Data Absensi</h6>
                <a class="collapse-item {{$data['active_page_child'] == 'harian' ? 'active' : ''}}" href="{{url('/wasin/harian')}}"><i class="fa-regular fa-clock mr-2"></i><span>Absensi Harian</span></a>
                <a class="collapse-item {{$data['active_page_child'] == 'absensi' ? 'active' : ''}}" href="{{url('/wasin/laporan')}}"><i class="fa-regular fa-calendar-days mr-2"></i><span>Laporan Absensi</span></a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

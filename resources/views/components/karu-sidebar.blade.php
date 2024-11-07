<!-- Sidebar -->
{{-- @dd(Session('user_data')) --}}
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

    @if (Session('user_data')->karu || Session('user_data')->id == 1)
        <!-- Heading -->
        <div class="sidebar-heading">
            Absensi
        </div>

        <li class="nav-item {{ $data['active_page'] == 'absensi' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-calendar-days"></i>
                <span>Absensi</span>
            </a>
            <div id="collapseTwo" class="collapse {{ $data['active_page'] == 'absensi' ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Monitoring Absensi</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'today' ? 'active' : '' }}"
                        href="{{ url('/karu/absensi-hari-ini') }}"><i
                            class="fa-regular fa-calendar-check mr-2"></i><span>Hari Ini</span></a>
                    <a class="collapse-item {{ $data['active_page_child'] == 'log_karyawan' ? 'active' : '' }}"
                        href="{{ url('/karu/log-karyawan') }}"><i class="fa-solid fa-users mr-2"></i><span>Log
                            Karyawan</span></a>
                    <h6 class="collapse-header">Management Absensi</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'shift' ? 'active' : '' }}"
                        href="{{ url('/karu/shift') }}"><i class="fa-regular fa-clock mr-2"></i><span>Shift</span></a>
                    <a class="collapse-item {{ $data['active_page_child'] == 'jadwal' ? 'active' : '' }}"
                        href="{{ url('/karu/jadwal/' . date('m')) }}"><i
                            class="fa-regular fa-calendar-days mr-2"></i><span>Jadwal</span></a>
                </div>
            </div>
        </li>
        @if (Session('user_data')->id !== 1)
            <!-- Heading -->
            <div class="sidebar-heading">
                E-Survey
            </div>

            <li class="nav-item {{ $data['active_page'] == 'esurvey' ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                    aria-expanded="true" aria-controls="collapseThree">
                    <i class="fas fa-fw fa-calendar-days"></i>
                    <span>E-Survey</span>
                </a>
                <div id="collapseThree" class="collapse {{ $data['active_page'] == 'esurvey' ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Monitoring E-Survey</h6>
                        <a class="collapse-item {{ $data['active_page_child'] == 'esurvey' ? 'active' : '' }}"
                            href="{{ url('/karu/esurvey-bulan-ini') }}"><i
                                class="fa-regular fa-calendar-check mr-2"></i><span>Data Bulan Ini</span></a>
                    </div>
                </div>
            </li>
        @endif
    @endif

    @if (Session('user_data')->id == '200' || Session('user_data')->id == '1')
        <!-- Heading -->
        <div class="sidebar-heading">
            E-Survey
        </div>

        <li class="nav-item {{ $data['active_page'] == 'esurvey' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree"
                aria-expanded="true" aria-controls="collapseThree">
                <i class="fas fa-fw fa-calendar-days"></i>
                <span>E-Survey</span>
            </a>
            <div id="collapseThree" class="collapse {{ $data['active_page'] == 'esurvey' ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Monitoring E-Survey</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'esurvey' ? 'active' : '' }}"
                        href="{{ url('/karu/esurvey-bulan-ini') }}"><i
                            class="fa-regular fa-calendar-check mr-2"></i><span>Unit</span></a>
                    <a class="collapse-item {{ $data['active_page_child'] == 'jenis-karyawan' ? 'active' : '' }}"
                        href="{{ url('/karu/esurvey-jenis-karyawan') }}"><i
                            class="fa-regular fa-calendar-check mr-2"></i><span>Jenis Karyawan</span></a>
                </div>
            </div>
        </li>
    @endif
    @if (Session('user_data')->id == '200' || Session('user_data')->id == '1')
        <!-- Heading -->
        <div class="sidebar-heading">
            Kauangan
        </div>

        <li class="nav-item {{ $data['active_page'] == 'keuangan' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKeuangan"
                aria-expanded="true" aria-controls="collapseKeuangan">
                <i class="fas fa-fw fa-calendar-days"></i>
                <span>Manage Keuangan</span>
            </a>
            <div id="collapseKeuangan" class="collapse {{ $data['active_page'] == 'keuangan' ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Gaji</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'keuangan' ? 'active' : '' }}"
                        href="{{ url('/keuangan') }}"><i class="fa-regular fa-calendar-check mr-2"></i><span>Data
                            Gaji</span></a>
                </div>
            </div>
        </li>
    @endif

    @if (Session('user_data')->id == '1')
        <!-- Heading -->
        <div class="sidebar-heading">
            Manage User
        </div>

        <li class="nav-item {{ $data['active_page'] == 'admin' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAdmin"
                aria-expanded="true" aria-controls="collapseAdmin">
                <i class="fas fa-fw fa-calendar-days"></i>
                <span>Manage User</span>
            </a>
            <div id="collapseAdmin" class="collapse {{ $data['active_page'] == 'admin' ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Manage Data</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'admin' ? 'active' : '' }}"
                        href="{{ url('/admin/users') }}"><i
                            class="fa-regular fa-calendar-check mr-2"></i><span>Users</span></a>
                </div>
            </div>
        </li>
    @endif


    @if (Session('user_data')->name == 'Administrator')
        <!-- Heading -->
        <div class="sidebar-heading">
            Unit
        </div>

        <li class="nav-item {{ $data['active_page'] == 'manage-karyawan' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#unitManagement"
                aria-expanded="true" aria-controls="unitManagement">
                <i class="fas fa-fw fa-calendar-days"></i>
                <span>Manage Unit</span>
            </a>
            <div id="unitManagement"
                class="collapse {{ $data['active_page'] == 'manage-karyawan' ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Unit</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'unit' ? 'active' : '' }}"
                        href="{{ url('/admin/unit') }}"><i class="fa-regular fa-calendar-check mr-2"></i><span>Lihat
                            Unit</span></a>
                    {{-- <a class="collapse-item {{ $data['active_page_child'] == 'log_karyawan' ? 'active' : '' }}"
                        href="{{ url('/karu/log-karyawan') }}"><i class="fa-solid fa-users mr-2"></i><span>Log
                            Karyawan</span></a> --}}
                </div>
            </div>
        </li>
    @endif


    @if (count(Session('user_data')->unit) > 0 || Session('user_data')->id == '1')
        @if (Session('user_data')->id == '1')
            <!-- Heading -->
            <div class="sidebar-heading">
                Klaim Rujukan
            </div>

            <li class="nav-item {{ $data['active_page'] == 'manage-karyawan' ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#karyawanManagement" aria-expanded="true" aria-controls="karyawanManagement">
                    <i class="fas fa-fw fa-calendar-days"></i>
                    <span>Manage Klaim Rujukan</span>
                </a>
                <div id="karyawanManagement"
                    class="collapse {{ $data['active_page'] == 'klaim-rujukan' ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Rujukan</h6>
                        <a class="collapse-item {{ $data['active_page_child'] == 'klaim-rujukan' ? 'active' : '' }}"
                            href="{{ url('/klaim-rujukan') }}"><i
                                class="fa-regular fa-calendar-check mr-2"></i><span>Rujukan</span></a>
                        <a class="collapse-item {{ $data['active_page_child'] == 'data-klaim-rujukan' ? 'active' : '' }}"
                            href="{{ url('/detail-klaim-rujukan') }}"><i
                                class="fa-regular fa-calendar-check mr-2"></i><span>Detail Data Rujukan</span></a>
                        {{-- <a class="collapse-item {{ $data['active_page_child'] == 'log_karyawan' ? 'active' : '' }}"
                    href="{{ url('/karu/log-karyawan') }}"><i class="fa-solid fa-users mr-2"></i><span>Log
                        Karyawan</span></a> --}}
                    </div>
                </div>
            </li>
        @elseif (Session('user_data')->unit[0]->unit_name == 'RM' ||
                Session('user_data')->unit[0]->unit_name == 'KASIR' ||
                Session('user_data')->name == 'GANDI ARI SETIOKO,Amd.Kep ')
            <!-- Heading -->
            <div class="sidebar-heading">
                Klaim Rujukan
            </div>

            <li class="nav-item {{ $data['active_page'] == 'manage-karyawan' ? 'active' : '' }}">
                <a class="nav-link collapsed" href="#" data-toggle="collapse"
                    data-target="#karyawanManagement" aria-expanded="true" aria-controls="karyawanManagement">
                    <i class="fas fa-fw fa-calendar-days"></i>
                    <span>Manage Klaim Rujukan</span>
                </a>
                <div id="karyawanManagement"
                    class="collapse {{ $data['active_page'] == 'klaim-rujukan' ? 'show' : '' }}"
                    aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Data Rujukan</h6>
                        <a class="collapse-item {{ $data['active_page_child'] == 'klaim-rujukan' ? 'active' : '' }}"
                            href="{{ url('/klaim-rujukan') }}"><i
                                class="fa-regular fa-calendar-check mr-2"></i><span>Rujukan</span></a>
                        <a class="collapse-item {{ $data['active_page_child'] == 'data-klaim-rujukan' ? 'active' : '' }}"
                            href="{{ url('/detail-klaim-rujukan') }}"><i
                                class="fa-regular fa-calendar-check mr-2"></i><span>Detail Data Rujukan</span></a>
                        {{-- <a class="collapse-item {{ $data['active_page_child'] == 'log_karyawan' ? 'active' : '' }}"
                        href="{{ url('/karu/log-karyawan') }}"><i class="fa-solid fa-users mr-2"></i><span>Log
                            Karyawan</span></a> --}}
                    </div>
                </div>
            </li>
        @endif
    @endif
    @if (Session('user_data')->name == 'Administrator')
        <!-- Heading -->
        <div class="sidebar-heading">
            Laporan
        </div>

        <li class="nav-item {{ $data['active_page'] == 'laporan' ? 'active' : '' }}">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageLaporan"
                aria-expanded="true" aria-controls="manageLaporan">
                <i class="fas fa-fw fa-calendar-days"></i>
                <span>Manage Laporan</span>
            </a>
            <div id="manageLaporan"
                class="collapse {{ $data['active_page'] == 'laporan' ? 'show' : '' }}"
                aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Rawat Jalan</h6>
                    <a class="collapse-item {{ $data['active_page_child'] == 'laporanRawatJalan' ? 'active' : '' }}"
                        href="{{ url('/laporan/rajal') }}"><i class="fa-regular fa-calendar-check mr-2"></i><span>Laporan Rawat Jalan</span></a>
                    {{-- <a class="collapse-item {{ $data['active_page_child'] == 'log_karyawan' ? 'active' : '' }}"
                        href="{{ url('/karu/log-karyawan') }}"><i class="fa-solid fa-users mr-2"></i><span>Log
                            Karyawan</span></a> --}}
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

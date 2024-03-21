<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>{{ $page_info['title'] }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">

    <style>
        .form-control::placeholder {
            color: #DDDDDD;
        }
    </style>

</head>

<body>
    @if (Session::has('message'))
        <div style="position: absolute; top: 5rem; right: 1rem;">
            @if (Session::get('message') == 'Data Created!!!')
                <div class="alert alert-success" id="myToast"><small>{{ Session::get('message') }}</small></div>
            @else
                <div class="alert alert-danger" id="myToast"><small>{{ Session::get('message') }}</small></div>
            @endif
        </div>
        <script>
            var delayInMilliseconds = 5000; //1 second

            setTimeout(function() {
                var element = document.getElementById("myToast");
                element.classList.add("d-none");
            }, delayInMilliseconds);
        </script>
    @endif
    <main>
        <!-- .. Main HTML -->
        <div id="wrapper">

            <x-karu-sidebar :data="$page_info" />

            <!-- Content Wrapper -->
            <div id="content-wrapper" class="d-flex flex-column">

                <!-- Main Content -->
                <div id="content">

                    <x-karu-topbar :data="$user_data" />

                    <div class="container-fluid">

                        @yield('content')

                    </div>
                    <!-- /.container-fluid -->

                </div>
                <!-- End of Main Content -->

                <x-footer />

            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->

        <!-- Scroll to Top Button-->
        <a class="scroll-to-top rounded" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Yakin Untuk Keluar?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Pilih "Keluar" dibawah jika anda yakin untuk mengakhiri sesi ini.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <a class="btn btn-primary" href="{{ url('/logout') }}">Keluar</a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Custom Modal Place --}}
        @stack('custom-modal')
    </main>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js">
    </script>
    <script>

        $.ajax({
            url: "{{ url('') }}/admin/api/karyawan/noUnit",
            success: function(result) {
                $("#tags").autocomplete({
                    source: result
                });
                console.log(result);
            }
        });
    </script>
    @stack('custom-script')

</body>

</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Antrian Poli</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="http://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome/css/all.min.css') }}">
    <link rel="icon" href="/favicon-32x32.png" type="image/x-icon">
    @if (App::environment('production'))
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    @endif
    <script src="https://code.responsivevoice.org/responsivevoice.js?key=WvG2Huaq"></script>

</head>

<body>
    <main>
        <div id="wrapper" class="vh-100">
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content" style="background-color: #8a8a8a">
                    <div class="container-fluid">
                        {{-- Content Here --}}
                        <div class="row my-2 py-2 bg-success">
                            <div class="col-7">
                                <div style="color: #ff0000; font-size: 56px;" class="font-weight-bold ">
                                    Antrian Poli - RS BHAYANGKARA BATU
                                </div>
                            </div>
                            <div class="col-5 p-2">
                                <div style="background-color: #00014d">
                                    <button onclick="speakDong('Tn. Dandung Satrio Wulang Jiwo')">Speak</button>
                                    <div class="text-center" id="realTimeClock" style="font-size:56px; color:#d0ff61">
                                        Wait ...
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <div class="card">
                                    <div class="card-header">
                                        POLI OBGYN
                                    </div>
                                    <div class="card-body">
                                        <span class="font-weight-bold text-center" style="font-size: 40px">DR. ARIFIAN
                                            JUARI</span>
                                    </div>
                                    <div class="card-footer">
                                        Status Ada
                                    </div>
                                </div>
                                <div class="card mt-2">
                                    <div class="card-header font-weight-bold">
                                        ANTRIAN ATAS NAMA :
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center"
                                        style="height: 400px">
                                        <span class="font-weight-bold text-center" style="font-size: 80px"
                                            id="namaRead">Tn. Dandung
                                            Satrio Wulang Jiwo</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7 border p-1 d-flex align-items-center justify-content-center">
                                <div class="ratio ratio-16x9">
                                    <iframe
                                        src="https://www.youtube.com/embed/AdAANcYQKG8?si=cU5FF-TtXeWnREWl&autoplay=1&mute=1"
                                        title="YouTube video"></iframe>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-3">
                                <div class="card">
                                    <div class="card-header py-1">
                                        JUMLAH ANTRIAN
                                    </div>
                                    <div class="card-body">
                                        <span class="font-weight-bold text-center" style="font-size: 40px">30</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card">
                                    <div class="card-header py-1">
                                        LIHAT ANTRIAN LENGKAP :
                                    </div>
                                    <div class="card-body py-1">
                                        <img src="https://pngimg.com/uploads/qr_code/qr_code_PNG10.png"
                                            class="img-fluid" alt="" srcset="">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="{{ asset('assets/js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js">
    </script>

    <script>
        var timeDisplay = document.getElementById("realTimeClock");


        function refreshTime() {
            var dateString = new Date().toLocaleString("id-ID", {
                timeZone: "Asia/Jakarta"
            });
            var formattedString = dateString.replace(", ", " - ");
            timeDisplay.innerHTML = formattedString;
        }

        setInterval(refreshTime, 1000);



        // setInterval(speakDong, 2000);
        function speakDong(namaPasien) {
            if (namaPasien.indexOf("Tn.") !== -1) {
                namaPasien = namaPasien.replace( 'Tn.', 'tuan');
                console.log("Blaaaa blaa");
            }

            responsiveVoice.speak(
                `Antrian atas nama ${namaPasien}`,
                "Indonesian Female", {
                    pitch: 1,
                    rate: 0.9,
                    volume: 1
                }
            );
        }
    </script>

</body>

</html>

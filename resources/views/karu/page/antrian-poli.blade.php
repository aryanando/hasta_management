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
    <script src="https://benalman.com/code/projects/jquery-throttle-debounce/jquery.ba-throttle-debounce.js"></script>
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
        {{-- @dd($dataPoli) --}}
        <div id="wrapper" class="vh-100">
            <div id="content-wrapper" class="d-flex flex-column">
                <div id="content"
                    style="background-image: url('{{ url('assets/img/bg.png') }}'); background-repeat: no-repeat;
  background-attachment: fixed;
  background-size: cover;">
                    <div class="container-fluid">
                        {{-- Content Here --}}
                        <div class="row my-2 mx-1 py-2 rounded-3" style="background-color:rgba(77, 255, 246, 0.5);">
                            <div class="col-7">
                                <div style="color: #ff0000; font-size: 56px;" class="font-weight-bold ">
                                    {{ $dataPoli->nm_poli }}
                                </div>
                            </div>
                            <div class="col-5 p-2 rounded-3">
                                <div style="background-color:rgba(0, 56, 53, 0.911);" class="rounded-3">
                                    {{-- <button onclick="getDataAntrian()">Speak</button> --}}
                                    <div class="text-center" id="realTimeClock"
                                        style="font-size:56px; color:#d0ff61; opacity:1">
                                        Wait ...
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <div class="card" style="opacity: 0.9;">

                                    <div class="card-body d-flex align-items-center justify-content-center"
                                        style="height: 160px">
                                        <span class="font-weight-bold text-center"
                                            style="font-size: 40px">{{ $dataDokter->nm_dokter }}</span>
                                    </div>
                                    {{-- <div class="card-footer">
                                        Status Ada
                                    </div> --}}
                                </div>
                                <div class="card mt-2" style="opacity: 0.9;">
                                    <div class="card-header font-weight-bold">
                                        ANTRIAN ATAS NAMA :
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center"
                                        style="height: 400px">
                                        <span class="font-weight-bold text-center" style="font-size: 80px"
                                            id="namaRead"> - </span>
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
                                <div class="card" style="height: 300px; opacity: 0.9;">
                                    <div class="card-header py-1">
                                        JUMLAH ANTRIAN
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-center"
                                            style="height: 100%">
                                            <span class="font-weight-bold text-center" style="font-size: 90px" id="jumlahAntrian">0</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="card" style="height: 300px; opacity: 0.9;">
                                    <div class="card-header py-1">
                                        LIHAT ANTRIAN LENGKAP :
                                    </div>
                                    <div class="card-body py-1">
                                        <div class="d-flex align-items-center justify-content-center">
                                            <img src="{{ url('assets/img/TL9H2g_qrcode.png') }}"
                                                alt="" srcset="" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-7" style="opacity: 0.9;">
                                <div class="card">
                                    <div class="card-body" id="listAntrian">
                                        <div class="row" style="font-size: 50px">
                                            <div class="col-2">-</div>
                                            <div class="col-10">MOHON TUNGGU </div>
                                        </div>
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

    <script type="module">
        function getDataAntrian() {
            console.log('getting data ..');

            axios.get("{{ env('API_URL') }}" + '/api/v1/antrian/poli?kd_dokter=' + encodeURIComponent('{{ $kode_dokter }}') +
                    '&kd_poli=' + encodeURIComponent('{{ $kode_poli }}'), {
                        'headers': {
                            'Authorization': "Bearer {{ session('token') }}"
                        }
                    })
                .then(response => {
                    if (response.data.data.panggil != null) {
                        document.getElementById('namaRead').innerHTML = response.data.data.panggil.data_reg_priksa
                            .pasien
                            .nm_pasien;
                    }
                    console.log(response.data.data.panggil);

                    var i = 0;
                    var dataAntrian = response.data.data.antrian;
                    var dataJumlahAntrian = response.data.data.jumlahAntrianLengkap;
                    document.getElementById('listAntrian').innerHTML = ``
                    dataAntrian.forEach(element => {
                        document.getElementById('listAntrian').innerHTML += `
                                    <div class="row" style="font-size: 50px">
                                        <div class="col-2">${element['no_reg']}</div>
                                        <div class="col-10">${element['pasien']['nm_pasien']}</div>
                                    </div>
                                `
                    });
                    if (dataAntrian != undefined){
                        document.getElementById('jumlahAntrian').innerHTML = dataJumlahAntrian;
                    }else{
                        document.getElementById('jumlahAntrian').innerHTML = 0;
                    }

                    if (response.data.data.panggil.status == 1) {
                        speakDong(capitalizeFirstLetter(response.data.data.panggil.data_reg_priksa.pasien.nm_pasien));
                    }
                })
                .catch(error => {
                    // Handle errors
                });
        }

        function capitalizeFirstLetter(val) {
            val = val.toLowerCase();
            const words = val.split(" ");

            for (let i = 0; i < words.length; i++) {
                words[i] = words[i][0].toUpperCase() + words[i].substr(1);
            }

            words.join(" ");
            var name = '';
            words.forEach(element => {
                name = name + element;
            });
            return name;
        }

        function speakDong(namaPasien) {
            console.log(namaPasien);

            if (namaPasien.indexOf("Tn.") !== -1) {
                namaPasien = namaPasien.replace('Tn.', 'tuan');
            } else if (namaPasien.indexOf("Tn,") !== -1) {
                namaPasien = namaPasien.replace('Tn,', 'tuan');
            } else if (namaPasien.indexOf("Ny.") !== -1) {
                namaPasien = namaPasien.replace('Ny.', 'nyonya');
            } else if (namaPasien.indexOf("Ny,") !== -1) {
                namaPasien = namaPasien.replace('Ny,', 'nyonya');
            } else if (namaPasien.indexOf("An.") !== -1) {
                namaPasien = namaPasien.replace('An.', 'anak');
            } else if (namaPasien.indexOf("An,") !== -1) {
                namaPasien = namaPasien.replace('An,', 'anak');
            }

            responsiveVoice.speak(
                `Antrian atas nama ${namaPasien}, Antrian atas nama ${namaPasien}`,
                "Indonesian Female", {
                    pitch: 1,
                    rate: 0.7,
                    volume: 1
                }
            );
        }

        window.getDataAntrian = getDataAntrian;

        setInterval(getDataAntrian, 3000);
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
    </script>



</body>

</html>

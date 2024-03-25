@extends('layout.token_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Absensi</h1>
    <div id="MyClockDisplay" class="clock text-center" onload="showTime()"></div>
    <div class="row">
        <div class="col-4">
            <div class="d-flex align-items-center justify-content-center">
                {{-- {!! QrCode::size(256)->generate($data->token) !!} --}}
                <canvas id="canvas" class="w-100 h-100"></canvas>
            </div>
        </div>
        <div class="col-8">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <th>Nama</th>
                    <th>Masuk</th>
                    <th>Pulang</th>
                    <th>Jam Masuk</th>
                    <th>Jam Pulang</th>
                </thead>
            </table>
        </div>
    </div>





@stop

@push('custom-script')
    <script type="module">
        function showTime() {
            var date = new Date();
            var h = date.getHours(); // 0 - 23
            var m = date.getMinutes(); // 0 - 59
            var s = date.getSeconds(); // 0 - 59
            var session = "AM";

            if (h == 0) {
                h = 12;
            }

            if (h > 12) {
                h = h - 12;
                session = "PM";
            }

            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            var time = h + ":" + m + ":" + s + " " + session;
            document.getElementById("MyClockDisplay").innerText = time;
            document.getElementById("MyClockDisplay").textContent = time;

            setTimeout(showTime, 1000);

        }
        showTime();

        var DataTabless = new DataTables('#example', {
            ajax: `{{ url('') }}/get-absensi`,
            columns: [{
                    data: 'user_name'
                },
                {
                    data: 'absen_check_in'
                },
                {
                    data: 'absen_check_out'
                },
                {
                    data: 'shift_check_in'
                },
                {
                    data: 'shift_check_out'
                },
            ]
        });
        var token = ""
        window.$(document).ready(function() {
            setInterval(function() {

                axios({
                    method: "get",
                    url: `{{ url('') }}/get-newtoken`,
                }).then((response) => {
                    console.log(response.data.data['token']);
                    if (token != response.data.data['token']) {
                        DataTabless.ajax.reload();
                        token = response.data.data['token'];
                        console.log(response.data.data['token']);
                        generateToken(response.data.data['token'])
                    }
                });
            }, 2000);
        });


        function generateToken(token) {
            QRCode.toCanvas(document.getElementById('canvas'), token, {
                // width: 560,
            }, function(error) {
                if (error) console.error(error)
                console.log('success!');
            })
        }
    </script>
@endpush

@push('custom-style')
    <link href='https://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet'>
    <style>
        .clock {
            color: black;
            font-size: 60px;
            font-family: Orbitron;
            letter-spacing: 7px;
        }
    </style>
@endpush

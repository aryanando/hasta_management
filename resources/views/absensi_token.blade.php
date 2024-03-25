@extends('layout.token_layout')

@section('content')

    <!-- Page Heading -->
    <div class="row">
        <div class="col-4">
            <h1 class="h1 mb-4 text-gray-800 text-center">Scan Me</h1>
            <div id="MyClockDisplay" class="clock text-center" onload="showTime()"></div>
            <div class="row">
                <canvas id="canvas" class="w-100 h-100"></canvas>
            </div>
        </div>
        <div class="col-8">
            <div class="row p-3 mb-2">
                <div class="rounded bg-white p-3">
                    <h4>Data terbaru</h4>
                    <hr />
                    <div class="row">
                        <div class="col text-success h3">Nando</div>
                        <div class="col text-success h3">11:40:30</div>
                        <div class="col text-success h3">-</div>
                    </div>
                    <div class="row">
                        <div class="col h6">Agus</div>
                        <div class="col h6">11:39:30</div>
                        <div class="col h6">-</div>
                    </div>
                    <div class="row">
                        <div class="col h6">Sugeng</div>
                        <div class="col h6">11:35:30</div>
                        <div class="col h6">-</div>
                    </div>
                    <div class="row">
                        <div class="col h6">Supri</div>
                        <div class="col h6">11:34:30</div>
                        <div class="col h6">-</div>
                    </div>
                    <div class="row">
                        <div class="col h6">Andi</div>
                        <div class="col h6">11:33:30</div>
                        <div class="col h6">-</div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-6 ">
                    <div class="rounded bg-white p-3">
                        <h4>Data terlambat hari ini</h4>
                        <hr />
                        <div class="marquee-main">
                            <div class="carousel">
                                <div class="carousel__slider">
                                    <ul class="carousel__list">
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Nando</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                        <li class="carousel__item" style="width: 100%">
                                            <div class="row">
                                                <div class="col h6">Andi</div>
                                                <div class="col h6">11:40:30</div>
                                                <div class="col h6">07:00:00</div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-6">
                    <div class="rounded bg-white p-3">
                        <h4>Data terlambat dalam satu bulan</h4>
                        <hr />
                        <div class="overflow-hidden mh-100">
                            <div class="row">
                                <div class="col h6">Nando</div>
                                <div class="col h6">5 Kali</div>
                                <div class="col h6">35 Menit</div>
                            </div>
                            <div class="row">
                                <div class="col h6">Agus</div>
                                <div class="col h6">2 Kali</div>
                                <div class="col h6">60 Menit</div>
                            </div>
                            <div class="row">
                                <div class="col h6">Sugeng</div>
                                <div class="col h6">1 Kali</div>
                                <div class="col h6">14 Menit</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

            h = (h < 10) ? "0" + h : h;
            m = (m < 10) ? "0" + m : m;
            s = (s < 10) ? "0" + s : s;

            var time = h + ":" + m + ":" + s + " ";
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

    <script type="module">
        function carousel() {
            let carouselSlider = document.querySelector(".carousel__slider");
            let list = document.querySelector(".carousel__list");
            let item = document.querySelectorAll(".carousel__item");
            let list2;

            const speed = 0.1;

            const height = list.offsetHeight;
            let y = 0;
            let y2 = height;

            function clone() {
                list2 = list.cloneNode(true);
                carouselSlider.appendChild(list2);
                list2.style.top = `${height}px`;
            }

            function moveFirst() {
                y -= speed;

                if (height >= Math.abs(y)) {
                    list.style.top = `${y}px`;
                } else {
                    y = height;
                }
            }

            function moveSecond() {
                y2 -= speed;

                if (list2.offsetHeight >= Math.abs(y2)) {
                    list2.style.top = `${y2}px`;
                } else {
                    y2 = height;
                }
            }

            function hover() {
                clearInterval(a);
                clearInterval(b);
            }

            function unhover() {
                a = setInterval(moveFirst, 10);
                b = setInterval(moveSecond, 10);
            }

            clone();

            let a = setInterval(moveFirst, 10);
            let b = setInterval(moveSecond, 10);

            carouselSlider.addEventListener("mouseenter", hover);
            carouselSlider.addEventListener("mouseleave", unhover);
        }

        carousel();
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

        .marquee-main {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            max-height: 200px;
        }

        ul {
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .carousel {
            position: relative;
            overflow: hidden;
        }



        .carousel__slider {
            position: relative;
            display: flex;
            align-items: center;
            width: 300px;
            height: 200px;
            /* border: 2px solid #333; */
        }

        .carousel__list {
            position: absolute;
            width: 100%;
            /* height: 100%; */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-around;
        }

        /*

        .carousel__item {
            cursor: pointer;
        }

        .carousel__item:hover {
            background-color: rgba(255, 255, 255, 0.7);
        } */
    </style>
@endpush

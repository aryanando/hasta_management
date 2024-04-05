@extends('layout.token_layout')

@section('content')

    <!-- Page Heading -->
    <div class="row">
        <div class="col-4">
            <h1 class="h1 text-gray-800 text-center">Scan Me</h1>
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
                    <div id="latestData">
                        No Data !!!
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-6 ">
                    <div class="rounded bg-white p-3" style="min-height: 290px">
                        <h4>Data terlambat hari ini</h4>
                        <hr />
                        <ul id="latestLateData">

                        </ul>

                    </div>
                </div>
                <div class="col-6">
                    <div class="rounded bg-white p-3" style="min-height: 290px">
                        <h4>Data terlambat dalam satu bulan</h4>
                        <hr />
                        <div class="overflow-hidden mh-100">
                            <ul>
                                <li>
                                    <div class="row">
                                        <div class="col-6" style="font-size:10px">Coming Soon</div>
                                        <div class="col-3" style="font-size:10px">Coming Soon</div>
                                        <div class="col-3" style="font-size:10px">Coming Soon</div>
                                    </div>
                                </li>
                            </ul>
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

        var token = ""
        window.$(document).ready(function() {
            setInterval(function() {

                axios({
                    method: "get",
                    url: `{{ url('') }}/get-newtoken`,
                }).then((response) => {
                    console.log(response.data.data['token']);
                    if (token != response.data.data['token']) {
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

            generateDataTable()
        }

        function generateDataTable() {
            var div = document.getElementById('latestData');
            var divLateData = document.getElementById('latestLateData');


            $.get("{{ url('') }}/get-absensi", function(data, status) {
                // console.log("Data: " + JSON.stringify(data) + "\nStatus: " + status);
                var firstRow = 0;
                div.innerHTML = ''
                divLateData.innerHTML = ''
                data.data.forEach(element => {
                    console.log(element);
                    var event = new Date(element.absen_check_in);
                    var shiftCheckIn = new Date(element.shift_check_in);

                    var eventEnd = new Date(element.absen_check_out);
                    if (firstRow == 0) {
                        console.log();
                        firstRow++;
                        div.innerHTML +=
                            `<div class="row">
                                <div class="col-6 text-success h5">${element.user_name}</div>
                                <div class="col-2 text-success h5">${event.toLocaleTimeString('id-ID')}</div>
                                <div class="col-2 text-success h5">${element.absen_check_out == null ? '-' : eventEnd.toLocaleTimeString('id-ID')}</div>
                                <div class="col-2 text-success h5">${element.absen_check_out == null ? 'Masuk' : 'Pulang'}</div>
                            </div>`;
                    } else {
                        div.innerHTML +=
                            `<div class="row">
                            <div class="col-6 h6">${element.user_name}</div>
                            <div class="col-2 h6">${event.toLocaleTimeString('id-ID')}</div>
                            <div class="col-2 h6">${element.absen_check_out == null ? '-' : eventEnd.toLocaleTimeString('id-ID')} </div>
                            <div class="col-2 text-success">${element.absen_check_out == null ? 'Masuk' : 'Pulang'}</div>
                        </div>`
                    }

                    console.log(event.getTime() > shiftCheckIn.getTime());

                    if (event.getTime() > shiftCheckIn.getTime()) {
                        divLateData.innerHTML +=
                            `<li>
                                <div class="row">
                                    <div class="col-8" style="font-size:10px">${element.user_name}</div>
                                    <div class="col-2" style="font-size:10px">${event.toLocaleTimeString('id-ID')}</div>
                                    <div class="col-2" style="font-size:10px">${shiftCheckIn.toLocaleTimeString('id-ID')}</div>
                                </div>
                            </li>`
                    }
                });
            });

        }

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

@extends('layout.token_layout')

@section('content')

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Absensi</h1>
    <div class="row">
        <div class="col">
            <div class="d-flex align-items-center justify-content-center">
                {{-- {!! QrCode::size(256)->generate($data->token) !!} --}}
                <canvas id="canvas"></canvas>
            </div>
        </div>
        <div class="col">
            <table id="example" class="display" style="width:100%">
                <thead>
                    <th></th>
                </thead>
            </table>
        </div>
    </div>





@stop

@push('custom-script')
    <script type="module">
        new DataTables('#example', {
            ajax:'http://localhost:8000/get-newtoken',
        });
        var token = ""
        window.$(document).ready(function() {
            setInterval(function() {
                axios({
                    method: "get",
                    url: "http://localhost:8000/get-newtoken",
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
                width: 560,
            }, function(error) {
                if (error) console.error(error)
                console.log('success!');
            })
        }
    </script>
@endpush

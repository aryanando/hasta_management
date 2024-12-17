@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Cari Pasien</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <div class="card">
        <div class="card-body">
            <form>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="byName"
                        onclick="changeSearchBar(this)" checked>
                    <label class="form-check-label" for="flexRadioDefault1">
                        By Nama
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2"
                        value="byNoRM" onclick="changeSearchBar(this)">
                    <label class="form-check-label" for="flexRadioDefault2">
                        By Nomer Rekam Medis
                    </label>
                </div>
                <div class="mb-3">
                    <label for="namaPasien" class="form-label" id="labelForSearchBar">Nama Pasien</label>
                    <input type="text" class="form-control" id="namaPasien" aria-describedby="namaPasien"
                        oninput="processChange()">
                    <div id="namaPasienFormText" class="form-text">Masukkan minimal 3 huruf dan tunggu beberapa saat</div>
                </div>
            </form>
        </div>
    </div>
    <div class="row justify-content-center mt-3 d-none" id="loadingPasien">
        <div class="col text-center">
            <div class="loader ">
                <span class="loader__dot"><i class="bi bi-square-fill" style="height: 30px"></i></span>
                <span class="loader__dot"><i class="bi bi-square-fill" style="height: 30px"></i></span>
                <span class="loader__dot"><i class="bi bi-square-fill" style="height: 30px"></i></span>
            </div>
        </div>
    </div>
    <div class="bg-white p-3 mt-3 border rounded" id="item-result">
        {{-- Disini Bakal Item --}}
        <div class="text-muted" id="statusItem">Silahkan Search</div>
    </div>
@endsection

@push('custom-style')
    <style>
        @keyframes blink {
            50% {
                color: transparent
            }
        }

        .loader__dot {
            animation: 1s blink infinite
        }

        .loader__dot:nth-child(2) {
            animation-delay: 250ms
        }

        .loader__dot:nth-child(3) {
            animation-delay: 500ms
        }

        .alignMe b {
            display: inline-block;
            width: 30%;
            position: relative;
            padding-right: 10px;
            /* Ensures colon does not overlay the text */
        }

        .alignMe b::after {
            content: ":";
            position: absolute;
            right: 10px;
        }
    </style>
@endpush

@push('custom-script')
    <script>
        // $('#filter').change($.debounce(250, show_loading));
        function cariDataPasien() {
            document.getElementById('item-result').innerHTML = '';
            const val = document.getElementById('namaPasien').value;
            const filterChecked = document.querySelector('input[name="flexRadioDefault"]:checked').value;
            if (filterChecked == 'byName') {
                if (val.length >= 3) {
                    document.getElementById('loadingPasien').classList.remove('d-none');
                    console.log(val);
                    getData(val);
                }
            } else {
                if (val.length >= 6) {
                    document.getElementById('loadingPasien').classList.remove('d-none');
                    console.log(val);
                    getData(val);
                }
            }
        }
        // $('#namaPasien').change($.debounce(2000, cariDataPasien));
        function changeSearchBar(filterChecked){
            document.getElementById('item-result').innerHTML = '';
            document.getElementById('namaPasien').value = '';
            if (filterChecked.value == 'byName') {
                document.getElementById('labelForSearchBar').innerHTML = 'Nama Pasien';
                document.getElementById('namaPasienFormText').innerHTML = 'Masukkan minimal 3 huruf dan tunggu beberapa saat';
            }else{
                document.getElementById('labelForSearchBar').innerHTML = 'Nomor RM Pasien';
                document.getElementById('namaPasienFormText').innerHTML = 'Masukkan 6 angka kombinasi nomor RM dan tunggu beberapa saat';
            }
        }


        function debounce(func, timeout = 1500) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    func.apply(this, args);
                }, timeout);
            };
        }

        function saveInput() {
            console.log('Saving data');
        }
        const processChange = debounce(() => cariDataPasien());
    </script>
    <script type="module">
        function getData(params) {
            const filterChecked = document.querySelector('input[name="flexRadioDefault"]:checked').value;
            if (filterChecked == 'byName') {
                var url = "{{ env('API_URL') }}" + '/api/v1/pasien/nama/' + params
            } else {
                var url = "{{ env('API_URL') }}" + '/api/v1/pasien/no-rkm-medis/' + params
            }
            axios.get(url, {
                    'headers': {
                        'Authorization': "Bearer {{ session('token') }}"
                    }
                })
                .then((response => {
                    console.log(response.data.data.length);
                    for (let index = 0; index < 30; index++) {
                        if (response.data.data[index] != null) {
                            var element = response.data.data[index];
                            var cardItem =
                                `<div class="card mb-2">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <ul class="alignMe">
                                                    <li><b>No ReKam Medis</b> ${element.no_rkm_medis}</li>
                                                    <li><b>Nama</b> ${element.nm_pasien}</li>
                                                    <li><b>NIK</b> ${element.no_ktp}</li>
                                                    <li><b>Alamat</b> ${element.alamat}</li>
                                                </ul>
                                            </div>
                                            <div class="col-5">
                                                <button type="button" class="btn btn-primary">Lihat</button>
                                                <button type="button" class="btn" style="background-color: #a9fde8;" onClick="location.href='{{ url('pasien/penunjang/operasi') }}/${element.no_rkm_medis}';">Operasi</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>`;
                            document.getElementById('item-result').innerHTML += cardItem;
                            document.getElementById('loadingPasien').classList.add('d-none');
                        }
                    }
                    if (response.data.data.length == 0) {
                        document.getElementById('loadingPasien').classList.add('d-none');
                    }

                }))
                .catch((error) => {
                    console.log(error);
                });
            console.log(params);
        }
        window.getData = getData;
        window.$ = $;
    </script>
@endpush

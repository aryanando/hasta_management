@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Rujukan</h1>
    {{-- <h5>With great power comes great responsibility!!!.</h5> --}}
    <div class="card my-3 shadow" style="background-color: #d3d3d3;">
        <div class="card-header container-fluid" style="background-color: #bdbdbd;">
            <div class="row">
                <div class="col-md-10">
                    <h3 class="w-75">Data Klaim Rujukan</h3>
                </div>
                <div class="col-md-2">
                    <div class="float-right">
                        @if ($user_data->unit[0]->unit_name == 'RM')
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#modalAddKlaimRujukan">Add</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Data Rujukan Terbaru</h6>
            <div class="row">
                <table id="rujukanTable">
                    <thead>
                        <tr>
                            <th>No. Reg Periksa</th>
                            <th>Tanggal</th>
                            <th>Nama Pasien</th>
                            <th>Perujuk</th>
                            <th>No Hp</th>
                            <th>Petugas Pendaftaran</th>
                            <th>Petugas Kasir</th>
                            <th>Foto</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rujukan as $dataRujukan)
                            <tr>
                                <td>{{ $dataRujukan->no_reg_periksa }}</td>
                                <td>{{ $dataRujukan->created_at }}</td>
                                <td>{{ $dataRujukan->nama_pasien }}</td>
                                <td>{{ $dataRujukan->perujuk_blu->name ?? $dataRujukan->nama_perujuk }}</td>
                                <td>{{ $dataRujukan->no_hp }}</td>
                                <td>{{ $dataRujukan->petugas_pendaftaran->name }}</td>
                                <td>{{ $dataRujukan->petugas_kasir->name ?? '-' }}</td>
                                <td>{{ $dataRujukan->bukti_foto_serahterima }}</td>
                                <td>{{ $dataRujukan->keterangan }}</td>
                                <td>
                                    <div style="width: 70px">
                                        @if ($user_data->unit[0]->unit_name == 'KASIR')
                                            <button
                                                onClick="window.location.href = '{{ route('klaim-rujukan-verif', $dataRujukan->id) }}'"
                                                type="button" class="btn btn-sm btn-outline-secondary" title="Validasi"><i
                                                    class="fa-solid fa-check"></i></button>
                                        @endif
                                        <button
                                            onClick="window.open('{{ route('klaim-rujukan-cetak', $dataRujukan->id) }}', '_blank')"
                                            type="button" class="btn btn-sm btn-outline-secondary" title="Cetak"><i
                                                class="fa-solid fa-print"></i></button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script>
        var sendData = [];

        bluCheckbox = document.getElementById("checkBLU");
        inputBlu = document.getElementById("perujuk_blu_input");
        bluCheckbox.addEventListener('change', (event) => {
            if (event.currentTarget.checked) {
                inputBlu.classList.remove('d-none');
            } else {
                localStorage["perujukKaryawanID"] = null;
                inputBlu.classList.add('d-none');
            }
        })

        function setStep2(index) {
            data = JSON.parse(localStorage["data"]);
            sendData['rawDataRujukan'] = data.data.data[index];
            document.getElementById("no_reg_periksa").value = sendData['rawDataRujukan'].no_rawat;
            document.getElementById("nama_pasien").value = sendData['rawDataRujukan'].registrasi.pasien.nm_pasien;
            document.getElementById("nama_perujuk").value = sendData['rawDataRujukan'].perujuk;
            document.getElementById("petugas_rm").value = '{{ $user_data->name }}';
            document.getElementById("petugas_kasir").value = '-';
            // document.getElementById("biaya").value = sendData['rawDataRujukan'].biaya;
            localStorage["selectedIndex"] = index;
            step(2);
        }

        function step(index) {
            console.log(index);
            var addKlaimRujukan01 = document.getElementById("addKlaimRujukan01");
            var addKlaimRujukan02 = document.getElementById("addKlaimRujukan02");
            var addKlaimRujukan03 = document.getElementById("addKlaimRujukan03");

            addKlaimRujukan01.classList.add("d-none");
            addKlaimRujukan02.classList.add("d-none");
            addKlaimRujukan03.classList.add("d-none");

            if (index == 1) {
                addKlaimRujukan01.classList.remove("d-none");
            } else if (index == 2) {
                addKlaimRujukan02.classList.remove("d-none");
            } else if (index == 3) {
                addKlaimRujukan03.classList.remove("d-none");
            }
        }

        function saveNewDataRujukan() {
            var index = localStorage["selectedIndex"];
            data = JSON.parse(localStorage["data"]);
            sendData['rawDataRujukan'] = data.data.data[index];

            const headers = {
                'Content-Type': 'application/json',
                'Authorization': `Bearer {{ session('token') }}`
            }

            var noPerujuk = document.getElementById("no_hp_perujuk");
            console.log(noPerujuk.value);

            if (noPerujuk.value !== "") {
                var dataSend = {
                    "nama_pasien": sendData['rawDataRujukan'].registrasi.pasien.nm_pasien,
                    "no_reg_periksa": sendData['rawDataRujukan'].no_rawat,
                    "biaya": document.getElementById("biaya").value,
                    "nama_perujuk": sendData['rawDataRujukan'].perujuk,
                    "perujuk_id": localStorage["perujukKaryawanID"] ?? null,
                    "petugas_rm": {{ $user_data->id }},
                    "petugas_kasir": null,
                    "no_hp": document.getElementById("no_hp_perujuk").value,
                    "bukti_foto_serahterima": null,
                    "keterangan": document.getElementById("keterangan").value,
                }

                axios.post('{{ env('API_URL', '') }}/api/v1/rujukan', dataSend, {
                        headers: headers
                    })
                    .then((response) => {
                        console.log(response);
                        window.open(`{{ url('/klaim-rujukan/cetak') }}/${response.data.data.id}`, "_blank");
                        window.location.replace("{{ url('/klaim-rujukan') }}");

                    })
                    .catch((error) => {
                        console.log(error);
                    })
            } else {
                alert('Nomor telp wajib diisi');
            }

        }
    </script>
    <script type="module">
        const header = `Authorization: Bearer {{ session('token') }}`;

        var data = axios.get('{{ env('API_URL', '') }}/api/v1/rujukan-data', {
            headers: {
                "Authorization": `Bearer {{ session('token') }}`
            }
        }).then(
            res => {
                // console.log(res.data.data.length);
                localStorage["data"] = JSON.stringify(res);
                DataTablesRujukanData.clear().draw();
                var i = 0;
                res.data.data.forEach(element => {
                    DataTablesRujukanData.row
                        .add([
                            element.no_rawat,
                            element.registrasi.tgl_registrasi,
                            element.registrasi.pasien.nm_pasien,
                            element.perujuk,
                            element.keterangan,
                            `<button onClick="setStep2(${i})" class="btn btn-info btn-sm rounded" type="button"
                                data-toggle="tooltip" data-placement="top" title="Buat Klaim Rujukan"><i
                                class="fa-solid fa-arrow-right"></i></button>`,
                        ]).draw(false);
                    i++;
                });
            }
        ).catch(err => console.error(err));

        var DataKaryawan = axios.get('{{ env('API_URL', '') }}/api/v1/karyawan', {
            headers: {
                "Authorization": `Bearer {{ session('token') }}`
            }
        }).then(
            res => {
                console.log(res.data.data.karyawan);
                var i = 0;
                var karyawan = [];
                res.data.data.karyawan.forEach(element => {
                    karyawan.push({
                        'label': element.name,
                        'value': element.name,
                        'id': element.id,
                    });
                });
                $("#nama_perujuk_karyawan").autocomplete({
                    source: karyawan,
                    select: function(event, ui) {
                        var label = ui.item.name;
                        var value = ui.item.name;
                        // userId = ui.item.id;

                        if(bluCheckbox.checked){
                            localStorage["perujukKaryawanID"] = ui.item.id;
                        }else{
                            localStorage["perujukKaryawanID"] = null;
                        }
                        // console.log(ui.item.id);
                    }
                });
            }
        ).catch(err => console.error(err));

        var DataTabless = new DataTables('#rujukanTable', {
            responsive: true,
            scrollX: true,
            order: [
                [0, 'desc']
            ]
        });
        var DataTablesRujukanData = new DataTables('#rujukanDataTable', {
            "autoWidth": false,
            scrollX: true,
        });
    </script>
@endpush

@push('custom-modal')
    <div class="modal" tabindex="-1" id="modalAddKlaimRujukan">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="row">
                    <div class="col" id="addKlaimRujukan01">
                        <div class="modal-header">
                            <h5 class="modal-title">Pilih Data Rujukan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table id="rujukanDataTable">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Tanggal</th>
                                        <th>Nama Pasien</th>
                                        <th>Perujuk</th>
                                        <th>Keterangan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button onClick="step(1)" type="button" class="btn btn-outline-secondary"><i
                                                    class="fa-solid fa-arrow-left"></i> Prev</button>
                                            <button onClick="step(2)" type="button" class="btn btn-outline-secondary">Next
                                                <i class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-none" id="addKlaimRujukan02">
                        <div class="modal-header">
                            <h5 class="modal-title">Form Klaim Rujukan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="no_reg_periksa">No. Reg</label>
                                <input name="no_reg_periksa" id="no_reg_periksa" class="form-control form-control-sm mt-2"
                                    type="text" value="No Reg Periksa Pasien" disabled>
                            </div>
                            <div class="form-group">
                                <label for="nama_pasien">Nama Pasien</label>
                                <input name="nama_pasien" id="nama_pasien" class="form-control form-control-sm mt-2"
                                    type="text" value="Nama Pasien" disabled>
                            </div>
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="nama_perujuk">Nama Perujuk</label>
                                        <input name="nama_perujuk" id="nama_perujuk"
                                            class="form-control form-control-sm mt-2" type="text" value="Nama Perujuk"
                                            disabled>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="checkBLU">
                                        <label class="form-check-label" for="checkBLU">
                                            Karyawan?..
                                        </label>
                                    </div>
                                    <div class="d-none" id="perujuk_blu_input"><input name="nama_perujuk_karyawan"
                                            id="nama_perujuk_karyawan" class="form-control form-control-sm mt-2"
                                            type="text" placeholder="Ketikkan atau Pilih Nama Yang Sesuai"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="no_hp_perujuk">Nomor Perujuk</label>
                                <input name="no_hp_perujuk" id="no_hp_perujuk" class="form-control form-control-sm mt-2"
                                    type="text" placeholder="Masukkan Nomor HP disini" required>
                            </div>
                            <div class="form-group">
                                <label for="petugas_rm">Nama Petugas Pendaftaran</label>
                                <input class="form-control form-control-sm mt-2" id="petugas_rm" type="text"
                                    value="Nama Petugas Pendaftaran" disabled>
                                <input name="petugas_rm" id="id_petugas_rm" class="form-control form-control-sm mt-2"
                                    type="text" value="Nama Petugas Pendaftaran" disabled hidden>
                            </div>
                            <div class="form-group">
                                <label for="petugas_kasir">Nama Petugas Kasir</label>
                                <input class="form-control form-control-sm mt-2" id="petugas_kasir" type="text"
                                    value="Nama Petugas Kasir" disabled>
                                <input name="petugas_kasir" id="id_petugas_kasir"
                                    class="form-control form-control-sm mt-2" type="text" value="Nama Petugas Kasir"
                                    disabled hidden>
                            </div>
                            <div class="form-group">
                                <label for="biaya">Biaya</label>
                                <input name="biaya" id="biaya" class="form-control form-control-sm mt-2"
                                    type="number" value=125000 disabled>
                            </div>
                            <div class="form-group">
                                <label for="keterangan">Keterangan</label>
                                <input name="keterangan" id="keterangan" class="form-control form-control-sm mt-2"
                                    type="text" placeholder="Silahkan tuliskan catatan disini">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button onClick="step(1)" type="button" class="btn btn-outline-secondary"><i
                                                    class="fa-solid fa-arrow-left"></i> Prev</button>
                                            <button onClick="step(3)" type="button"
                                                class="btn btn-outline-secondary">Next <i
                                                    class="fa-solid fa-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col d-none" id="addKlaimRujukan03">
                        <div class="modal-header">
                            <h5 class="modal-title">Simpan dan Cetak Klaim Rujukan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Modal body text goes here.</p>
                        </div>
                        <div class="modal-footer">
                            <div class="row">
                                <div class="col">
                                    <div class="d-flex justify-content-between">
                                        <div class="btn-group me-2" role="group" aria-label="First group">
                                            <button onClick="step(2)" type="button" class="btn btn-outline-secondary"><i
                                                    class="fa-solid fa-arrow-left"></i> Prev</button>
                                            <button onClick="" type="button" class="btn btn-outline-secondary">Cetak
                                                <i class="fa-solid fa-print"></i></button>
                                            <button onClick="saveNewDataRujukan()" type="button"
                                                class="btn btn-outline-secondary">Simpan <i
                                                    class="fa-solid fa-save"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('custom-style')
    <style>
        table.dataTable td {
            font-size: 12px;
        }

        table.dataTable th {
            font-size: 12px;
        }

        table.dataTable tr.dtrg-level-0 td {
            font-size: 12px;
        }
    </style>
@endpush

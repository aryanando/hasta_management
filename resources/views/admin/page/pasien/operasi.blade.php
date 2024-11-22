@extends('admin.page.pasien.layout.layout')

@section('content')
    {{-- @dd($data_pasien) --}}
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $data_pasien->nm_pasien }}</h1>
    <h5>Penunjang - Operasi</h5>

    <div class="card mb-2" style="width: 50%">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <ul class="alignMe">
                        <li><b>No ReKam Medis</b> {{ $data_pasien->no_rkm_medis }}</li>
                        <li><b>NIK</b> {{ $data_pasien->no_ktp }}</li>
                        <li><b>Alamat</b> {{ $data_pasien->alamat }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @if (count($data_pasien->reg_periksa) > 0)
        @foreach ($data_pasien->reg_periksa as $reg_periksa_operasi)
            {{-- @dd($reg_periksa_operasi) --}}
            @foreach ($reg_periksa_operasi->data_operasi as $data_operasi)
                <div class="card mb-2">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-7">
                                <ul class="alignMe">
                                    <li><b>No Rawat</b> {{ $reg_periksa_operasi->no_rawat }}</li>
                                    <li><b>Tanggal Registrasi</b> {{ $reg_periksa_operasi->tgl_registrasi }}</li>
                                    <li><b>Jam Registrasi</b> {{ $reg_periksa_operasi->jam_reg }}</li>
                                    <li><b>Tanggal Operasi</b> {{ $data_operasi->tgl_operasi }}</li>
                                    <li><b>Penanggung Jawab</b> {{ $reg_periksa_operasi->data_penjab->png_jawab }}</li>
                                    <li><b>Dokter</b> {{ $reg_periksa_operasi->data_dokter->nm_dokter }}</li>
                                </ul>
                            </div>
                            <div class="col-5">
                                <div class="border p-3 rounded">
                                    @if ($reg_periksa_operasi->data_penjab->png_jawab == 'JASA RAHARJA')
                                        @if ($data_operasi->data_update_operasi == null)
                                            <button type="button" class="btn btn-primary"
                                                onclick="showModalUpdate('{{ $reg_periksa_operasi->no_rawat }}', '{{ $data_operasi->tgl_operasi }}')">Update
                                                Ke Jasaraharja</button>
                                        @else
                                            <div>
                                                Data Telah diupdate
                                                <ul class="alignMe">
                                                    <li><b>Tanggal Update</b>
                                                        {{ \Carbon\Carbon::parse($data_operasi->data_update_operasi->updated_at)->format('d M Y') }}
                                                    </li>
                                                    <li><b>Oleh</b>
                                                        {{ $data_operasi->data_update_operasi->data_petugas->name }}</li>
                                                </ul>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                {{-- <button type="button" class="btn" style="background-color: #a9fde8;" onClick="location.href='{{ url('pasien/penunjang/operasi') }}/${element.no_rkm_medis}';">Operasi</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endforeach
    @else
        Data Not Found
    @endif
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
    <script type="module">
        function updateJasaRaharja(noRawat, tglOperasi) {
            const data = {
                no_rawat: `${noRawat}`,
                tgl_operasi: `${tglOperasi}`,
                biayaoperator1: 6000000,
                biayadokter_anestesi: 2100000,
                biayaasisten_operator1: 600000,
                biayaasisten_anestesi: 300000,
                biayainstrumen: 300000,
                biaya_omloop: 150000,
                biayasewaok: 1000000,
                bagian_rs: 0,
            };

            axios.put("{{ env('API_URL') }}" + '/api/v1/operasi/by-no-rawat', data, {
                    'headers': {
                        'Authorization': "Bearer {{ session('token') }}"
                    }
                })
                .then(response => {
                    console.log(response.data);
                    location.reload();
                })
                .catch(error => {
                    // Handle errors
                });

        }

        function showModalUpdate(noRawat, tglOperasi){
            $("#buttonSaveJR").attr("onclick",`updateJasaRaharja("${noRawat}", "${tglOperasi}")`);
            $('#myModal').modal('show');
        }

        window.updateJasaRaharja = updateJasaRaharja;
        window.showModalUpdate = showModalUpdate;
    </script>
@endpush

@push('custom-modal')
    <div class="modal" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Perubahan Biaya Operasi Tertanggung Jasa Raharja Umum</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Setelah anda menekan tombol <b>Update</b> maka data biaya akan berubah sesuai perhitungan Jasa Raharja, perubahan tidak dapat dikembalikan jadi mohon untuk berhati-hati. Nama akun anda akan tersimpan sebagai petugas yang melakukan perubahan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="buttonSaveJR" onclick="">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </div>
    </div>
@endpush

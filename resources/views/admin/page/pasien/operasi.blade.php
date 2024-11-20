@extends('admin.page.pasien.layout.layout')

@section('content')
    {{-- @dd($data_pasien) --}}
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $data_pasien->nm_pasien }}</h1>
    {{-- <h5>With great power comes great responsibility!!!.</h5> --}}

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
            <div class="card mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-7">
                            <ul class="alignMe">
                                <li><b>No Rawat</b> {{ $reg_periksa_operasi->no_rawat }}</li>
                                <li><b>Tanggal Registrasi</b> {{ $reg_periksa_operasi->tgl_registrasi }}</li>
                                <li><b>Jam Registrasi</b> {{ $reg_periksa_operasi->jam_reg }}</li>
                            </ul>
                        </div>
                        <div class="col-5">
                            <button type="button" class="btn btn-primary">Update Ke Jasaraharja</button>
                            {{-- <button type="button" class="btn" style="background-color: #a9fde8;" onClick="location.href='{{ url('pasien/penunjang/operasi') }}/${element.no_rkm_medis}';">Operasi</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        Data Not Found
    @endif
@endsection

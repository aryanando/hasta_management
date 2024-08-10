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
                        <button class="btn btn-primary">Add</button>
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
                                <td>{{ $dataRujukan->petugas_kasir->name }}</td>
                                <td>{{ $dataRujukan->bukti_foto_serahterima }}</td>
                                <td>{{ $dataRujukan->keterangan }}</td>
                                <td>
                                    -
                                    {{-- <button class="btn btn-danger btn-sm rounded" type="button" data-toggle="tooltip"
                                        data-placement="top" title="Delete"><i class="fa fa-trash"></i></button> --}}
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
    <script type="module">
        var DataTabless = new DataTables('#rujukanTable', {
            responsive: true
        });
    </script>
@endpush

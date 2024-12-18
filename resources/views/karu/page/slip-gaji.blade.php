@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Keuangan</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        <div class="col-4">
            <form action="{{ route('import-excel') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="file">Silahkan Pilih File Exel Yang Sesuai Format</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="selectBulan">Silahkan Pilih Bulan</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="selectBulan" name="bulan">
                        <option selected value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="selectTahun">Silahkan Pilih Tahun</label>
                    <select class="form-select form-select-sm" aria-label=".form-select-sm example" id="selectTahun" name="tahun">
                        <option selected value="2024">2024</option>
                        <option value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Import</button>
            </form>
        </div>
    </div>

    <div class="mt-2">
        <table id="salaryTable" class="">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Bulan</th>
                    <th>Tahun</th>
                    <th>Penghasilan</th>
                    <th>Potongan</th>
                    <th>Diterima</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPenghasilan as $data)
                    <tr>
                        <td>{{ $data->user->name }}</td>
                        <td>{{ $data->bulan }}</td>
                        <td>{{ $data->tahun }}</td>
                        <td>{{ Number::currency($data->jumlah_gaji, 'IDR', 'id') }}</td>
                        <td>{{ Number::currency($data->jumlah_potongan, 'IDR', 'id') }}</td>
                        <td>{{ Number::currency($data->jumlah_diterima, 'IDR', 'id') }}</td>
                        <td>
                            <button type="button" class="btn btn-success"
                                onclick="location.href='{{ url('keuangan/' . $data->id) }}';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eye" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z">
                                    </path>
                                    <path
                                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0">
                                    </path>
                                </svg>
                                Lihat
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#salaryTable', {
            responsive: true,
            order: {
                idx: 1,
                dir: 'dec'
            }
        });
    </script>
@endpush

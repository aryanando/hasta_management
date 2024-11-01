@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Data Gaji Baru</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
                    @if ($data->status == 0)
                        <tr>
                            <td>{{ $data->user->name ?? '-' }}</td>
                            <td>{{ $data->bulan }}</td>
                            <td>{{ $data->tahun }}</td>
                            <td>{{ $data->jumlah_gaji == null ? '-' : Number::currency($data->jumlah_gaji, 'IDR', 'id') }}</td>
                            <td>{{ $data->jumlah_potongan == null ? '-' :Number::currency($data->jumlah_potongan, 'IDR', 'id') }}</td>
                            <td>{{ $data->jumlah_diterima == null ? '-' :Number::currency($data->jumlah_diterima, 'IDR', 'id') }}</td>
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
                    @endif
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

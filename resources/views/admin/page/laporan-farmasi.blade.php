@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Farmasi</h1>
    <p><strong>Jumlah Tidak Terpakai:</strong> {{ $jumlah_tidak_terpakai }}</p>
    <p><strong>Jumlah Terpakai:</strong> {{ $jumlah_terpakai }}</p>

    <table id="farmasiDataTable" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th rowspan='2'>Nama Obat</th>
                <th rowspan='2'>Jenis Obat</th>
                <th colspan='2'><b>Gudang Farmasi</b></th>
                <th colspan='2'><b>Farmasi Rajal</b></th>
                <th colspan='2'><b>Farmasi Ranap</b></th>
            </tr>
            <tr>
                <th>Sebelum</th>
                <th>Sesudah</th>
                <th>Sebelum</th>
                <th>Sesudah</th>
                <th>Sebelum</th>
                <th>Sesudah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_farmasi as $dtfarmasi)
                @php
                    $today = now()->format('Y-m-d');

                    $gudangFarmasi =
                        collect($dtfarmasi['data_riwayat_barang_medis'])->firstWhere('kd_bangsal', 'G001')[
                            'stok_akhir'
                        ] ??
                        (collect($dtfarmasi['data_riwayat_barang_medis_last_g001'])->firstWhere('kd_bangsal', 'G001')[
                            'stok_akhir'
                        ] ??
                            0);

                    $farmasiRajalData = collect($dtfarmasi['data_riwayat_barang_medis'])
                        ->filter(function ($item) use ($today) {
                            return isset($item['kd_bangsal'], $item['tanggal']) &&
                                $item['kd_bangsal'] === 'B0152' &&
                                $item['tanggal'] !== $today;
                        })
                        ->sortBy(function ($item) {
                            return abs(strtotime($item['jam']) - strtotime('15:00:00')); 
                        })
                        ->first();

                    $farmasiRajal =
                        $farmasiRajalData['stok_akhir'] ??
                        (collect($dtfarmasi['data_riwayat_barang_medis_last_b0152'])->firstWhere('kd_bangsal', 'B0152')[
                            'stok_akhir'
                        ] ??
                            0);

                    $farmasiRanapData = collect($dtfarmasi['data_riwayat_barang_medis'])
                        ->filter(function ($item) use ($today) {
                            return isset($item['kd_bangsal'], $item['tanggal']) &&
                                $item['kd_bangsal'] === 'B0153' &&
                                $item['tanggal'] !== $today;
                        })
                        ->sortBy(function ($item) {
                            return abs(strtotime($item['jam']) - strtotime('15:00:00')); 
                        })
                        ->first();

                    $farmasiRanap =
                        $farmasiRanapData['stok_akhir'] ??
                        (collect($dtfarmasi['data_riwayat_barang_medis_last_b0153'])->firstWhere('kd_bangsal', 'B0153')[
                            'stok_akhir'
                        ] ??
                            0);

                    $gudangFarmasi2 =
                        collect($dtfarmasi['data_gudang_barang'])->firstWhere('kd_bangsal', 'G001')['stok'] ?? 0;
                    $farmasiRajal2 =
                        collect($dtfarmasi['data_gudang_barang'])->firstWhere('kd_bangsal', 'B0152')['stok'] ?? 0;
                    $farmasiRanap2 =
                        collect($dtfarmasi['data_gudang_barang'])->firstWhere('kd_bangsal', 'B0153')['stok'] ?? 0;
                @endphp
                <tr>
                    <td>{{ $dtfarmasi['nama_brng'] ?? '-' }}</td>
                    <td>{{ $dtfarmasi['data_kategori_barang']['nama'] ?? '-' }}</td>
                    <td class="text-center">{{ $gudangFarmasi }}</td>
                    <td class="text-center">{{ $gudangFarmasi2 }}</td>
                    <td class="text-center">{{ $farmasiRajal }}</td>
                    <td class="text-center">{{ $farmasiRajal2 }}</td>
                    <td class="text-center">{{ $farmasiRanap }}</td>
                    <td class="text-center">{{ $farmasiRanap2 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#farmasiDataTable', {
            responsive: true
        });
    </script>
@endpush

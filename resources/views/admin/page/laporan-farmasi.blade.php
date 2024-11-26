@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Farmasi</h1>
    {{-- <h5>With great power comes great responsibility!!!.</h5> --}}
    @dd($data_farmasi)
    <table id="farmasiDataTable">
        <thead>
            <tr>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_farmasi as $obat)
                <tr>
                    <td>{{ $obat->nama_brng }}</td>
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

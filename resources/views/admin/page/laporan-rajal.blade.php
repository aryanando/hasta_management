@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Rawat Jalan</h1>
    {{-- <h5>With great power comes great responsibility!!!.</h5> --}}

    <table id="rajalDataTable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>No Rawat</th>
                <th>No Rawat</th>
                <th>No Rawat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_rajal as $rajal)
                <tr>
                    <td>{{ $rajal->pasien->nm_pasien }}</td>
                    <td>{{ $rajal->no_rawat }}</td>
                    <td>{{ $rajal->no_rawat }}</td>
                    <td>{{ $rajal->no_rawat }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#rajalDataTable', {
            responsive: true
        });
    </script>
@endpush

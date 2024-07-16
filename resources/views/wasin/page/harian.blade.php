@extends('wasin.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Harian Absensi</h1>
    
    <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <tr>
                    <th>No</th>
                    <th>Nama Pegawai</th>
                    <th>Unit</th>
                    <th>Ket</th>
                    @for ($day = 1; $day <= $jumlahhari; $day++)
                        <th class="text-center">{{ $day }}</th>
                    @endfor
                </tr>
            <tbody>
            @foreach($datatable as $row)
                    <tr>
                        <td rowspan="2">{{ $loop->iteration }}</td>
                        <td rowspan="2">{{ $row->name }}</td>
                        <td rowspan="2">{{ $row->unit }}</td>
                        <td>Masuk</td>
                    @foreach($absen as $attendance)
                        @if ($attendance->user_id == $row->id)
                            <td class="text-center">{{ $attendance->check_in }}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td>Pulang</td>
                    @foreach($absen as $attendance)
                        @if ($attendance->user_id == $row->id)
                            <td class="text-center">{{ $attendance->check_out }}</td>
                        @endif
                    @endforeach
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>


@endsection
    

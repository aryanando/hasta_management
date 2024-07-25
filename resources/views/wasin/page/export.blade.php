@extends('wasin.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Bulanan Absensi</h1>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <!-- Month Selector -->
            <form class="d-flex" action="{{ route('absensi_export') }}" method="GET" class="mb-0">

                <div class="form-group mb-0 me-2">
                    <select class="form-control form-control-solid" id="monthSelect" name="month">
                        @foreach (range(1, 12) as $month)
                            <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
        </div>
        <div class="card-body">

            <!-- Table Content -->
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pegawai</th>
                            <th>Unit</th>
                            <th>Ket</th>
                            @for ($day = 1; $day <= $jumlahhari; $day++)
                                <th class="text-center">{{ $day }}</th>
                            @endfor
                            <th>Telat</th>
                        </tr>
                    </thead>
                    <tbody id="dataTableBody">
                        @foreach ($datatable as $row)
                            <tr>
                                <td rowspan="2">{{ $loop->iteration }}</td>
                                <td rowspan="2">{{ $row->name }}</td>
                                <td rowspan="2">{{ $row->unit }}</td>
                                <td>Masuk</td>
                                @for ($day = 1; $day <= $jumlahhari; $day++)
                                    @php
                                        $date = date('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
                                        $check_in = isset($absen[$row->id][$date]['check_in'])
                                            ? $absen[$row->id][$date]['check_in']
                                            : '-';
                                        $status = isset($absen[$row->id][$date]['status'])
                                            ? $absen[$row->id][$date]['status']
                                            : '';
                                        $status_class = $status === 'Telat' ? 'text-danger' : '';
                                    @endphp
                                    <td class="text-center"><span class="{{ $status_class }}">{{ $check_in }}</span>
                                    </td>
                                @endfor
                                <td rowspan="2" class="text-center">{{ $absen[$row->id]['telat_count'] ?? 0 }}</td>
                            </tr>
                            <tr>
                                <td>Pulang</td>
                                @for ($day = 1; $day <= $jumlahhari; $day++)
                                    @php
                                        $date = date('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
                                        $check_out = isset($absen[$row->id][$date]['check_out'])
                                            ? $absen[$row->id][$date]['check_out']
                                            : '-';
                                    @endphp
                                    <td class="text-center">{{ $check_out }}</td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

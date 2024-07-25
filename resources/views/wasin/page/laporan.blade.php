
@extends('wasin.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Bulanan Absensi</h1>

    <!-- Month Selector -->
    <div class="mb-4">
        <select id="monthSelector" class="form-control">
            @foreach (range(1, 12) as $month)
                @php
                    $monthName = DateTime::createFromFormat('!m', $month)->format('F');
                @endphp
                <option value="{{ $month }}" {{ $selectedMonth == $month ? 'selected' : '' }}>
                    {{ $monthName }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Export Button -->
    {{-- <div class="mb-4">
        <button id="exportButton" class="btn btn-primary">Export to CSV</button>
    </div> --}}


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
                            <td class="text-center"><span class="{{ $status_class }}">{{ $check_in }}</span></td>
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
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#monthSelector').on('change', function() {
                let month = $(this).val();

                $.ajax({
                    url: '{{ route('absensi_laporan') }}',
                    method: 'GET',
                    data: {
                        month: month
                    },
                    success: function(response) {
                        let tableBody = $('#dataTableBody');
                        let rows = '';

                        response.datatable.forEach((data, index) => {
                            let absensiData = response.absen[data.id] || {};
                            let telatCount = absensiData['telat_count'] || 0;

                            // Generate Masuk and Pulang rows
                            let masukRow = '<tr><td rowspan="2">' + (index + 1) +
                                '</td><td rowspan="2">' + data.name +
                                '</td><td rowspan="2">' + data.unit +
                                '</td><td>Masuk</td>';
                            let pulangRow = '<tr><td>Pulang</td>';

                            for (let day = 1; day <= response.jumlahhari; day++) {
                                let date =
                                    `{{ date('Y') }}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                                let checkIn = absensiData[date] ? absensiData[date][
                                    'check_in'
                                ] : '-';
                                let checkOut = absensiData[date] ? absensiData[date][
                                    'check_out'
                                ] : '-';
                                let status = absensiData[date] ? absensiData[date][
                                    'status'
                                ] : '';
                                let statusClass = status === 'Telat' ? 'text-danger' :
                                    '';

                                masukRow +=
                                    `<td class="text-center"><span class="${statusClass}">${checkIn}</span></td>`;
                                pulangRow +=
                                    `<td class="text-center">${checkOut !== undefined ? checkOut : 'Belum Absen Pulang'}</td>`;
                            }

                            masukRow +=
                                `<td rowspan="2" class="text-center">${telatCount}</td></tr>`;
                            pulangRow += '</tr>';

                            rows += masukRow + pulangRow;
                        });

                        tableBody.html(rows);
                    },
                    error: function(xhr) {
                        console.log('An error occurred:', xhr.responseText);
                    }
                });
            });

            $('#exportButton').on('click', function() {
                let month = $('#monthSelector').val();
                window.location.href = '{{ route('absensi_laporan') }}?export=1&month=' + month;
            });
        });
    </script>
@endpush
@push('custom-script2')

@endpush





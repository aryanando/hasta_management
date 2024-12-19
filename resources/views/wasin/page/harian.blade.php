    @extends('wasin.layout.layout')

    @section('content')
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Laporan Harian Absensi</h1>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <!-- Filter Form -->
                <form id="filterForm" class="d-flex">
                    <div class="form-gr oup mb-0 me-2">
                        <label for="unitSelect" class="form-label sr-only">Select Unit</label>
                        <select class="form-control form-control-solid" id="unitSelect" name="unit">
                            <option value="">All Units</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}" {{ request('unit') == $unit->id ? 'selected' : '' }}>
                                    {{ $unit->unit_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-0 me-2">
                        <label for="dateSelect" class="form-label sr-only">Select Date</label>
                        <input type="date" class="form-control form-control-solid" id="dateSelect" name="date"
                            value="{{ request('date', date('Y-m-d')) }}">
                    </div>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>

                <!-- Export Button -->
                <form action="{{ route('export_absensi') }}" method="GET" class="mb-0">
                    <input type="hidden" name="unit" id="exportUnit">
                    <input type="hidden" name="date" id="exportDate">
                    <button type="submit" class="btn btn-success">Export to Excel</button>
                </form>
            </div>

            <!-- Table Content -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>Unit</th>
                                <th>Shifts Pegawai</th>
                                <th>Jam Datang</th>
                                <th>Jam Pulang</th>
                                <th>Selisih</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="dataTableBody">
                            @foreach ($datatable as $key => $data)
                                @php
                                    $absensiData = $absensi->where('user_id', $data->id)->first();
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $data->name }}</td>
                                    <td>{{ $data->unit }}</td>
                                    <td>{{ $absensiData ? $absensiData->shift_name . ' - ' . $absensiData->sfmasuk : '--' }}
                                    </td>
                                    <td>{{ $absensiData ? $absensiData->masuk : '--' }}</td>
                                    <td>{{ $absensiData ? $absensiData->pulang : '--' }}</td>
                                    <td>{{ $absensiData ? $absensiData->difference : '--' }}</td>
                                    <td>
                                        @if ($absensiData)
                                            @if ($absensiData->status === 'Telat')
                                                <span class="badge text-bg-danger">Telat</span>
                                            @elseif ($absensiData->status === 'Tepat Waktu')
                                                <span class="badge text-bg-success">Tepat Waktu</span>
                                            @else
                                                <span class="badge text-bg-secondary">Belum Absen</span>
                                            @endif
                                        @else
                                            <span class="badge text-bg-secondary">Belum Absen</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function() {
                $('#filterForm').on('submit', function(event) {
                    event.preventDefault();
                    let unit = $('#unitSelect').val();
                    let date = $('#dateSelect').val() || '{{ date('Y-m-d') }}';
                    $('#exportUnit').val(unit);
                    $('#exportDate').val(date);

                    $.ajax({
                        url: '{{ route('filter_absensi', [], true) }}',
                        method: 'GET',
                        data: {
                            unit: unit,
                            date: date
                        },
                        success: function(response) {
                            console.log(response);
                            let tbody = $('#dataTableBody');
                            tbody.empty();
                            let rows = '';

                            if (response.datatable && response.absensi) {
                                response.datatable.forEach(function(data, index) {
                                    let absensiData = response.absensi.find(a => a
                                        .user_id == data.id);

                                    let statusClass = absensiData ? (absensiData.status ===
                                            'Telat' ? 'text-bg-danger' :
                                            (absensiData.status === 'Tepat Waktu' ?
                                                'text-bg-success' : 'text-bg-secondary')) :
                                        'text-bg-secondary';

                                    rows += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${data.name}</td>
                                        <td>${data.unit}</td>
                                        <td>${absensiData ? (absensiData.shift_name ? absensiData.shift_name : '--') : '--'} - 
                                            ${absensiData ? (absensiData.sfmasuk ? absensiData.sfmasuk : '--') : '--'}</td>
                                        <td>${absensiData ? (absensiData.masuk ? absensiData.masuk : '--') : '--'}</td>
                                        <td>${absensiData ? (absensiData.pulang ? absensiData.pulang : '--') : '--'}</td>
                                        <td>${absensiData ? (absensiData.difference ? absensiData.difference : '--') : '--'}</td>
                                        <td>
                                            <span class="badge ${statusClass}">
                                                ${absensiData ? (absensiData.status ? absensiData.status : 'Belum Absen') : 'Belum Absen'}
                                            </span>
                                        </td>
                                    </tr>
                                `;
                                });
                            }

                            tbody.append(rows);
                        }
                    });

                });
            });
        </script>
    @endpush


    @push('custom-script')
        <script type="module">
            var DataTabless = new DataTables('#dataTable', {
                responsive: true,
                paging: false,
                retrieve: true,
            });
        </script>
    @endpush

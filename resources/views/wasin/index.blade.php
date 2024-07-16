@extends('wasin.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Wasin</h1>
    <h5>Dashboard</h5>


    <form id="dateFilterForm" method="GET" action="">
        <div class="mb-3">
            <select class="form-control form-control-solid" id="monthSelect" name="month">
                @foreach (range(1, 12) as $month)
                    <option value="{{ $month }}" {{ request('month') == $month ? 'selected' : '' }}>
                        {{ date('F', mktime(0, 0, 0, $month, 1)) }}
                    </option>
                @endforeach
            </select>
            
        </div>
    </form>
    <canvas id="myChart" width="100%" height="25"></canvas>
    <br>
    <h1 class="h3 mb-4 text-gray-800">Data Shift Hari ini</h1>
    <form id="shiftFilterForm" method="GET" action="{{ route('change') }}">
        <div class="mb-3">
            <label for="dateSelect">Select Day:</label>
            <select class="form-control form-control-solid" id="dateSelect" name="day">
                @foreach (range(1, 31) as $day)
                    <option value="{{ $day }}" {{ request('day') == $day ? 'selected' : '' }}>
                        {{ $day }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="month" value="{{ request('month', date('m')) }}">
        </div>
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Total Absen</th>
                <th>Shift </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($absen_shift as $shift)
                <tr>
                    <td>{{ $shift->checkin_date }}</td>
                    <td>{{ $shift->total_checkins }}</td>
                    <td>{{ $shift->shift_category }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="1">Total</th>
                <th>{{ $total_absen }}</th>
                <th></th>
            </tr>
        </tfoot>
    </table>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('monthSelect').addEventListener('change', function() {
                document.getElementById('dateFilterForm').submit();
            });

            var ctx = document.getElementById('myChart').getContext('2d');

            var data = @json($datachart);
            var labels = [];
            var dataPoints = [];

            // Extracting labels and data points from the query result
            data.forEach(function(item) {
                labels.push(item.checkin_date);
                dataPoints.push(item.total_checkins);
            });

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Kehadiran',
                        data: dataPoints,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush

{{-- @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('myChart').getContext('2d');

            var data = <?php echo json_encode($datachart); ?>;
            var labels = [];
            var dataPoints = [];

            // Extracting labels and data points from the query result
            data.forEach(function(item) {
                labels.push(item.checkin_date); // Change to checkin_date
                dataPoints.push(item.total_checkins); // Change to total_checkins
            });

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Check-ins',
                        data: dataPoints,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush --}}

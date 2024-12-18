@extends('karu.layout.layout')

@section('content')
    {{-- @dd($esurvey_unit) --}}
    <h1>Data Esurvey Unit</h1>

    @if ($user_data->id == (200 || 1) )
        <div class="btn-group">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown"
                aria-expanded="false">
                Jenis Karyawan -
                @foreach ($jenis_karyawan as $data)
                    {{ $data->id == collect(request()->segments())->last() ? ' - ' . $data->name : '' }}
                @endforeach
            </button>
            <ul class="dropdown-menu">
                @foreach ($jenis_karyawan as $data)
                    <li><a class="dropdown-item"
                            href="/karu/esurvey-jenis-karyawan/{{ $data->id }}">{{ $data->name }}</a></li>
                @endforeach
            </ul>
        </div>
    @endif

    <table id="esurveyDataTable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>File</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($esurvey_unit as $esurveyData)
                <tr>
                    <td>{{ $esurveyData->name }}</td>
                    <td>
                        @if (count($esurveyData->esurvey) > 0)
                            <button type="button" class="btn btn-success"
                                onclick="blankFun('{{ env('API_URL') }}/{{ $esurveyData->esurvey[0]->image ?? '-' }}');"
                                formtarget="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-patch-check" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0">
                                    </path>
                                    <path
                                        d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z">
                                    </path>
                                </svg>
                                Lihat
                            </button>
                        @else
                            <button type="button" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-patch-exclamation" viewBox="0 0 16 16">
                                    <path
                                        d="M7.001 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.553.553 0 0 1-1.1 0z">
                                    </path>
                                    <path
                                        d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911z">
                                    </path>
                                </svg>
                                Belum Upload
                            </button>
                        @endif
                    </td>
                    <td>{{ count($esurveyData->esurvey) > 0 ? ($esurveyData->esurvey[0]->status == 0 ? 'verified' : 'unverified') : '-' }}
                    </td>
                    <td><i class="bi bi-trash"></i></td>
                </tr>
            @endforeach
        </tbody>

    </table>
    <div class="row mb-3">
        <div class="col-4">
            <div style="width: 300px;"><canvas id="polriChart"></canvas></div>
        </div>
        <div class="col-4">
            <div style="width: 300px;"><canvas id="pnsChart"></canvas></div>
        </div>
        <div class="col-4">
            <div style="width: 300px;"><canvas id="bluChart"></canvas></div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#esurveyDataTable', {
            responsive: true
        });

        const dataPolri = {
            'data': {
                labels: [
                    'Sudah Upload',
                    'Belum Upload',
                ],
                datasets: [{
                    label: 'Data ESurvey Polri',
                    data: [{{ $statistic->polri->sudah }}, {{ $statistic->polri->belum }}],
                    backgroundColor: [
                        '#85e085',
                        '#ffb3b3',
                    ],
                    hoverOffset: 4
                }]
            },
            'title': 'Data Esurvey Polri',
            'canvas': document.getElementById('polriChart')
        };
        const dataPNS = {
            'data': {
                labels: [
                    'Sudah Upload',
                    'Belum Upload',
                ],
                datasets: [{
                    label: 'Data ESurvey PNS Polri',
                    data: [{{ $statistic->pns->sudah }}, {{ $statistic->pns->belum }}],
                    backgroundColor: [
                        '#85e085',
                        '#ffb3b3',
                    ],
                    hoverOffset: 4
                }]
            },
            'title': 'Data Esurvey PNS Polri',
            'canvas': document.getElementById('pnsChart')
        };
        const dataBLU = {
            'data': {
                labels: [
                    'Sudah Upload',
                    'Belum Upload',
                ],
                datasets: [{
                    label: 'Data ESurvey BLU',
                    data: [{{ $statistic->blu->sudah }}, {{ $statistic->blu->belum }}],
                    backgroundColor: [
                        '#85e085',
                        '#ffb3b3',
                    ],
                    hoverOffset: 4
                }]
            },
            'title': 'Data Esurvey BLU',
            'canvas': document.getElementById('bluChart')
        };

        buildChart(dataPolri);
        buildChart(dataPNS);
        buildChart(dataBLU);

        function buildChart(data) {
            const polriChart = new Chart(data.canvas, {
                plugins: [ChartDataLabels],
                type: 'pie',
                data: data.data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: data.title,
                        }
                    }
                },
            });
        }
    </script>

    <script>
        function blankFun(uri) {
            window.open(uri, '_blank');
        }
    </script>
@endpush

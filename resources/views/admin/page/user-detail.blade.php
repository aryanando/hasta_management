@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ $users->name }}</h1>
    <div class="row">
        <div class="col-4">
            <div class="card mb-3">
                <div class="card-header bg-transparent">Detail Users</div>
                <div class="card-body">
                    <p class="card-text small">Name : {{ $users->name }}</p>
                    <p class="card-text small">Email : {{ $users->email }}</p>
                    <p class="card-text small">Unit : {{ $users->unit->unit_name }}</p>
                </div>
                <div class="card-footer bg-transparent small text-muted ">Updated At
                    {{ \Carbon\Carbon::parse($users->updated_at)->format('M d Y') }}</div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mb-3">
                <div class="card-header bg-transparent">Absensi</div>
                <div class="card-body">
                    <p class="card-text small">Shift Hari Ini : {{ $users->shifts[0]->shifts->shift_name }} (
                        {{ $users->shifts[0]->shifts->check_in . '-' . $users->shifts[0]->shifts->check_out }} )</p>
                    <p class="card-text small">Check In : {{ $users->shifts[0]->check_in ?? '-' }}</p>
                    <p class="card-text small">Check In : {{ $users->shifts[0]->check_out ?? '-' }}</p>
                </div>
                <div class="card-footer bg-transparent small text-muted ">Updated At
                    {{ \Carbon\Carbon::parse($users->shifts[0]->updated_at)->format('M d Y') }}</div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mb-3">
                <div class="card-header bg-transparent">E-Survey</div>
                <div class="card-body">
                    <div class="mb-2">
                        @if (count($users->esurvey) > 0)
                            <button type="button" class="btn btn-success"
                                onclick="blankFun('{{ env('API_URL') }}/{{ $users->esurvey[0]->image ?? '-' }}');"
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
                    </div>
                </div>
                <div class="card-footer bg-transparent small text-muted ">Updated At
                    {{ count($users->esurvey) > 0 ? \Carbon\Carbon::parse($users->esurvey[0]->updated_at)->format('M d Y') : '-' }}</div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#usersTable', {
            responsive: true
        });
    </script>
@endpush

@push('custom-modal')
@endpush

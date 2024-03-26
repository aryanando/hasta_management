@extends('karu.layout.layout')

@section('content')
    @php
        $d = cal_days_in_month(CAL_GREGORIAN, 3, 2024);
    @endphp

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Jadwal Karyawan</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <div class="overflow-auto">
        <table class="table">
            <thead>
                <tr>
                    <th style="min-width: 200px">Nama</th>
                    @for ($i = 0; $i < $d; $i++)
                        <th scope="col">{{ $i + 1 }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($unit->unit_member as $member)
                    <tr>
                        <td style="font-size: 12px">
                            <small>
                                {{ $member->name }}
                            </small>
                        </td>
                        @for ($i = 0; $i < $d; $i++)
                            <td tyle="font-size: 12px">
                                <small class="border rounded p-1" style="background-color: greenyellow">
                                    {{ 'Pagi' }}
                                </small>
                            </td>
                        @endfor
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection

@push('custom-style')
    <style>
        .headcol {
            position: absolute;
            width: 5em;
            left: 0;
            top: auto;
            border-top-width: 1px;
            /*only relevant for first row*/
            margin-top: -1px;
            /*compensate for top border*/
        }
    </style>
@endpush

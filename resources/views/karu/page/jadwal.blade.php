@extends('karu.layout.layout')

@section('content')

@php
    $d=cal_days_in_month(CAL_GREGORIAN,3,2024);
@endphp

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Jadwal Karyawan</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                @for ($i=0; $i<$d; $i++)
                    <th>{{$i+1}}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach ($unit->unit_member as $member)
            <tr>
                <td>
                    {{$member->name}}
                </td>
                @for ($i=0; $i<$d; $i++)
                    <th>A - </th>
                @endfor
            </tr>
            @endforeach

        </tbody>
    </table>
@endsection

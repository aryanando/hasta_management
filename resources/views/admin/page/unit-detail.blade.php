@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Admin</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <hr />
    <div class="row">
        <div class="row">
            <div class="col col-12 col-sm-12 col-lg-8 p-2">
                <div class="bg-white p-2 rounded mb-2">
                    <div class="row">
                        <h3>Data Unit</h3>
                    </div>
                    <hr />
                    <div class="row">
                        <div>Nama : {{ $unit->unit_name }}</div>
                        <div>Deskripsi : {{ $unit->unit_description }}</div>
                        <div>Kepala Unit : {{ $unit->unit_leader->name }}</div>
                    </div>
                </div>

                <div class="bg-white p-2 rounded mb-2">
                    <div class="row">
                        <h3>Anggota Unit</h3>
                    </div>
                    <hr />
                    <table id="unitTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unit->unit_member as $unitMember)
                            @php
                                $url = url('');
                            @endphp
                                <tr>
                                    <td>{{ $unitMember->id }}</td>
                                    <td>{{ $unitMember->name }}</td>
                                    <td>{{ $unitMember->email }}</td>
                                    <td>
                                        <button onclick="window.location='{{$url}}/admin/unit/{{$unitMember->id}}'" class="btn btn-success btn-sm rounded" type="button" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fa fa-edit"></i></button>
                                        <button class="btn btn-danger btn-sm rounded" type="button" data-toggle="tooltip"
                                            data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#unitTable', {
            responsive: true
        });
    </script>
@endpush

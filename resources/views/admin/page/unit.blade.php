@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Admin</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <hr />
    <div class="row">
        <div class="col col-12 col-sm-12 col-lg-8 p-2">
            <div class="bg-white p-2 rounded">
                <div class="row">
                    <h3>Data Unit</h3>
                </div>
                <hr />
                <div class="row">
                    <table id="unitTable">
                        <thead>
                            <tr>
                                <th>Unit Name</th>
                                <th>Deskripsi Unit</th>
                                <th>Kepala Unit</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($unit as $unitData)
                            @php
                                $url = url('');
                            @endphp
                                <tr>
                                    <td>{{ $unitData->unit_name }}</td>
                                    <td>{{ $unitData->unit_description }}</td>
                                    <td>{{ $unitData->leader_name }}</td>
                                    <td>
                                        <button onclick="window.location='{{$url}}/admin/unit/{{$unitData->id}}'" class="btn btn-success btn-sm rounded" type="button" data-toggle="tooltip"
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

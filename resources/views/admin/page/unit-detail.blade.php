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
                    <div class="d-flex justify-content-between">
                        <h3>Anggota Unit</h3>
                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#addUnitModal">Tambah</button>
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
                                        {{-- <button
                                            onclick="window.location='{{ $url }}/admin/unit/{{ $unitMember->id }}'"
                                            class="btn btn-success btn-sm rounded" type="button" data-toggle="tooltip"
                                            data-placement="top" title="Edit"><i class="fa fa-edit"></i></button> --}}
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

    <script>
        let userId;
        $.ajax({
            url: "{{ url('') }}/admin/api/karyawan/noUnit",
            success: function(result) {
                console.log(result);
                
                $("#tags").autocomplete({
                    source: result,

                    select: function(event, ui) {
                        var label = ui.item.label;
                        var value = ui.item.value;
                        userId = ui.item.id;
                        //store in session
                        console.log(ui.item.id);
                    }
                });
            }
        });

        function addUnitMember() {
            console.log('here');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.post("<?= Request::url() ?>", {
                    user_id: userId
                },
                function(data, status, response) {
                    console.log("Data: " + data + "\nStatus: " + status);
                    if (status == "success") {
                        window.location.href = "<?= Request::url() ?>";
                    }else{
                        alert("Gagal!!! Tolong Hubungi Admin")
                    }
                },
                // function(response) {
                //     console.log(response);
                // }
            );
        }
    </script>
@endpush

@push('custom-modal')
    <div class="modal fade" id="addUnitModal" tabindex="-1" role="dialog" aria-labelledby="addUnitModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUnitModalLabel">Tambah Anggota Unit</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="form-control" id="tags" placeholder="masukkan nama!!!">
                    <p>Silahkan masukkan nama pada form diatas</p>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="button" onclick="addUnitMember()">Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endpush

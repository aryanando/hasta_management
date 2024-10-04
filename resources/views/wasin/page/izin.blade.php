@extends('wasin.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Cuti</h1>
        <h5>Cuti</h5>
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered"  width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Mulai</th>
                                            <th>Selesai</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tiger Nixon</td>
                                            <td>04 Apr 2024</td>
                                            <td>06 Apr 2024</td>
                                            <td>Keterangan</td>
                                            <td>
                                                <div class="dropdown mb-4">
                                                    <button class="btn btn-secondary " type="button" >
                                                        Download
                                                    </button>
                                                    <button class="btn btn-warning   " type="button">
                                                        Hapus
                                                    </button>
                                                </div> 
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


@endsection
    

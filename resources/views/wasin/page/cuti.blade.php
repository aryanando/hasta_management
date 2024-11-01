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
                                            <th>Cuti Dari</th>
                                            <th>Sampai</th>
                                            <th>Masuk Kerja</th>
                                            <th>Jumlah Cuti</th>
                                            <th>Keperluan Cuti</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Tiger Nixon</td>
                                            <td>04 Apr 2024</td>
                                            <td>06 Apr 2024</td>
                                            <td>07 Apr 2024</td>
                                            <td>Jumlah Cuti</td>
                                            <td>Keperluan Cuti</td>
                                            <td>Status</td>
                                            <td>
                                                <div class="dropdown mb-4">
                                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                                        id="dropdownMenuButton" data-toggle="dropdown" >
                                                        Proses
                                                    </button>
                                                    <div class="dropdown-menu animated--fade-in"
                                                        aria-labelledby="dropdownMenuButton">
                                                        <a class="dropdown-item" href="#">Setujui</a>
                                                        <a class="dropdown-item" href="#">Tidak Disetujui</a>
                                                    </div>
                                                    <button class="btn btn-warning " type="button">
                                                        Print
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
    

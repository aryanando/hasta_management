@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Keuangan</h1>
    {{-- <h5>With great power comes great responsibility!!!.</h5> --}}
    <div class="card my-3 shadow" style="background-color: #9ee8b2;">
        <h5 class="card-header" style="background-color: #c9f1d4;">Info Pembaruan Sistem</h5>
        <div class="card-body">
            <h6 class="card-subtitle mb-2 text-muted">Perbaikan Pada Ubah Jadwal</h6>
            <p class="card-text">Kini ubah data dari dan ke shift Next Day (Malam, Supervisi, Dll) sudah dapat digunakan. Jika ada gangguan silahkan hubungi Admin IT RS Hasta Brata Batu</p>
            <div class="d-flex justify-content-end">
                <p class="small">12/07/2024</p>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
 
    <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Choose Excel File</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
@endsection

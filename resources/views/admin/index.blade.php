@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Admin</h1>
    <h5>With great power comes great responsibility!!!.</h5>
    <div class="row mt-3">
        <div class="col-4">
            <div class="card">
                <h5 class="card-header">Token Absensi</h5>
                <div class="card-body">
                    <h5 class="card-title">QR Code</h5>
                    <p class="card-text">Token absensi berbentuk Quick Response Code (QR) yang unik. Satu QR hanya dapat digunakan
                        sekali dan otomatis diperbarui.</p>
                    <button type="button" class="btn btn-success" onclick="location.href='{{ route('token_page') }}';">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-right" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8">
                            </path>
                        </svg>
                        Buka Halaman Token
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

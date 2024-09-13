<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js', 'resources/sass/app.scss'])
    <title>Print</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {

            body,
            .container {
                width: 210mm;
                /* A4 width */
                height: 297mm;
                /* A4 height */
                margin: 0 auto;
            }

            .container {
                max-width: none !important;
            }

            .bg-white.rounded.mt-3.p-4 {
                box-shadow: none !important;
            }
        }
    </style>
</head>

<body id="allprint">
    <div class="container mt-3">
        <div class="bg-white rounded mt-3 shadow p-4">
            <div class="d-flex align-items-center mb-3">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="me-3"
                    style="height: 100px; width: 100px;">

                <div class="flex-grow-1 text-center">
                    <h1 class="mb-0">Fee Rujuk Masuk</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb-2">
                        <div class="col-3"><strong>Nama Pasien</strong></div>
                        <div class="col-1 text-end">:</div>
                        <div class="col-8">{{ $rujukan->nama_pasien }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><strong>No. Reg Periksa</strong></div>
                        <div class="col-1 text-end">:</div>
                        <div class="col-8">{{ $rujukan->no_reg_periksa }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><strong>Nama Perujuk</strong></div>
                        <div class="col-1 text-end">:</div>
                        <div class="col-8">
                            @if (!empty($rujukan->perujuk_blu))
                                {{ $rujukan->perujuk_blu->name }}
                            @else
                                {{ $rujukan->nama_perujuk}}
                            @endif
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><strong>No. HP</strong></div>
                        <div class="col-1 text-end">:</div>
                        <div class="col-8">{{ $rujukan->no_hp }}</div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-3"><strong>Keterangan</strong></div>
                        <div class="col-1 text-end">:</div>
                        <div class="col-8">{{ $rujukan->keterangan }}</div>
                    </div>
                </div>

                {{-- <div class="col-md-6">
                    <div class="row mb-2">
                        <div class="col-3"><strong>Petugas Kasir</strong></div>
                        <div class="col-1 text-end">:</div>
                        <div class="col-8">{{ $rujukan->petugas_kasir->name ?? 'N/A' }}</div>
                    </div>
                    @if (!is_null($rujukan->petugas_pendaftaran))
                        <div class="row mb-2">
                            <div class="col-3"><strong>Petugas Pendaftaran</strong></div>
                            <div class="col-1 text-end">:</div>
                            <div class="col-8">{{ $rujukan->petugas_pendaftaran->name }}</div>
                        </div>
                    @endif

                    @if (!is_null($rujukan->perujuk_blu))
                        <div class="row mb-2">
                            <div class="col-3"><strong>Perujuk BLU</strong></div>
                            <div class="col-1 text-end">:</div>
                            <div class="col-8">{{ $rujukan->perujuk_blu->name ?? '-' }}</div>
                        </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-3"><strong>Biaya</strong></div>
                        <div class="col-1 text-end">:</div>
                        <div class="col-8">Rp. {{ number_format($rujukan->biaya, 0, ',', '.') }}</div>
                    </div>
                </div> --}}
            </div>
            <div class="d-flex justify-content-around  mb-3" style="height: 125px;">
                <div class="p-2 ">Petugas Pendaftaran</div>
                <div class="p-2 ">Petugas Kasir</div>
            </div>
            <div class="d-flex justify-content-around  mb-3" ">
                <div class="p-2 ">{{ $rujukan->petugas_pendaftaran->name }}</div>
                <div class="p-2 ">
                    {{ $rujukan->petugas_kasir->name ?? '(.............................................)' }}
                </div>
            </div>
        </div>

        {{-- <button id="download" class="btn btn-primary mt-3">Download PDF</button> --}}
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>

@extends('karu.layout.layout')

@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Laporan Rawat Jalan</h1>
    {{-- <h5>With great power comes great responsibility!!!.</h5> --}}

    <table id="rajalDataTable">
        <thead>
            <tr>
                <th colspan=3 class="text-center">Registrasi</th>
                <th colspan=2 class="text-center">Obat</th>
                <th colspan=4 class="text-center">Penunjang</th>
            </tr>
            <tr>
                <th>Tanggal Registrasi</th>
                <th>Nama</th>
                <th>Nama Dokter</th>
                <th>No Resep</th>
                <th>Jumlah</th>
                <th>Laboratorium</th>
                <th>Jumlah</th>
                <th>Radiologi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_rajal as $rajal)
                <tr>
                    <td>{{ $rajal->tgl_registrasi }}</td>
                    <td>{{ $rajal->pasien->nm_pasien }}</td>
                    <td>{{ $rajal->data_dokter->nm_dokter }}</td>
                    <td>
                        @if ($rajal->data_resep_obat)
                            @foreach ($rajal->data_resep_obat as $resep)
                                {{ $resep->no_resep }}<br>
                            @endforeach
                        @else
                            Tidak ada resep obat
                        @endif
                    </td>
                    <td>
                        @php $sumTotal = 0; @endphp

                        @foreach ($rajal->data_pemberian_obat as $hargaresep)
                            {{-- {{ number_format($hargaresep->total, 0, ',', '.') }}<br> --}}
                            @php $sumTotal += $hargaresep->total; @endphp
                        @endforeach

                        <strong>Rp.{{ number_format($sumTotal, 0, ',', '.') }} IDR</strong>
                    </td>
                    <td>
                        @if (!empty($rajal->data_periksa_laboratorium))
                            @foreach ($rajal->data_periksa_laboratorium as $periksalab)
                                {{ $periksalab->data_jenis_perawatan_lab->nm_perawatan }}<br>
                            @endforeach
                        @else
                            Tidak ada pemeriksaan Lab
                        @endif
                    </td>
                    {{-- <td>
                        @php $sumTotalLab = 0; @endphp
                        @if (!empty($rajal->data_periksa_laboratorium))
                            @foreach ($rajal->data_periksa_laboratorium as $periksalab)
                                @if (!empty($periksalab))
                                    @php
                                        $detailPeriksaLab = is_array($periksalab->data_detail_periksa_lab)
                                            ? $periksalab->data_detail_periksa_lab
                                            : [$periksalab->data_detail_periksa_lab];
                                    @endphp
                                    
                                    @foreach ($detailPeriksaLab as $detail)
                                        @if (is_iterable($detail->data_template_laboratorium))
                                            @foreach ($detail->data_template_laboratorium as $biayalab)
                                                @if (is_object($biayalab) && property_exists($biayalab, 'biaya_item'))
                                                    {{ $biayalab->biaya_item }}<br>
                                                    @php $sumTotalLab += $biayalab->biaya_item; @endphp
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            <strong>Rp.{{ number_format($sumTotalLab, 0, ',', '.') }} IDR</strong>
                        @else
                            Tidak ada Lab
                        @endif
                    </td>
                     --}}
                    <td>
                        @if (!empty($rajal->data_periksa_laboratorium))
                            @foreach ($rajal->data_periksa_laboratorium as $periksalab)
                                @if ($periksalab->data_jenis_perawatan_lab->total_byr != 0)
                                    {{ $periksalab->data_jenis_perawatan_lab->total_byr }}<br>
                                    
                                @else
                                    @foreach ($periksalab->data_detail_periksa_lab as $plab)
                                        {{$plab->data_template_laboratorium->biaya_item}}
                                    @endforeach
                                    <hr>
                                @endif
                            @endforeach
                        @else
                            Tidak ada pemeriksaan Lab
                        @endif
                    </td>
                    <td>
                        @if ($rajal->data_periksa_radiologi)
                            @foreach ($rajal->data_periksa_radiologi as $rad)
                                {{ $rad->kd_jenis_prw }}<br>
                            @endforeach
                        @else
                            Tidak ada pemeriksaan Radiologi
                        @endif
                    </td>
                    <td>
                        @php $sumTotalRad = 0; @endphp

                        @foreach ($rajal->data_periksa_radiologi as $hargarad)
                            {{-- {{ number_format($hargaresep->total, 0, ',', '.') }}<br> --}}
                            @php $sumTotalRad += $hargarad->biaya; @endphp
                        @endforeach

                        <strong>Rp.{{ number_format($sumTotalRad, 0, ',', '.') }} IDR</strong>
                    </td>

                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@push('custom-script')
    <script type="module">
        var DataTabless = new DataTables('#rajalDataTable', {
            responsive: true
        });
    </script>
@endpush

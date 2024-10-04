<?php

namespace App\Http\Controllers;

use App\Imports\KeuanganImportClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;

class ExcelImportController extends Controller
{
    public function import(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Process the Excel file
        $data = Excel::toCollection(null, $file);
        $dataFix = [];
        $index = 0;
        foreach ($data[0] as $karyawan) {
            if ($index > 2 and $index < (count($data[0]) - 1)) {
                $dataFix[$index - 3] = [
                    'tahun'         => 2024,
                    'bulan'         => 10,
                    'user_id'       => $karyawan[39],
                    'gaji_pokok'    => $karyawan[17],
                    'bpjs_tk'       => $karyawan[18],
                    'bpjs_4p'       => $karyawan[19],
                    't_keluarga'    => $karyawan[20],
                    'thr'           => $karyawan[21],
                    'jaspel'        => $karyawan[22],
                    'pot_bpjs_tk'   => $karyawan[23],
                    'pot_bpjs_4p'   => $karyawan[24],
                    'pot_bpjs_1p'   => $karyawan[25],
                    'pot_t_keluarga'=> $karyawan[26],
                    'pot_thr'       => $karyawan[27],
                    'pot_s_koperasi'=> $karyawan[28],
                    'pot_yatim_ppni'=> $karyawan[29],
                    'pot_bon'       => $karyawan[30],
                    'pot_jajan_kop' => $karyawan[31],
                    'pot_tagihan_kasir' => $karyawan[32],
                    'pot_cicilan_kop'   => $karyawan[33],
                    'pot_kinerja'   => $karyawan[34],
                    'pot_pph21'     => $karyawan[35],
                    'jumlah_gaji'   => $karyawan[36],
                    'jumlah_potongan'   => $karyawan[37],
                    'jumlah_diterima'   => $karyawan[38],
                ];
            }
            $index++;
        }

        // dd(($data));
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->post(
                env('API_URL') . '/api/v1/slip',
                [
                    'data' => $dataFix,
                ]
            );
        // $data['slip'] = (json_decode($response->body()));
        // return $data['unit'];
        // dd($response->body());


        return redirect()->back()->with('success', 'Excel file imported successfully!');
    }
}

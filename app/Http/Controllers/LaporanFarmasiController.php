<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LaporanFarmasiController extends Controller
{
    //
    public function index()
    {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/laporan/farmasi/harian');
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Admin - Laporan Farmasi',
            'active_page' => 'laporan',
            'active_page_child' => 'laporanFarmasi',
        ];
        $apiData = json_decode($response->body(), true);
        $data['data_farmasi'] = json_decode($response->body(), true)['data'] ?? [];

        // dd($data['data_farmasi']);
        $data['jumlah_tidak_terpakai'] = $apiData['jumlah_tidak_terpakai'] ?? 0;
        $data['jumlah_terpakai'] = $apiData['jumlah_terpakai'] ?? 0;
        $data['tanggal_laporan'] = Carbon::now()->format('Y-m-d');
        return view('admin.page.laporan-farmasi', $data);
    }
}

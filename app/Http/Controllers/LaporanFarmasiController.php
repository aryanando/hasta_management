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
        $data['data_farmasi'] = (json_decode($response->body())->data);
        $data['tanggal_laporan'] = Carbon::now()->format('Y-m-d');
        return view('admin.page.laporan-farmasi', $data);
    }
}

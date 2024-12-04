<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LaporanRajalController extends Controller
{
    public function index() {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/laporan/rajal');
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Admin - Laporan Rajal',
            'active_page' => 'laporan',
            'active_page_child' => 'laporanRawatJalan',
        ];
        $data['data_rajal'] = (json_decode($response->body())->data);
        $data['tanggal_laporan'] = Carbon::now()->format('Y-m-d');
        return view('admin.page.laporan-rajal', $data);
    }
    public function byTanggal($tahun, $bulan, $tanggal) {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/laporan/rajal/bytanggal/'.$tahun.'/'.$bulan.'/'.$tanggal);
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Admin - Laporan Rajal',
            'active_page' => 'laporan',
            'active_page_child' => 'laporanRawatJalan',
        ];
        $data['data_rajal'] = (json_decode($response->body())->data);
        $data['tanggal_laporan'] = $tahun.'-'.$bulan.'-'.$tanggal;
        return view('admin.page.laporan-rajal', $data);
    }
}

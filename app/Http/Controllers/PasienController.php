<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PasienController extends Controller
{
    public function index() {
        $data = array(
            'page_info' => [
                'title' => 'Manage Pasien',
                'active_page' => 'manage-pasien',
                'active_page_child' => 'cari-pasien',
            ],
            'user_data' => session('user_data'),
        );

        return view('admin.page.pasien.index', $data);
    }

    public function operasi($no_rkm_medis) {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/operasi/by-no-rekam-medis/'.$no_rkm_medis);
        $data = array(
            'page_info' => [
                'title' => 'Manage Pasien',
                'active_page' => 'manage-pasien',
                'active_page_child' => 'cari-pasien',
            ],
            'user_data' => session('user_data'),
            'data_pasien' => json_decode($response->body())->data[0],
        );
        // dd($data);
        return view('admin.page.pasien.operasi', $data);
    }
}

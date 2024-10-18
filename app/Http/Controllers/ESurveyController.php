<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ESurveyController extends Controller
{
    public function index() {}

    public function unit($unit_id = NULL)
    {
        if ($unit_id == NULL) {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/esurvey/unit');
        } else {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/esurvey/unit/'.$unit_id);
        }

        $response2 = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/unit');
        $data = array(
            'page_info' => [
                'title' => 'Karu - Esurvey Karyawan',
                'active_page' => 'esurvey',
                'active_page_child' => 'esurvey',
            ],
            'user_data' => session('user_data'),
            'esurvey_unit' => json_decode($response->body())->data->esurvey,
            'units' => json_decode($response2->body())->data->unit
        );


        return view('karu.page.esurvey', $data);
    }

    public function jenisKaryawan($jenis_karyawan_id = NULL)
    {
        if ($jenis_karyawan_id == NULL) {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/esurvey/jenis-karyawan');
        } else {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/esurvey/jenis-karyawan/'.$jenis_karyawan_id);
        }

        $response2 = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/jenis-karyawan');

        $data = array(
            'page_info' => [
                'title' => 'Karu - Esurvey Karyawan',
                'active_page' => 'esurvey',
                'active_page_child' => 'esurvey',
            ],
            'user_data' => session('user_data'),
            'esurvey_unit' => json_decode($response->body())->data->esurvey,
            'jenis_karyawan' => json_decode($response2->body())->data->jenis_karyawan
        );


        return view('karu.page.esurvey-jenis-karyawan', $data);
    }
}

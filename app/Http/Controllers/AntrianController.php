<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AntrianController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();
        $response1 = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/dokter/by-id?kd_dokter='.urlencode($input['kd_dokter']));
        $response2 = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/poliklinik/by-id?kd_poli='.urlencode($input['kd_poli']));
            // dd($response1);
        $data = array(
            'dataDokter' => json_decode($response1->body())->data,
            'dataPoli' => json_decode($response2->body())->data
        );


        return view('karu.page.antrian-poli', $data);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiKaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::acceptJson()->withToken(session('token'))
        ->get(env('API_URL').'/api/v1/absensi-karyawan');
        $absensi['data'] = (json_decode($response->body())->data->absensi_hari_ini);
        return ($absensi);
    }

}

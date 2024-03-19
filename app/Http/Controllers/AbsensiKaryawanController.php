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
        $response = Http::acceptJson()->withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5Yjk3MTYzYi01MjU3LTQwYTEtYTAwOS05Yjc2NGNjZTY3ZTgiLCJqdGkiOiIxZTExNzE0Y2Q2Y2ZkZmRmZmQ5Y2E2NzQ4MDkxNmI4OGY3YWFmM2EyNDg0NjY2NDkxNTUzNmM1MWM1MzcyYjI5OTA0OWI1MzI2YzhmNDRiZCIsImlhdCI6MTcxMDczNTA4MS4yNjE2MDU5NzgwMTIwODQ5NjA5Mzc1LCJuYmYiOjE3MTA3MzUwODEuMjYxNjA3ODg1MzYwNzE3NzczNDM3NSwiZXhwIjoxNzQyMjcxMDgxLjI0ODMxMTk5NjQ1OTk2MDkzNzUsInN1YiI6IjEiLCJzY29wZXMiOltdfQ.l5BGUTox_eTuHT4tRPwi0oWeWg_h_1mW2kxAEDwKSJ5le1NqUQNYqnFJDydqiXhUPve5LXpBBguYmO8lFqwdzaBCwLKDFvRGaZ82G9mqG9vAfHABZZOrHQGrSJXvYDK4Z0GHqU-kYue8lVkIIzCBiOsoGqNKFT44FQXZw1wa1N8BhXC8gVmY15Cd3wJawdBK39Qe2iDDy4_TTKHICi91mQOOld-b7UsdqGz-pvUwl7d9XJS2BUw9a0Z8v5SkyY5Z44F9WnZhNhd0JxkY2cjWEhR27l6gtA81v0rb4Uvs3npyrhBjGtQGhcULv8jNK8d2lOqpPOHvydEzGP7Rs3rSzSyORlo-Xg49wz_DzYFmymiGBm_RGegjpu6j5AI50pwNyVeNjcqsAHpLzFk7DnAv0bwRmoGGYAmTb_cV_v_QdlWWFbpEQSOtbIywktjHNhmoAE3Vt7f3mfH3f0pDtFozHc5fZ3KalB9c7wYfpNAYAl4crJeG0mmT8beKoHOUZpb2N_6ZVZCf5ljyjT0FcgmeiwYZqCNbmuk3BR1s13kqIzWXy8hCthmOnbbqXOyRKBlpm062tL26OnbbhtAL1RznlDt91t8P7AlUvsdcp_PXtIY8a_InLCao62XCrlzjuE4zA5AUPeKYH6bPwVtDH-6wZR0Rendqs5lp1I36xT4D8e4')
        ->get(env('API_URL').'/api/v1/absensi-karyawan');
        $absensi['data'] = (json_decode($response->body())->data->absensi_hari_ini);
        return ($absensi);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

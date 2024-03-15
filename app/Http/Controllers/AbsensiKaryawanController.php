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
        $response = Http::acceptJson()->withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YjU4ZDNhNy02ZDI0LTRhNTEtYjAxMC0zZDQ1Y2I0NzkyMDMiLCJqdGkiOiIzMWQ1YWJjZDdkOTFkMmJkY2VjZjQwN2IwY2YyODkxMzcxYWFlYjRjYWNlZDYwMWYzMzUwNjU3ZDQxOTkyNmIwMjdkMGViM2RmYTVjMzExNSIsImlhdCI6MTcxMDQ2MjcwMy45MjcwNTM5MjgzNzUyNDQxNDA2MjUsIm5iZiI6MTcxMDQ2MjcwMy45MjcwNTYwNzQxNDI0NTYwNTQ2ODc1LCJleHAiOjE3NDE5OTg3MDMuOTE1ODk0MDMxNTI0NjU4MjAzMTI1LCJzdWIiOiI5Iiwic2NvcGVzIjpbXX0.vyWp95zFWU5puqPL8D5OmOWMj_rbtMFg_mgSYwsJSm1kVKpfuyMgvas2hMssVUNdEfKgOIKBTS0zrGHfaTWX59__HZIm_usOeTkEBSWJxRTI__ccp5TRuiRQLJTcX4ZKeqtW-kRTKNLoIktnNnbdTQf6hf73EkhdtgUt9dnXtFSUXQM0c6Ic2r5E0l3B-J2UZH1B8d9zWTpUi-tjgoaExPZhzgSV0PX8pc3cYhCFCPgfvqGVwOpp4PDwO7YNR72_cmDiAtPmjs62MgjgJNGfaM6vyIV2ElwBYiyIPSB0jNftoRJInOTYbjRLFxwYJ_lXrDuSc9Q_E9Zlv1yre7BjWTwgTNI1LQ6m9ohqKDLCZygjMx9K7RftImPSfaWGbPcqXygvEZi_wiwmSKiXegtfmqKiFSwJrYFd2FiVL-58oawHW0AWjF3oVO3yhwNdhPM0q2xVfNfQe8eJ90njpEGHbvGxH2Fun37F-RboOG0yP8E-XYHcFIwRqbeetp-RObo2_UdkkKwGvklk8x3a_RmMSfWF_bJ2fkZF-1CsDR7ZkbemPIIyBOvkJbZK9Mikv113yOG51R-bXsDvxD6ar9yJlH8ryS1xFc3X4ZQnfmaA6UvCXdYbeIgkLMny2_tLihlXlrehWmGiEyF6D6mBfvqJSEGQSLV9e3wVW_ZlDy8m3PQ')
        ->get('http://192.168.5.11:8000/api/v1/absensi-karyawan');
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiToken extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::acceptJson()->withToken(session('token'))
        ->get(env('API_URL').'/api/v1/absensi-token');
        $token_absensi['data'] = (json_decode($response->body())->data[0]);
        return ($token_absensi);
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

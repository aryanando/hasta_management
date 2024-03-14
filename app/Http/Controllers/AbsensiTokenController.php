<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiTokenController extends Controller
{
    public function index() {
        $response = Http::acceptJson()->withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YjU4ZDNhNy02ZDI0LTRhNTEtYjAxMC0zZDQ1Y2I0NzkyMDMiLCJqdGkiOiI0YzY5MjgwZTJmYTIxYWRkOGEwYzljMjM2ODk2MDZlMDU2MzYyYTlmZTVjNWU1YTRkYWI3N2FiOTdmZjk2OGRkNjQ1ZmIxZWRlOGM0ODEyOSIsImlhdCI6MTcxMDM4NzMyOC4zOTA5NTQwMTc2MzkxNjAxNTYyNSwibmJmIjoxNzEwMzg3MzI4LjM5MDk1NTkyNDk4Nzc5Mjk2ODc1LCJleHAiOjE3NDE5MjMzMjguMzgyNjkzMDUyMjkxODcwMTE3MTg3NSwic3ViIjoiOSIsInNjb3BlcyI6W119.MUOCIQgMY01pMc1KfBrlRpW8-P8MCEeBXg_9jGNhGqWcBGX_neU-y3bDKodapqDrn3hwf2SZm-GsAbA7GFWxip9DA14bryq9cd53XJzgLVIHFgvonjnQ6hwxpX5hlYWY4Xrh2GnbIWhPASMfEMtFG6ApzDIiSf05RnVK3PieFt8NEkbaJdU9zH-1HbrS1isz1uAJ1OOJp0n1H1RbJuFgSAaRIV1UzYbwDFaPFHgWKH8R0ISqp8alqXyIPxeTWPJxH8RkAtK0fQUSj7A-B6HSM5sEQ7dNNLuwBupKIC-DIAavR7FJFqlTC8KIYuYyq0HzjfeZDuZcGXDXiAlpe9MMq_jnBfUYL2En7lWfbmcsBTY6hIdOuY-yd9kfDDGkb282cGaCLiFFRUeUm1qrszCtwn2YZ41KKI6BLFMIXSwRJ_inkVCzH3I7JFeqlDbjMkWruV1vMwtx9Kcvf83BotzWg0DLI-eSPXuNTLzNl6S1UnxZA6riSs7GUfh_iFXvJzJASaiku2yBvuhP26lpiIJr5hFnpAT0SDDVPgm8fj5hoXW6RbERuOuXLduJVbm6FlAiBoCLc9ShPAKg_aYBRbp9b85HumLCjC3oqlqSTIVP3tvrI6qtDWBxl7jRf7mUWg9dCEXjpPbWJ-KnHYtfnGqsCPkluqhSlFTD-B72vCAjhI4')
        ->get('http://192.168.1.34:8000/api/v1/absensi-token');
        $token_absensi['data'] = (json_decode($response->body())->data[0]);
        return view('absensi_token', $token_absensi);
    }
}

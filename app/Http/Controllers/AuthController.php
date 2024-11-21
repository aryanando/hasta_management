<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        return view('auth.index');
    }

    public function authenticate(Request $request) {
        $response = Http::acceptJson()->post(env('API_URL') . '/api/v1/login', ['email' => $request->post('email'), 'password' => $request->post('password')]);
        // dd(env('API_URL') . '/api/v1/login');
        $responseData = json_decode($response);
        if ($response->successful()) {
            session(['token' => $responseData->token->token]);
            return redirect('/karu');
        } else {
            Session::flash('message', "Login Failed!!!");
            return redirect('/login');
        }
    }

    public function logout() {
        $response = Http::acceptJson()->withToken(session('token'))->post(env('API_URL') . '/api/v1/logout');
        if ($response->successful()) {
            Session::flush();
            return redirect('/login');
        } else {
            Session::flash('message', "Logout Failed!!!");
            return redirect('/karu');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiTokenController extends Controller
{
    public function index() {
        $data['user_data'] = session('user_data');
        if ($data['user_data']->id != 1) {
            return redirect('/karu');
        }
        return view('absensi_token');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiTokenController extends Controller
{
    public function index() {
        $data['user_data'] = session('user_data');
        if ($data['user_data']->id == 1 || $data['user_data']->id == 9991) {
            return view('absensi_token');
        }
        return redirect('/karu');
    }
}

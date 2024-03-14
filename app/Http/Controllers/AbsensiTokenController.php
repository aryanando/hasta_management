<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiTokenController extends Controller
{
    public function index() {
        return view('absensi_token');
    }
}

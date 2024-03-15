<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AbsensiTokenController extends Controller
{
    public function index() {
        return view('absensi_token');
    }
}

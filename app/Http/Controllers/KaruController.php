<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaruController extends Controller
{
    function index() {
        // dd(session('data_user'));
        $data['user_data'] = session('user_data');
        return view('karu.index', $data);
    }

    function today() {
        return view('karu.page.absensi-hari-ini');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaruController extends Controller
{
    function index() {
        return view('karu.index');
    }

    function today() {
        return view('karu.page.absensi-hari-ini');
    }
}

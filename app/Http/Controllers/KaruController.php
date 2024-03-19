<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KaruController extends Controller
{
    public function index() {
        // dd(session('data_user'));
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Dashboard',
            'active_page' => 'dashboard',
            'active_page_child' => null,
        ];
        return view('karu.index', $data);
    }

    public function today() {
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Absensi Hari Ini',
            'active_page' => 'absensi',
            'active_page_child' => 'today',
        ];
        return view('karu.page.absensi-hari-ini', $data);
    }

    public function logKaryawan() {
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Log Karyawan',
            'active_page' => 'absensi',
            'active_page_child' => 'log_karyawan',
        ];
        return view('karu.page.log-karyawan', $data);
    }
}

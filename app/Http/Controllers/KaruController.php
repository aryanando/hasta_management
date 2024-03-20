<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    public function shift() {
        $response = Http::acceptJson()->withToken(session('token'))
        ->get(env('API_URL').'/api/v1/shift');
        $data['shift'] = (json_decode($response->body())->data->shift);

        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Shift Karyawan',
            'active_page' => 'absensi',
            'active_page_child' => 'shift',
        ];
        return view('karu.page.shift', $data);
    }

    public function jadwal() {
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Jadwal Karyawan',
            'active_page' => 'absensi',
            'active_page_child' => 'jadwal',
        ];
        return view('karu.page.jadwal', $data);
    }

    // Post Contoller For Karu

}

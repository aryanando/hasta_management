<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class KaruController extends Controller
{
    public function index()
    {
        // dd(session('data_user'));
        $data['user_data'] = session('user_data');

        if ($data['user_data']->name == "Administrator") {
            return redirect(url('/admin'));
            # code...
        }
        $data['page_info'] = [
            'title' => 'Karu - Dashboard',
            'active_page' => 'dashboard',
            'active_page_child' => null,
        ];
        return view('karu.index', $data);
    }

    public function today()
    {
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Absensi Hari Ini',
            'active_page' => 'absensi',
            'active_page_child' => 'today',
        ];
        return view('karu.page.absensi-hari-ini', $data);
    }

    public function logKaryawan()
    {
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Log Karyawan',
            'active_page' => 'absensi',
            'active_page_child' => 'log_karyawan',
        ];
        return view('karu.page.log-karyawan', $data);
    }

    public function shift()
    {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/shift');
        $data['shift'] = (json_decode($response->body())->data->shift);

        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Shift Karyawan',
            'active_page' => 'absensi',
            'active_page_child' => 'shift',
        ];
        return view('karu.page.shift', $data);
    }

    public function jadwal()
    {
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Karu - Jadwal Karyawan',
            'active_page' => 'absensi',
            'active_page_child' => 'jadwal',
        ];
        return view('karu.page.jadwal', $data);
    }

    // Post Contoller For Karu

    public function storeShift(Request $request)
    {
        // dd($request->post());
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->post(
                env('API_URL') . '/api/v1/shift',
                [
                    'shift_name' => $request->post('name'),
                    'check_in' => $request->post('check-in'),
                    'check_out' => $request->post('check-out'),
                    'next_day' => $request->post('next-day'),
                    'unit_id' => session('user_data')->unit[0]->id,
                ]
            );
        if ($response->successful()) {
            Session::flash('message', "Data Created!!!");
            return redirect('/karu/shift');
        } else {
            Session::flash('message', "Data Create Failed!!!");
            return redirect('/karu/shift');
        }
    }
}

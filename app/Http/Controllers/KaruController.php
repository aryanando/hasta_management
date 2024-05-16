<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class KaruController extends Controller
{
    public function index()
    {
        // dd(session('data_user'));
        $data['user_data'] = session('user_data');

        if ($data['user_data']->name == "Administrator" || $data['user_data']->name == "ARYANANDO") {
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

    public function jadwal($month = null)
    {
        $data['user_data'] = session('user_data');
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/unit/'.$data['user_data']->unit[0]->id);
        $data['unit'] = (json_decode($response->body())->data->unit);

        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/shift');
        $data['shift'] = (json_decode($response->body())->data->shift);

        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/shift-user/'.$data['user_data']->unit[0]->id.'/'.$month);
        $data['shift_user'] = (json_decode($response->body())->data->shift);
        $dataShiftUserUnit = [];
        foreach ($data['shift_user'] as $shiftUser) {
            $dataShiftUserUnit[$shiftUser->user_id][Carbon::createFromFormat('Y-m-d H:i:s', $shiftUser->valid_date_start)->day] = $shiftUser;
        }
        $data['shift_user'] = $dataShiftUserUnit;

        $data['page_info'] = [
            'title' => 'Karu - Jadwal Karyawan',
            'active_page' => 'absensi',
            'active_page_child' => 'jadwal',
        ];

        $data['month'] = $month;
        // dd($data);
        return view('karu.page.jadwal', $data);
    }

    // Post Contoller For Karu

    public function storeShift(Request $request)
    {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->post(
                env('API_URL') . '/api/v1/shift',
                [
                    'shift_name' => $request->post('name'),
                    'check_in' => $request->post('check-in'),
                    'check_out' => $request->post('check-out'),
                    'color' => $request->post('color'),
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

    public function storeUserShift(Request $request)
    {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->post(
                env('API_URL') . '/api/v1/shift-user',
                [
                    'valid_date_start' => $request->post('valid_date_start'),
                    'valid_date_end' => $request->post('valid_date_end'),
                    'shift_id' => $request->post('shift_id'),
                    'user_id' => $request->post('user_id'),
                    'last_shift_id' => $request->post('last_shift_id'),
                ]
            );
        if ($response->successful()) {
            return $response;
        } else {
            return $response;
        }
    }

    public function deleteUserShift(Request $request) {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->delete(
                env('API_URL') . '/api/v1/shift-user',
                [
                    'valid_date_start' => $request->post('valid_date_start'),
                    'valid_date_end' => $request->post('valid_date_end'),
                    'shift_id' => $request->post('shift_id'),
                    'user_id' => $request->post('user_id'),
                ]
            );
        if ($response->successful()) {
            return $response;
        } else {
            return $response;
        }
    }

}

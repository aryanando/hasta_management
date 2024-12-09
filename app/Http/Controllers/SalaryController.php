<?php

namespace App\Http\Controllers;

use App\Imports\KeuanganImportClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Http;

class SalaryController extends Controller
{
    //
    public function index()
    {
        // dd(session('data_user'));
        $data['user_data'] = session('user_data');

        if (!in_array($data['user_data']->id,  [1, 109])) {
            return redirect(url('/karu'));
        }

        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/slips');

        $data = array(
            'page_info' => [
                'title' => 'Keuangan - Dashboard',
                'active_page' => 'keuangan',
                'active_page_child' => 'keuangan',
                'small_tittle' => 'Keuangan',
            ],
            'dataPenghasilan' => json_decode($response)->data,
            'user_data' => session('user_data'),
        );

        return view('karu.page.slip-gaji', $data);
    }

    public function baru()
    {
        $data['user_data'] = session('user_data');

        if (!in_array($data['user_data']->id,  [1, 109])) {
            return redirect(url('/karu'));
        }

        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/slips');

        $data = array(
            'page_info' => [
                'title' => 'Keuangan - Dashboard',
                'active_page' => 'keuangan',
                'active_page_child' => 'keuangan',
                'small_tittle' => 'Keuangan',
            ],
            'dataPenghasilan' => json_decode($response)->data,
            'user_data' => session('user_data'),
        );

        return view('karu.page.slip-gaji-baru', $data);
    }

    public function activateBaru()
    {
        $data['user_data'] = session('user_data');

        if (!in_array($data['user_data']->id,  [1, 109])) {
            return redirect(url('/karu'));
        }

        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/slips/activate');

        $data = array(
            'page_info' => [
                'title' => 'Keuangan - Dashboard',
                'active_page' => 'keuangan',
                'active_page_child' => 'keuangan',
                'small_tittle' => 'Keuangan',
            ],
            'user_data' => session('user_data'),
        );

        return redirect()->route('data-slip-gaji')->with('message', 'Data baru telah diaktifkan');
    }
}

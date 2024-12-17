<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index()
    {
        // dd(session('data_user'));
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Admin - Dashboard',
            'active_page' => 'dashboard',
            'active_page_child' => null,
        ];
        return view('admin.index', $data);
    }

    public function unit()
    {
        // dd(session('data_user'));
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/unit');
        $data['unit'] = (json_decode($response->body())->data->unit);
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Admin - Unit',
            'active_page' => 'manage-karyawan',
            'active_page_child' => 'unit',
        ];
        return view('admin.page.unit', $data);
    }

    public function unitDetail($id)
    {
        // dd(session('data_user'));
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/unit/' . $id);
        $data['unit'] = (json_decode($response->body())->data->unit);
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Admin - Unit',
            'active_page' => 'manage-karyawan',
            'active_page_child' => 'unit',
        ];
        return view('admin.page.unit-detail', $data);
    }

    public function unitDetailAdd(Request $request, $id)
    {
        // dd(session('data_user'));
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->post(
                env('API_URL') . '/api/v1/unit',
                [
                    'user_id' => $request->post('user_id'),
                    'unit_id' => $id,
                ]
            );
        $data['unit'] = (json_decode($response->body()));
        // $data['unit'] = json_encode($request->all());
        return $data['unit'];
    }

    public function users($id = null)
    {
        if ($id !== NULL) {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/admin/users/' . $id);
            $response2 = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/user-statistic/' . $id);

            $jamMasuk = new Carbon(json_decode($response->body())->data->users->shifts[0]->check_in);
            $batasJamMasuk = new Carbon(json_decode($response->body())->data->users->shifts[0]->shifts->check_in);
            $data = array(
                'users' => json_decode($response->body())->data->users,
                'user_statistics' => json_decode($response2->body())->data,
                'page_info' => array(
                    'title' => 'Admin - ' . json_decode($response->body())->data->users->name,
                    'active_page' => 'admin',
                    'active_page_child' => 'user',
                ),
                'user_data' => session('user_data'),
                'terlambat_hari_ini' => $jamMasuk->diffInMinutes($batasJamMasuk),
            );
            // dd($jamMasuk);

            return view('admin.page.user-detail', $data);
        } else {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/admin/users');

            $data = array(
                'users' => json_decode($response->body())->data->users,
                'page_info' => array(
                    'title' => 'Admin - Unit',
                    'active_page' => 'admin',
                    'active_page_child' => 'user',
                ),
                'user_data' => session('user_data'),
            );

            return view('admin.page.users', $data);
        }
    }

    // API Autocomplete Select
    public function karyawan($filter)
    {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/karyawan');
        $dataKaryawan = json_decode($response->body())->data->karyawan;
        // return $dataKaryawan;
        if ($filter == 'noUnit') {
            foreach ($dataKaryawan as $karyawan) {
                if (count($karyawan->unit) == 0) {
                    $data[] = array("label" => $karyawan->name, "value" => $karyawan->name, "id" => $karyawan->id);
                }
            }
            return $data;
        }
    }
}

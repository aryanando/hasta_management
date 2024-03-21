<?php

namespace App\Http\Controllers;

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
}

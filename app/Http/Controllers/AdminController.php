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

    // API Autocomplete Select
    public function karyawan($filter)
    {
        $response = Http::acceptJson()
            ->withToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5YmJiNDYxMi1jZDRiLTQ4NzQtYmMyMy01Y2JkZDMyZjdhMzQiLCJqdGkiOiI0NzFlZjQwNDEzMmY3YjNjYTRhMjhjOTM5MjFlN2UzM2JmNGI2YmE1Njg0M2ZjMjE5MjM2NjRiNjk5NjUyODZmYTk3MDA3ZmQ1ODYyY2YwMiIsImlhdCI6MTcxMzc1OTEwNi45MTkxMDksIm5iZiI6MTcxMzc1OTEwNi45MTkxMTMsImV4cCI6MTc0NTI5NTEwNi45MTA2OTksInN1YiI6IjEiLCJzY29wZXMiOltdfQ.fP-yMU28fS70aLdLdhm54OxOjdfoToJva-y2pjelbG-Mnr6_RXqgEo-ST4J8zDnbZI7VBMs70Ja3xUxXQZB6Pquf8Hm9i_otstyYak5xizQ_aTaljSROJ2AY1l4O9yX0GRyEXaNt855qa3iAmghhSv9URG7FDNHpkC0Pbi-GWjckCZOzoNWz5kWsmyHZi975fJEKb8-ByHwJrLG14cKI9tXixxIusj2D5V33zNNQ0NceXamNjvZCZak665xYUcqlM1RL1WMV3DUxk_lFHwIISCoLx6kJnjNyEj7Yp0prtNRpN-WqvkS6NhGCphhJwo3UwbrPnV-igXSjSoiykc90TqVllFnMw4XU1tsFO1q-5C85o3ngrf4b8Olh0mCCgQ6aq6LtC57T9-RkaYzgS926Sgt2uTlX7w_VchtSTjLxuSB3Ihl_85gckMvoTPH-WjEqv7r0395yx4Ky8xshDYu7JVTSLxdivkohaWKIVJR-pEG1JbqVVaOSIXPyi-_MyfBOq19UIsAUrsxFvxztz9Z0a_pvswY01dp1ZrUeL0oAcXcxlhvs518U4EgC-ReMpQ6FTf1k9BRI3SimFoApVQ3A1U30r3MHVNBWp_hdllFz4EN_6kJXCC6o2K3Jx5wvbzE4sPbjmoJVMoEWyz8JIhdrcxU9WIa1bKP3eGMorpnE9jU')
            ->get(env('API_URL') . '/api/v1/karyawan/');
        $dataKaryawan = json_decode($response->body());
        dd($dataKaryawan);
        if ($filter == 'noUnit') {
            foreach ($dataKaryawan as $karyawan) {
                if (count($karyawan->unit)==0) {
                    $data[] = array("label" => $karyawan->name, "value"=> $karyawan->name, "id"=>$karyawan->id);
                }
            }
            return $data;
        }
    }
}

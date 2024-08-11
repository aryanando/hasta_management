<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClaimRujukanController extends Controller
{
    //
    public function index() {
        $data['user_data'] = session('user_data');
        // dd($data['user_data']->unit[0]->unit_name);
        if ($data['user_data']->name == "Administrator" || $data['user_data']->name == "ARYANANDO") {
            return redirect(url('/admin'));
            # code...
        }

        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/rujukan');
        $data['rujukan'] = (json_decode($response->body())->data);

        $data['page_info'] = [
            'title' => $data['user_data']->unit[0]->unit_name.' - Klaim Rujukan',
            'active_page' => 'klaim-rujukan',
            'active_page_child' => null,
        ];
        return view('karu.page.klaim-rujukan', $data);
    }

    public function print($id) {
        $data['user_data'] = session('user_data');
        // dd($data['user_data']->unit[0]->unit_name);
        if ($data['user_data']->name == "Administrator" || $data['user_data']->name == "ARYANANDO") {
            return redirect(url('/admin'));
            # code...
        }

        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/rujukan/'.$id);
        $data['rujukan'] = (json_decode($response->body())->data);

        $data['page_info'] = [
            'title' => $data['user_data']->unit[0]->unit_name.' - Klaim Rujukan',
            'active_page' => 'klaim-rujukan',
            'active_page_child' => null,
        ];
        return view('karu.page.print-klaim-rujukan', $data);

    }
}

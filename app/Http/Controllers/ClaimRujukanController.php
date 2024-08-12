<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClaimRujukanController extends Controller
{
    public function index() {
        $data['user_data'] = session('user_data');

        if ($data['user_data']->name == "Administrator" || $data['user_data']->name == "ARYANANDO") {
            return redirect(url('/admin'));
        }

        if ($data['user_data']->unit[0]->unit_name == 'RM' || $data['user_data']->unit[0]->unit_name == 'KASIR' ) {
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
        }else{
            return redirect()->back()->with('message', 'Anda Tidak Memiliki Akses!!!');
        }


    }

    public function print($id) {
        $data['user_data'] = session('user_data');
        if ($data['user_data']->name == "Administrator" || $data['user_data']->name == "ARYANANDO") {
            return redirect(url('/admin'));
        }

        if ($data['user_data']->unit[0]->unit_name == 'RM' || $data['user_data']->unit[0]->unit_name == 'KASIR' ) {
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
        }else{
            return redirect()->back()->with('message', 'Anda Tidak Memiliki Akses!!!');
        }


    }
}

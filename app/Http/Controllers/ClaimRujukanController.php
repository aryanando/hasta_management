<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClaimRujukanController extends Controller
{
    public function index()
    {
        $data['user_data'] = session('user_data');

        if ($data['user_data']->name == "ARYANANDO") {
            return redirect(url('/admin'));
        }

        if (count($data['user_data']->unit) > 0) {
            if ($data['user_data']->unit[0]->unit_name == 'RM' || $data['user_data']->unit[0]->unit_name == 'KASIR' || $data['user_data']->name == "ARYANANDO" || $data['user_data']->name == "GANDI ARI SETIOKO,Amd.Kep ") {
                $response = Http::acceptJson()
                    ->withToken(session('token'))
                    ->get(env('API_URL') . '/api/v1/rujukan');
                $data['rujukan'] = (json_decode($response->body())->data);

                $data['page_info'] = [
                    'title' => $data['user_data']->unit[0]->unit_name . ' - Klaim Rujukan',
                    'active_page' => 'klaim-rujukan',
                    'active_page_child' => 'klaim-rujukan',
                ];
                return view('karu.page.klaim-rujukan', $data);
            } else {
                return redirect()->back()->with('message', 'Anda Tidak Memiliki Akses!!!');
            }
        } elseif ($data['user_data']->id == 1) {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/rujukan');
            $data['rujukan'] = (json_decode($response->body())->data);

            $data['page_info'] = [
                'title' => 'Admin - Klaim Rujukan',
                'active_page' => 'klaim-rujukan',
                'active_page_child' => 'klaim-rujukan',
            ];
            return view('karu.page.klaim-rujukan', $data);
        } else {
            return redirect()->back()->with('message', 'Anda Tidak Memiliki Akses!!!');
        }
    }

    public function print($id)
    {
        $data['user_data'] = session('user_data');
        if ($data['user_data']->name == "ARYANANDO") {
            return redirect(url('/admin'));
        }

        if ($data['user_data']->unit[0]->unit_name == 'RM' || $data['user_data']->unit[0]->unit_name == 'KASIR' || $data['user_data']->name == "ARYANANDO" || $data['user_data']->name == "GANDI ARI SETIOKO,Amd.Kep ") {
            $response = Http::acceptJson()
                ->withToken(session('token'))
                ->get(env('API_URL') . '/api/v1/rujukan/' . $id);
            $data['rujukan'] = (json_decode($response->body())->data);

            $data['page_info'] = [
                'title' => count($data['user_data']->unit) > 0 ? $data['user_data']->unit[0]->unit_name . ' - Klaim Rujukan' : 'Administrator Klaim Rujukan',
                'active_page' => 'klaim-rujukan',
                'active_page_child' => null,
            ];
            return view('karu.page.print-klaim-rujukan', $data);
        } else {
            return redirect()->back()->with('message', 'Anda Tidak Memiliki Akses!!!');
        }
    }

    public function verif($id)
    {
        $data['user_data'] = session('user_data');
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->put(env('API_URL') . '/api/v1/rujukan/' . $id, [
                'petugas_kasir' => $data['user_data']->id,
            ]);
        return redirect()->back();
    }

    public function detailDataRujukan()
    {
        $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => count($data['user_data']->unit) > 0 ? $data['user_data']->unit[0]->unit_name . ' - Klaim Rujukan' : 'Administrator Klaim Rujukan',
            'active_page' => 'klaim-rujukan',
            'active_page_child' => 'data-klaim-rujukan',
        ];
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/rujukan-detail');
        $data['rujukan'] = (json_decode($response->body())->data);

        return view('karu.page.detail-klaim-rujukan', $data);
        // dd($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Imports\KeuanganImportClass;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SalaryController extends Controller
{
    //
    public function index() {
        // dd(session('data_user'));
        $data['user_data'] = session('user_data');

        if ($data['user_data']->name == "Administrator" || $data['user_data']->name == "ARYANANDO") {
            return redirect(url('/admin'));
            # code...
        }

        $data['page_info'] = [
            'title' => 'Keuangan - Dashboard',
            'active_page' => 'dashboard',
            'active_page_child' => null,
            'small_tittle' => 'Keuangan',
        ];
        return view('karu.page.slip-gaji', $data);
    }

}

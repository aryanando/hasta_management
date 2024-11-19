<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index() {
        $data = array(
            'page_info' => [
                'title' => 'Manage Pasien',
                'active_page' => 'manage-pasien',
                'active_page_child' => 'cari-pasien',
            ],
            'user_data' => session('user_data'),
        );

        return view('admin.page.pasien.index', $data);
    }
}

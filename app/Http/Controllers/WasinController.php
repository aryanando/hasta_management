<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use DB;

class WasinController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m')); // Default to the current month if not provided
        $day = $request->input('day', date('d')); // Default to the current day if not provided
    
        $data['page_info'] = [
            'title' => 'Wasin - Dashboard',
            'active_page' => 'dashboard',
            'active_page_child' => null,
        ];
    
        $data['datachart'] = DB::table('absens as absen')
            ->select(DB::raw('DATE(absen.check_in) AS checkin_date'), DB::raw('COUNT(absen.check_in) AS total_checkins'))
            ->join('users as us', 'us.id', '=', 'absen.user_id')
            ->whereRaw('MONTH(absen.check_in) = ?', [$month])
            ->groupBy('checkin_date')
            ->get();
    
        $data['absen_shift'] = DB::table('absens as absen')
            ->select(
                DB::raw('DATE(absen.check_in) AS checkin_date'),
                DB::raw('COUNT(absen.check_in) AS total_checkins'),
                DB::raw("
                    CASE 
                        WHEN sf.shift_name LIKE '%Pagi%' OR sf.shift_name LIKE '%Nol%' OR sf.shift_name LIKE '%non%' THEN 'Nol + Pagi'
                        WHEN sf.shift_name LIKE '%Mid%' THEN 'Middle'
                        WHEN sf.shift_name LIKE '%Siang%' OR sf.shift_name LIKE '%Sore%' THEN 'Siang + Sore'
                        WHEN sf.shift_name LIKE '%Malam%' THEN 'Malam'
                        WHEN sf.shift_name LIKE '%OC%' THEN 'ON CALL (OK)'
                        WHEN sf.shift_name LIKE '%Cadangan%' THEN 'Driver Cadangan'
                        WHEN sf.shift_name LIKE '%Supervisi%' OR sf.shift_name LIKE '%Wasdal%' OR sf.shift_name LIKE '%SP%' THEN 'Wasdal + Supervisi'
                        ELSE 'other'
                    END AS shift_category")
            )
            ->join('users as us', 'us.id', '=', 'absen.user_id')
            ->join('shifts as sf', 'sf.id', '=', 'absen.shift_id')
            ->whereRaw('MONTH(absen.check_in) = ? AND DAY(absen.check_in) = ?', [$month, $day])
            ->groupBy('checkin_date', 'shift_category')
            ->orderBy('checkin_date')
            ->orderBy(DB::raw("FIELD(shift_category, 'Nol + Pagi', 'Middle', 'Siang + Sore', 'Malam', 'ON CALL (OK)', 'Driver Cadangan', 'Wasdal + Supervisi', 'other')"))
            ->get();
    
        $data['total_absen'] = $data['absen_shift']->sum('total_checkins');
    
        return view('wasin.index', $data);
    }
    
    

    public function laporan_cuti()
    {
        $response = Http::acceptJson()
            ->withToken(session('token'))
            ->get(env('API_URL') . '/api/v1/unit');

        if ($response->successful()) {
            $responseData = json_decode($response->body());

            if (isset($responseData->data)) {
                $data['unit'] = $responseData->data->unit;
            } else {
                // Handle case where 'data' property is missing in the response
                // Log an error, throw an exception, or handle it based on your application's requirements
                $errorMessage = 'Data property is missing in the API response.';
                session()->flash('error', $errorMessage);
                return back();
            }


            $data['page_info'] = [
                'title' => 'Wasin - Cuti',
                'active_page' => 'laporan',
                'active_page_child' => 'cuti',
            ];

            dd($data);
            return view('wasin.page.cuti', $data);
        } else {
            // Handle the case where the API request was unsuccessful
            $errorMessage = 'API request failed with status code: ' . $response->status();
            // Log the error message or handle it based on your application's requirements
            // You might want to redirect the user back with a flash message or display a specific error view
        }

    }
    public function laporan_izin()
    {
        // dd(session('data_user'));
        // $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Wasin - Izin',
            'active_page' => 'laporan',
            'active_page_child' => 'izin',
        ];
        // dd($data);
        return view('wasin.page.izin', $data);
    }

    public function absensi_harian()
    {
        $data['page_info'] = [
            'title' => 'Wasin - Absensi Harian',
            'active_page' => 'laporan',
            'active_page_child' => 'harian',
        ];
        $data['datatable'] = DB::table('users')
            ->select('users.id', 'users.name', 'ut.unit_name as unit')
            ->join('user_units as usnit', 'usnit.user_id', '=', 'users.id')
            ->join('unit_translations as ut', 'ut.id', '=', 'usnit.unit_id')
            ->get();

        $user = DB::table('users')
            ->select('users.id', 'users.name', 'ut.unit_name as unit')
            ->join('user_units as usnit', 'usnit.user_id', '=', 'users.id')
            ->join('unit_translations as ut', 'ut.id', '=', 'usnit.unit_id')
            ->get();

        $absen = DB::select("
            SELECT
                abse.check_in,abse.check_out,abse.user_id
            FROM
                absens AS abse
            WHERE
            MONTH(abse.check_in)= month(now())
            and abse.user_id = :user_id
            ", ['user_id' => $user[0]->id]);
        $data['absen'] = empty($absen) ? null : $absen;

        $data['hari'] = date("d");
        $data['tahun'] = date("Y");
        $data['jumlahhari'] = date("t", mktime(0, 0, 0, date("m"), 1, date("Y")));
        $data['s'] = date("w", mktime(0, 0, 0, date("m"), 1, date("Y")));
        // dd($data);
        return view('wasin.page.harian', $data);
    }

    public function absensi_laporan()
    {
        // dd(session('data_user'));
        // $data['user_data'] = session('user_data');
        $data['page_info'] = [
            'title' => 'Wasin - Absensi Laporan',
            'active_page' => 'laporan',
            'active_page_child' => 'absensi',
        ];
        // dd($data);
        return view('wasin.page.laporan', $data);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Exports\AttendanceExport;
use App\Exports\BulananExport;
use App\Exports\AbsensiExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;



class WasinController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', date('m')); // Default Bulan
        $day = $request->input('day', date('d')); // Default Hari

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
            // ->groupBy('absen.user_id')
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

    // Harian
    public function absensi_harian(Request $request)
    {
        $data['page_info'] = [
            'title' => 'Wasin - Harian',
            'active_page' => 'laporan',
            'active_page_child' => 'harian',
        ];

        $selectedUnit = $request->input('unit');
        $selectedDate = $request->input('date', date('Y-m-d'));

        // Fetch all relevant users along with their units and shifts
        $datatable = DB::table('users')
            ->select('users.id', 'users.name', 'ut.unit_name as unit')
            ->join('user_units as usnit', 'usnit.user_id', '=', 'users.id')
            ->join('unit_translations as ut', 'ut.id', '=', 'usnit.unit_id')
            ->leftJoin('user_shifts as sf', 'sf.user_id', '=', 'users.id')
            ->whereRaw('DATE(sf.valid_date_start) = ?', [$selectedDate])
            ->when($selectedUnit, function ($query, $selectedUnit) {
                return $query->where('usnit.unit_id', $selectedUnit);
            })
            ->groupBy('users.id', 'users.name', 'ut.unit_name')
            ->get();

        $units = DB::table('unit_translations')
            ->select('id', 'unit_name', 'unit_leader_id')
            ->get();

        // Fetch attendance data, including shifts for users who have checked in
        $absensi = DB::table('absens as abse')
            ->select(
                'abse.user_id',
                DB::raw('TIME(abse.check_in) as masuk'),
                DB::raw('TIME(abse.check_out) as pulang'),
                'sf.shift_name',
                DB::raw('TIME(sf.check_in) as sfmasuk'),
                DB::raw('TIMEDIFF(TIME(abse.check_in), TIME(sf.check_in)) AS difference'),
                DB::raw("CASE 
                    WHEN TIME(abse.check_in) > ADDTIME(TIME(sf.check_in), '00:15:00') THEN 'Telat'
                    ELSE 'Tepat Waktu'
                END AS status")
            )
            ->join('shifts as sf', 'sf.id', '=', 'abse.shift_id')
            ->join('users as u', 'u.id', '=', 'abse.user_id')
            ->whereRaw('DATE(abse.check_in) = ?', [$selectedDate])
            ->when($selectedUnit, function ($query, $selectedUnit) {
                return $query->whereIn('u.id', function ($subquery) use ($selectedUnit) {
                    $subquery->select('user_id')
                        ->from('user_units')
                        ->where('unit_id', $selectedUnit);
                });
            })
            ->get();

        // Add shifts data to the absensi if users have not checked in
        $shifts = DB::table('user_shifts as sf')
            ->select('sf.user_id', 'shi.shift_name', DB::raw('TIME(sf.valid_date_start) as sfmasuk'))
            ->join('shifts as shi', 'shi.id', '=', 'sf.shift_id')
            ->leftJoin('users as u', 'u.id', '=', 'sf.user_id')
            ->whereRaw('DATE(sf.valid_date_start) = ?', [$selectedDate])
            ->when($selectedUnit, function ($query, $selectedUnit) {
                return $query->whereIn('sf.user_id', function ($subquery) use ($selectedUnit) {
                    $subquery->select('user_id')
                        ->from('user_units')
                        ->where('unit_id', $selectedUnit);
                });
            })
            ->get();

        // Merge the attendance data with shift data if user didn't check in
        $absensi = $absensi->merge($shifts->map(function ($shift) {
            return (object) [
                'user_id' => $shift->user_id,
                'shift_name' => $shift->shift_name,
                'sfmasuk' => $shift->sfmasuk,
                'masuk' => null,
                'pulang' => null,
                'difference' => null,
                'status' => 'Belum Absen'
            ];
        })->all());

        if ($request->ajax()) {
            return response()->json([
                'datatable' => $datatable,
                'absensi' => $absensi,
            ]);
        }

        return view('wasin.page.harian', compact('datatable', 'units', 'absensi'), $data);
    }

    public function exportHarian(Request $request)
    {
        $selectedUnit = $request->input('unit');
        $selectedDate = $request->input('date', date('Y-m-d'));
        return Excel::download(new AbsensiExport($selectedUnit, $selectedDate), 'absensi_report.xlsx');
    }


    public function absensi_laporan(Request $request)
    {
        $month = $request->input('month', date('m'));
        $selectedMonth = $month;

        $data['page_info'] = [
            'title' => 'Wasin - Absensi Laporan',
            'active_page' => 'laporan',
            'active_page_child' => 'absensi',
        ];

        $data['datatable'] = DB::table('users')
            ->select('users.id', 'users.name', 'ut.unit_name as unit')
            ->join('user_units as usnit', 'usnit.user_id', '=', 'users.id')
            ->join('unit_translations as ut', 'ut.id', '=', 'usnit.unit_id')
            ->get();

        $absen = DB::table('absens')
            ->select(
                'absens.check_in',
                'absens.check_out',
                'absens.user_id',
                'sf.next_day',
                'sf.check_in as shift_check_in',
                'sf.check_out as shift_check_out',
                DB::raw("CASE 
                        WHEN TIME(absens.check_in) > ADDTIME(TIME(sf.check_in), '00:15:00') THEN 'Telat'
                        ELSE 'Tepat Waktu'
                END AS status")
            )
            ->join('shifts as sf', 'sf.id', '=', 'absens.shift_id')
            ->whereMonth('absens.check_in', '=', $month)
            ->orWhereMonth('absens.check_out', '=', $month)
            ->get();

        $groupedAbsen = [];
        foreach ($absen as $att) {
            $userId = $att->user_id;
            if (!isset($groupedAbsen[$userId])) {
                $groupedAbsen[$userId] = ['telat_count' => 0];
            }
            $dateIn = date('Y-m-d', strtotime($att->check_in));
            $dateOut = date('Y-m-d', strtotime($att->check_out));

            $groupedAbsen[$userId][$dateIn]['check_in'] = $att->check_in;
            $groupedAbsen[$userId][$dateIn]['status'] = $att->status;

            if ($att->status === 'Telat') {
                $groupedAbsen[$userId]['telat_count']++;
            }

            if ($att->next_day) {
                $dateOutPrevDay = date('Y-m-d', strtotime('-1 day', strtotime($dateOut)));
                $groupedAbsen[$userId][$dateOutPrevDay]['check_out'] = $att->check_out;
            } else {
                $groupedAbsen[$userId][$dateOut]['check_out'] = $att->check_out;
            }
        }

        $data['absen'] = $groupedAbsen;
        $data['jumlahhari'] = date("t");
        $data['selectedMonth'] = $selectedMonth;

        if ($request->ajax()) {
            return response()->json([
                'datatable' => $data['datatable'],
                'absen' => $data['absen'],
                'jumlahhari' => $data['jumlahhari']
            ]);
        }

        if ($request->has('export')) {
            return Excel::download(new AttendanceExport($data['datatable'], $data['absen'], $data['jumlahhari']), 'attendance.xlsx');
        }

        return view('wasin.page.laporan', $data);
    }



    public function exportLaporan(Request $request)
    {
        $data['page_info'] = [
            'title' => 'Wasin - Absensi Export',
            'active_page' => 'laporan',
            'active_page_child' => 'absensi',
        ];
    
        $month = $request->input('month', date('Y-m'));
        $selectedMonth = $month;
    
        \Log::info('Selected month: ' . $month);
    
        $data['datatable'] = DB::table('users')
            ->select('users.id', 'users.name', 'ut.unit_name as unit')
            ->join('user_units as usnit', 'usnit.user_id', '=', 'users.id')
            ->join('unit_translations as ut', 'ut.id', '=', 'usnit.unit_id')
            ->get();
    
        $absen = DB::table('absens')
            ->select(
                'absens.check_in',
                'absens.check_out',
                'absens.user_id',
                'sf.next_day',
                'sf.check_in as shift_check_in',
                'sf.check_out as shift_check_out',
                DB::raw("CASE 
                        WHEN TIME(absens.check_in) > ADDTIME(TIME(sf.check_in), '00:15:00') THEN 'Telat'
                        ELSE 'Tepat Waktu'
                END AS status")
            )
            ->join('shifts as sf', 'sf.id', '=', 'absens.shift_id')
            ->where(function($query) use ($month) {
                $query->whereMonth('absens.check_in', '=', date('m', strtotime($month)))
                      ->whereYear('absens.check_in', '=', date('Y', strtotime($month)))
                      ->orWhere(function($query) use ($month) {
                          $query->whereMonth('absens.check_out', '=', date('m', strtotime($month)))
                                ->whereYear('absens.check_out', '=', date('Y', strtotime($month)));
                      });
            })
            ->get();
    
        $groupedAbsen = [];
        foreach ($absen as $att) {
            $userId = $att->user_id;
            if (!isset($groupedAbsen[$userId])) {
                $groupedAbsen[$userId] = ['telat_count' => 0];
            }
            $dateIn = date('Y-m-d', strtotime($att->check_in));
            $dateOut = date('Y-m-d', strtotime($att->check_out));
    
            $groupedAbsen[$userId][$dateIn]['check_in'] = $att->check_in;
            $groupedAbsen[$userId][$dateIn]['status'] = $att->status;
    
            if ($att->status === 'Telat') {
                $groupedAbsen[$userId]['telat_count']++;
            }
    
            if ($att->next_day) {
                $dateOutPrevDay = date('Y-m-d', strtotime('-1 day', strtotime($dateOut)));
                $groupedAbsen[$userId][$dateOutPrevDay]['check_out'] = $att->check_out;
            } else {
                $groupedAbsen[$userId][$dateOut]['check_out'] = $att->check_out;
            }
        }
    
        $data['absen'] = $groupedAbsen;
        $data['jumlahhari'] = date("t", strtotime($month . '-01'));
        $data['selectedMonth'] = $selectedMonth;
    
        return view('wasin.page.export', $data);
    }
    
    


}
<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AbsensiExport implements FromCollection, WithHeadings
{
    protected $selectedUnit;
    protected $selectedDate;

    public function __construct($selectedUnit, $selectedDate)
    {
        $this->selectedUnit = $selectedUnit;
        $this->selectedDate = $selectedDate;
    }

    public function collection()
    {
        // Fetch user data with unit and shift information
        $query = DB::table('users')
            ->select('users.id', 'users.name', 'ut.unit_name as unit')
            ->join('user_units as usnit', 'usnit.user_id', '=', 'users.id')
            ->join('unit_translations as ut', 'ut.id', '=', 'usnit.unit_id')
            ->join('user_shifts as sf', 'sf.user_id', '=', 'users.id')
            ->whereRaw('DATE(sf.valid_date_start) = ?', [$this->selectedDate])
            ->when($this->selectedUnit, function ($query, $selectedUnit) {
                return $query->where('usnit.unit_id', $selectedUnit);
            })
            ->groupBy('users.id', 'users.name', 'ut.unit_name')
            ->get();

        $comparisonDate = Carbon::createFromFormat('Y-m-d', '2024-08-06');
        if (Carbon::parse($this->selectedDate)->lt($comparisonDate)) {
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
                ->whereRaw('DATE(abse.check_in) = ?', [$this->selectedDate])
                ->when($this->selectedUnit, function ($query, $selectedUnit) {
                    return $query->whereIn('u.id', function ($subquery) use ($selectedUnit) {
                        $subquery->select('user_id')
                            ->from('user_units')
                            ->where('unit_id', $selectedUnit);
                    });
                })
                ->get();
        } else {
            $absensi = DB::table('users as us')
                ->select(
                    'usif.user_id',
                    DB::raw('time(usif.check_in) AS masuk'),
                    DB::raw('time(usif.check_out) AS pulang'),
                    'sf.shift_name',
                    DB::raw('TIME(sf.check_in) AS sfmasuk'),
                    DB::raw('TIMEDIFF(TIME(sf.check_in), TIME(usif.check_in)) AS difference'),
                    DB::raw("CASE 
                                WHEN TIME(usif.check_in) > ADDTIME(TIME(sf.check_in), '00:05:00') THEN 'Telat'
                                ELSE 'Tepat Waktu'
                            END AS status")
                )
                ->join('user_shifts AS usif', 'us.id', '=', 'usif.user_id')
                ->join('shifts as sf', 'sf.id', '=', 'usif.shift_id')
                ->whereRaw('DATE(usif.check_in) = ?', [$this->selectedDate])
                ->when($this->selectedUnit, function ($query, $selectedUnit) {
                    return $query->whereIn('us.id', function ($subquery) use ($selectedUnit) {
                        $subquery->select('user_id')
                            ->from('user_units')
                            ->where('unit_id', $selectedUnit);
                    });
                })
                ->get();
        }


        // Add shifts data to the absensi if users have not checked in
        $shifts = DB::table('user_shifts as sf')
            ->select('sf.user_id', 'shi.shift_name', DB::raw('TIME(sf.valid_date_start) as sfmasuk'))
            ->join('shifts as shi', 'shi.id', '=', 'sf.shift_id')
            ->leftJoin('users as u', 'u.id', '=', 'sf.user_id')
            ->whereRaw('DATE(sf.valid_date_start) = ?', [$this->selectedDate])
            ->when($this->selectedUnit, function ($query, $selectedUnit) {
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

        // Format data for export
        $data = $query->map(function ($item) use ($absensi) {
            $absensiData = $absensi->where('user_id', $item->id)->first();
            return [
                $item->id,
                $item->name,
                $item->unit,
                $absensiData ? ($absensiData->shift_name . ' - ' . $absensiData->sfmasuk) : '--',
                $absensiData ? $absensiData->masuk : '--',
                $absensiData ? $absensiData->pulang : '--',
                $absensiData ? $absensiData->difference : '--',
                $absensiData ? $absensiData->status : 'Belum Absen',
            ];
        });

        return $data;
    }

    public function headings(): array
    {
        $formattgl = Carbon::parse($this->selectedDate)->format('d-m-Y');
        return [
            ['Tanggal :  ' . $formattgl],  // Custom header for the exported date
            [],  // Empty row to separate the date header from the table headings
            ['ID', 'Nama Pegawai', 'Unit', 'Shifts Pegawai', 'Jam Datang', 'Jam Pulang', 'Selisih', 'Keterangan'], // Table headers
        ];
    }
}

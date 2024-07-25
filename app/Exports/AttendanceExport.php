<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class AttendanceExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $absen;
    protected $jumlahhari;

    public function __construct($data, $absen, $jumlahhari)
    {
        $this->data = $data;
        $this->absen = $absen;
        $this->jumlahhari = $jumlahhari;
    }

    public function collection()
    {
        $collection = new Collection();

        foreach ($this->data as $index => $row) {
            // Check-in row
            $checkInEntry = [
                'No' => $index + 1,
                'Nama Pegawai' => $row->name,
                'Unit' => $row->unit,
                'Ket' => 'Masuk',
            ];

            for ($day = 1; $day <= $this->jumlahhari; $day++) {
                $date = date('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
                $checkInEntry[$day] = $this->absen[$row->id][$date]['check_in'] ?? '-';
            }

            $checkInEntry['Telat'] = $this->absen[$row->id]['telat_count'] ?? 0;

            $collection->push($checkInEntry);

            // Check-out row
            $checkOutEntry = [
                'No' => '',
                'Nama Pegawai' => '',
                'Unit' => '',
                'Ket' => 'Pulang',
            ];

            for ($day = 1; $day <= $this->jumlahhari; $day++) {
                $date = date('Y-m-') . str_pad($day, 2, '0', STR_PAD_LEFT);
                $checkOutEntry[$day] = $this->absen[$row->id][$date]['check_out'] ?? '-';
            }

            $checkOutEntry['Telat'] = ''; // No need to include 'Telat' here

            $collection->push($checkOutEntry);
        }

        return $collection;
    }

    public function headings(): array
    {
        $headings = [
            'No',
            'Nama Pegawai',
            'Unit',
            'Ket'
        ];

        for ($day = 1; $day <= $this->jumlahhari; $day++) {
            $headings[] = $day;
        }

        $headings[] = 'Telat';

        return $headings;
    }
}


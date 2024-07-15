<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;


class KeuanganImportClass implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return $row;
    }
}

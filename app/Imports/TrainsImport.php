<?php

namespace App\Imports;

use App\Models\Train;
use Maatwebsite\Excel\Concerns\ToModel;

class TrainsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Train([
            'year'=> $row[1],
            'course'=> $row[2],
            'student'=> $row[3]
        ]);
    }
}

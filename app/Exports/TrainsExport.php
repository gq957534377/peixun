<?php

namespace App\Exports;

use App\Models\Train;
use Maatwebsite\Excel\Concerns\FromCollection;

class TrainsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Train::get([
            'id',
            'year',
            'course',
            'student'
        ]);
    }
}

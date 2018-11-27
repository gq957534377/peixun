<?php

namespace App\Imports;

use App\Models\Train;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class TrainsImport implements ToModel, WithChunkReading, ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        var_dump($row,'/n');
//        return new Train([
//            'year'=> $row[1],
//            'course'=> $row[2],
//            'student'=> $row[3]
//        ]);
    }

    // 一次最多导入这么多
    public function batchSize(): int
    {
        return 1000;
    }

    // 从第几行开始
    public function headingRow(): int
    {
        return 2;
    }

    // 块的形式读取
    public function chunkSize(): int
    {
        return 1000;
    }
}

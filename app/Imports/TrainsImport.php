<?php

namespace App\Imports;

use App\Models\Train;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrainsImport implements ToModel, WithHeadingRow, WithChunkReading, ShouldQueue
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        dd($row);
        return new Train([
            'year'        => $row['year'] ?? '',
            'case'        => $row['course'] ?? '',
            'team'        => $row['team'] ?? '',
            'student'     => $row['user_name'] ?? '',
            'student_tel' => $row['tel'] ?? '',
            'remark'      => $row['remark'] ?? ''
        ]);
    }

    // 一次最多导入这么多
    public function batchSize(): int
    {
        return 1000;
    }

    // 从第几行开始
    public function headingRow(): int
    {
        return 1;
    }

    // 块的形式读取
    public function chunkSize(): int
    {
        return 1000;
    }
}

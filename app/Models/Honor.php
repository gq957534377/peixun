<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Honor extends Model
{
    // 不允许集体赋值的字段
    protected $guarded = [];
    static public function yearList()
    {
        return self::distinct('year')->pluck('year')->toArray();
    }
}

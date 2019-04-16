<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Train extends Model
{
    // 不允许集体赋值的字段
    protected $guarded = [];

    static public function caseList()
    {
        return self::distinct('case')->pluck('case')->toArray();
    }

    static public function yearList()
    {
        return self::distinct('year')->pluck('year')->toArray();
    }
}

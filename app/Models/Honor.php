<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Honor extends Model
{
    protected $table = 'rel_honors';
    // 不允许集体赋值的字段
    protected $guarded = [];
}

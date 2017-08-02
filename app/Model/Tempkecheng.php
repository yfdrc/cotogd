<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tempkecheng extends Model
{
    protected $guarded = [];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
}

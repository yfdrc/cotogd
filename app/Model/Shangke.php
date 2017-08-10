<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shangke extends Model
{
    protected $guarded =[];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function kecheng()
    {
        return $this->belongsTo(Kecheng::class);
    }
}

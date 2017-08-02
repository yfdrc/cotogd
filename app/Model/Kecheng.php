<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kecheng extends Model
{
    protected $fillable = ['dianpu_id','name', 'boach', 'ageMin', 'ageMax','quanZhong'];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
}

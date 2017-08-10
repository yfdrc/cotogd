<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Shangke extends Model
{
    protected $fillable = ['dianpu_id', 'kecheng_id', 'boach', 'skrs', 'sksj'];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function kecheng()
    {
        return $this->belongsTo(Kecheng::class);
    }
}

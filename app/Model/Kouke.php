<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Kouke extends Model
{
    protected $fillable = ['dianpu_id','xueyuan_id', 'kecheng_id', 'studTime', 'studKs', 'kcQz'];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function xueyuan()
    {
        return $this->belongsTo(Xueyuan::class);
    }
    public function kecheng()
    {
        return $this->belongsTo(Kecheng::class);
    }
}

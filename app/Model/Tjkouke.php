<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tjkouke extends Model
{
    protected $guarded = [];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function jiazhang()
    {
        return $this->belongsTo(Jiazhang::class);
    }
    public function xueyuan()
    {
        return $this->belongsTo(Xueyuan::class);
    }
}

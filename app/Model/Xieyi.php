<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Xieyi extends Model
{
    protected $fillable = ['name','dianpu_id','jiazhang_id', 'date',  'kebao','ksZw','ksYw','jinE','isZZ','guWen1','guWen2'];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function jiazhang()
    {
        return $this->belongsTo(Jiazhang::class);
    }
}

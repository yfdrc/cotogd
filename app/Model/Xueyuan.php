<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Xueyuan extends Model
{
//    public $incrementing = false;
//    public $timestamps = false;
//    protected $keyType = 'string';
    protected $guarded =[];

    public function jiazhang()
    {
        return $this->belongsTo(Jiazhang::class);
    }
    public function getfrombh($bh)
    {
        return Xueyuan::where('bh',$bh)->first();
    }
}

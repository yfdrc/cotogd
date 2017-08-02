<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tempxieyi extends Model
{
    protected $guarded = [];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function getJzname()
    {
        $fhz = null;
        $tem = Tempjiazhang::where('bh',$this->jzbh)->first();
        if($tem!=null) $fhz = $tem->name;
        return $fhz;
    }
}

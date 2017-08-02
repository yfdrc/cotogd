<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tempkouke extends Model
{
    protected $guarded = [];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function getJzname()
    {
        $fhz = '';
        $tem1 = Tempxueyuan::where('bh',$this->xybh)->first();
        if($tem1!=null) {
            $tem2 = Tempjiazhang::where('bh',$tem1->jzbh)->first();
            if($tem2!=null) {
                $fhz = $tem2->name;
            }
        }
        return $fhz;
    }
    public function getXyname()
    {
        $fhz = '';
        $tem = Tempxueyuan::where('bh',$this->xybh)->first();
        if($tem!=null) $fhz = $tem->name;
        return $fhz;
    }
}

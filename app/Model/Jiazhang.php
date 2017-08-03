<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Jiazhang extends Model
{
//    public $incrementing = false;
//    public $timestamps = false;
//    protected $keyType = 'string';
    protected $guarded =[];

    public function xueyuans()
    {
        return $this->hasMany(Xueyuan::class);
    }

    public function show(){
        echo $this->find(1)->name;
        return true;
    }
}

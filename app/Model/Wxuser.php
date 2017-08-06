<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Wxuser extends Model
{
    protected $keyType = 'string';
    protected $primaryKey='openid';
    protected $guarded = [];

    public function group()
    {
        return $this->belongsTo(Wxgroup::class);
    }
}

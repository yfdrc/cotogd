<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Dianpu extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}

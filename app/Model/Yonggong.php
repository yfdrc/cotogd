<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Yonggong extends Model
{
    protected $fillable = ['dianpu_id','name', 'tele', 'job', 'birthday'];

    public function dianpu()
    {
        return $this->belongsTo(Dianpu::class);
    }
    public function xieyis()
    {
        return $this->belongsToMany(Xieyi::class);
    }
    public function hasXieyi($id)
    {
        if (is_string($id)) {
            return $this->xieyis()->contains('id', $id);
        }
        return !! $id->intersect($this->xieyis())->count();
    }
    public function assignXieyi($id)
    {
        return $this->xieyis()->save(
            Xieyi::whereName($id)->firstOrFail()
        );
    }
}

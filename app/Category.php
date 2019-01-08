<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['name'];
    protected $appends = ['monitors'];

    public function getMonitorsAttribute() {
        return $this->monitors();
    }

    public function monitors() {
        return $this->hasMany('App\Monitor')->get();
    }

}

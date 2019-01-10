<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $table = 'monitors';

    protected $fillable = [
        'name', 'category_id'
    ];

    public function monitor() {
        return $this->belongsTo('App\Category')->get();
    }

}

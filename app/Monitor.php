<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Monitor extends Model
{
    protected $table = 'monitors';

    protected $fillable = [
        'name', 'category_id', 'last_status'
    ];

    protected $casts = [
        'last_status' => 'boolean'
    ];

    public function monitor() {
        return $this->belongsTo('App\Category')->get();
    }

}

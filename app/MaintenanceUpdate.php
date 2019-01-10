<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class MaintenanceUpdate extends Model
{

    protected $appends = [
        'created_on'
    ];

    protected $fillable = [
        'maintenance_id', 'title', 'description', 'type'
    ];

    public function incident() {
        return $this->belongsTo('App\Maintenance')->get();
    }

    public function getCreatedOnAttribute() {
        return Carbon::parse($this->attributes['created_at'])->format('c');
    }

}

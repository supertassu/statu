<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = 'maintenances';

    protected $appends = [
        'created_on', 'updates'
    ];

    protected $casts = [
        'affected_components' => 'array',
    ];

    protected $fillable = [
        'title', 'description', 'affected_components', 'start', 'scheduled_end', 'closed'
    ];

    public function getCreatedOnAttribute() {
        return Carbon::parse($this->attributes['created_at'])->format('c');
    }

    public function updates() {
        return $this->hasMany('App\MaintenanceUpdate')->get();
    }

    public function getUpdatesAttribute() {
        return $this->updates();
    }

}

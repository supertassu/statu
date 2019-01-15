<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $table = 'incidents';

    protected $appends = [
        'created_on', 'updates'
    ];

    protected $fillable = [
        'title', 'description', 'affected_components', 'resolved'
    ];

    protected $casts = [
        'affected_components' => 'array',
        'resolved' => 'boolean'
    ];

    public function updates() {
        return $this->hasMany('App\IncidentUpdate')->get();
    }

    public function getCreatedOnAttribute() {
        return Carbon::parse($this->attributes['created_at'])->format('c');
    }

    public function getUpdatesAttribute() {
        return $this->updates();
    }

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentUpdate extends Model
{

    protected $table = 'incident_updates';

    protected $appends = [
        'created_on'
    ];

    protected $fillable = [
        'incident_id', 'title', 'description', 'type'
    ];

    public function incident() {
        return $this->belongsTo('App\Incident');
    }

    public function getCreatedOnAttribute() {
        return \Carbon\Carbon::parse($this->attributes['created_at'])->format('c');
    }

}

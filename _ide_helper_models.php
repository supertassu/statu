<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\IncidentUpdate
 *
 * @property-read \App\Incident $incidents
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncidentUpdate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncidentUpdate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncidentUpdate query()
 */
	class IncidentUpdate extends \Eloquent {}
}

namespace App{
/**
 * App\Incident
 *
 * @property-read mixed $create_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\IncidentUpdate[] $updates
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Incident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Incident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Incident query()
 */
	class Incident extends \Eloquent {}
}


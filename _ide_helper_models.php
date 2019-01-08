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
 * App\Category
 *
 * @property-read mixed $monitors
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Category query()
 */
	class Category extends \Eloquent {}
}

namespace App{
/**
 * App\IncidentUpdate
 *
 * @property-read mixed $created_on
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
 * @property-read mixed $created_on
 * @property-read mixed $updates
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Incident newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Incident newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Incident query()
 */
	class Incident extends \Eloquent {}
}

namespace App{
/**
 * App\Monitor
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Monitor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Monitor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Monitor query()
 */
	class Monitor extends \Eloquent {}
}


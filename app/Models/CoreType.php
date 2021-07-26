<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreType extends Model {
	use HasFactory;

	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) {return $this->where($field ?? 'id', $value)->firstOrFail();}

	
	/* RELATIONSHIPS */
	public function industry() {return $this->belongsTo(CoreIndustry::class);}
	public function sector() {return $this->belongsTo(CoreSector::class);}

	public function businesses() {return $this->hasMany(Business::class);}

	/* FUNCTIONS */

	/* SCOPES */

}

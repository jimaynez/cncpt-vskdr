<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreSector extends Model {
	use HasFactory;

	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) {return $this->where($field ?? 'id', $value)->firstOrFail();}

	/* RELATIONSHIPS */
	public function types() {return $this->hasMany(CoreType::class);}

	/* FUNCTIONS */

	/* SCOPES */

	
}

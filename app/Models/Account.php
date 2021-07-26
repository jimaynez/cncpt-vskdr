<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model {
	use HasFactory;
	
	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) {return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();}

	/* RELATIONSHIPS */
	public function users() {return $this->hasMany(User::class);}
	public function organisations() {return $this->hasMany(Organisation::class);}
		public function contacts() {return $this->hasManyThrough(Contact::class, Organisation::class);}
	public function businesses() {return $this->hasMany(Business::class);}
		public function analyserdata() {return $this->hasManyThrough(AnalyserData::class, Business::class);}

	/* FUNCTIONS */

	/* SCOPES */    
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model {
	use HasFactory;

	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) {return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();}

	/* RELATIONSHIPS  */
	public function analyserdata() {return $this->hasMany(AnalyserData::class);}
	public function business() {return $this->belongsTo(Business::class);}
}

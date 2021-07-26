<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnalyserData extends Model {
	use HasFactory;
	use softDeletes;

	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) {
		return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
	}

	/* RELATIONSHIPS */
	public function business() {return $this->belongsTo(Business::class);}
}

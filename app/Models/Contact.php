<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model {
	use HasFactory;
	use SoftDeletes;

	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) {
		return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
	}

	/* RELATIONSHIPS */
	public function organisation() {return $this->belongsTo(Organisation::class);}

	/* FUNCTIONS */
	public function getNameAttribute() {return $this->first_name.' '.$this->last_name;}

	/* SCOPES */
	public function scopeOrderByName($query) {
		$query->orderBy('last_name')->orderBy('first_name');
	}

	public function scopeFilter($query, array $filters) {
		$query
			->when($filters['search'] ?? null, function ($query, $search) {
					$query->where(function ($query) use ($search) {
						$query->where('first_name', 'like', '%'.$search.'%')
							->orWhere('last_name', 'like', '%'.$search.'%')
							->orWhere('email', 'like', '%'.$search.'%')
							->orWhereHas('organisation', function ($query) use ($search) {
								$query->where('name', 'like', '%'.$search.'%');
							});
					});
			})
			->when($filters['trashed'] ?? null, function ($query, $trashed) {
					if ($trashed === 'with') {
						$query->withTrashed();
					} elseif ($trashed === 'only') {
						$query->onlyTrashed();
					}
			});
	}
}

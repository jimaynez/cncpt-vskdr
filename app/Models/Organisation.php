<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organisation extends Model {
	use HasFactory;
	use SoftDeletes;

	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) {return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();}

	/* RELATIONSHIPS */
	public function contacts() {return $this->hasMany(Contact::class);}

	/* FUNCTIONS */
	public function getPlainAddressAttribute() {
		return $this->address.', '.$this->city.', '.$this->state.', '.$this->postal_code;
	}

	/* SCOPES */
	public function scopeFilter($query, array $filters) {
		$query
			->when($filters['search'] ?? null, function ($query, $search) {
					$query->where('name', 'like', '%'.$search.'%')
						->orWhere('city', 'like', '%'.$search.'%')
						->orWhere('state', 'like', '%'.$search.'%');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;

class Business extends Model {
	use HasFactory;
	use softDeletes;
	use SpatialTrait;

	protected $spatialFields = [
		'coordinates',
	];
	
	/* ROUTE BINDING */
	public function resolveRouteBinding($value, $field = null) { return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail(); }

	/* RELATIONSHIPS */
	public function user() {return $this->belongsTo(User::class);}
	public function category() {return $this->belongsTo(CoreCategory::class);}
	public function type() {return $this->belongsTo(CoreType::class);}
	public function analyserdata() {return $this->hasMany(AnalyserData::class);}
	public function reports() {return $this->hasMany(Report::class);}

	/* FUNCTIONS */
	public function setLocationAttribute($latitude, $longitude) {
		$point = new Point($latitude, $longitude, 3857);
		$this->attributes['coordinates'] = $point;
	}

	public function getLocationAttribute() {
		$point = $this->coordinates;
		return $pointToString = (string)$point;
	}

	public function getLocationLatAttribute() {
		return $LocationLat = $this->coordinates->getLat();
	}

	public function getLocationLngAttribute() {
		return $LocationLng = $this->coordinates->getLng();
	}

	/* SCOPES */
	public function scopeOrderByName($query) {
		$query->orderBy('last_name')->orderBy('first_name');
	}

	public function scopeOrderByLatestAdded($query) {
		$query->orderBy('updated_at')->orderBy('created_at');
	}

	public function scopeFilter($query, array $filters) {
		$query
			->when($filters['search'] ?? null, function ($query, $search) {
					$query->where(function ($query) use ($search) {
						$query->where('title', 'like', '%'.$search.'%')
							->orWhereHas('category', function ($query) use ($search) {
								$query->where('name_long', 'like', '%'.$search.'%');
							})
							->orWhereHas('type', function ($query) use ($search) {
								$query->where('name_long', 'like', '%'.$search.'%');
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

<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\AnalyserData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class AnalyserController extends Controller {
	public function analyse(Request $request, Business $business) {
		$user_id = Auth::user()->id;
		$bsn_id = $business->id;
		$radius = Request::get('radius');
		$number_of_businesses = $this->get_number_of_proximal_businesses($bsn_id, $radius);
		$category_compatibility_score = $this->get_raw_category_compatibility($bsn_id, $radius);
		$type_compatibility_score = $this->get_raw_type_compatibility($bsn_id, $radius);
		$distinct_categories = $this->get_number_of_distinct_categories($bsn_id, $radius);
		$distinct_types = $this->get_number_of_distinct_types($bsn_id, $radius);

		AnalyserData::updateOrCreate([
			'business_id' => $bsn_id,
			'radius' => $radius,
			'number_of_businesses' => $number_of_businesses,
			'category_compatibility_score' => $category_compatibility_score,
			'type_compatibility_score' => $type_compatibility_score,
			'distinct_categories' => $distinct_categories,
			'distinct_types' => $distinct_types,
		]);

		return Redirect::back()->with('success', 'Analysis saved.');
	}


	public function get_number_of_businesses() {
		return $count  = Business::all()->count('id');; 
	}

	
	public function get_number_of_proximal_businesses($id, $radius) {
		$number_of_proximals = 0;
		$proximals = DB::select('select count_proximal_businesses(?, ?) as prox', [$id, $radius]);
		
		foreach ($proximals as $proximal) {
			$number_of_proximals = $proximal->prox;
		}

		return $number_of_proximals;
	}


	public function get_raw_category_compatibility($id, $radius) {
		$compatibility = 0;
		$scores = DB::select('select get_raw_catg_compat_score(?, ?) as scoreC', [$id, $radius]);
		
		foreach ($scores as $score) {
			$compatibility = $score->scoreC;
		}

		return round($compatibility,2); 
	}


	public function get_raw_type_compatibility($id, $radius) {
		$compatibility = 0;
		$scores = DB::select('select get_raw_type_compat_score(?, ?) as scoreT', [$id, $radius]);

		foreach ($scores as $score) {
			$compatibility = $score->scoreT;
		}

		return round($compatibility,2); 
	}


	public function get_number_of_distinct_categories($id, $radius) {
		$distincts = 0;
		$numbers = DB::select('select get_number_of_distinct_types(?, ?) as distinctC', [$id, $radius]); 
		
		foreach ($numbers as $number) {
		$distincts = $number->distinctC;
		}

		return $distincts;
	}


	public function get_number_of_distinct_types($id, $radius) {    
		$distincts = 0;
		$numbers = DB::select('select get_number_of_distinct_categories(?, ?) as distinctT', [$id, $radius]); 

		foreach ($numbers as $number) {
			$distincts = $number->distinctT;
		}

		return $distincts;
	}    
}

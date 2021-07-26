<?php

namespace App\Http\Controllers;

use App\Models\AnalyserData;
use App\Models\Business;
use App\Models\CoreCategory;
use App\Models\CoreType;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;

class AnalyserDataController extends Controller {

	public function index() {
		//
	}


	public function create() {
		//   
	}

	public function view(AnalyserData $analyserData) {
		return Inertia::render('AnalyserData/View', [
			'business' => Business::all(),
			'analyserdata' => [
				'business_id' => $analyserData->business_id,
				'radius' => $analyserData->radius,
				'number_of_businesses' => $analyserData->number_of_businesses,
				'category_compatibility_score' => $analyserData->category_compatibility_score,
				'type_compatibility_score' => $analyserData->type_compatibility_score,
				'distinct_categories' => $analyserData->distinct_categories,
				'distinct_types' => $analyserData->distinct_types,
			],
		]);
	}

	public function store(Request $request) {
		Auth::user()->businesses()->analyserdata()->updateOrCreate([
			'business_id' => Auth::user()->businesses()->id,
			'radius' => $request->radius,
			'number_of_businesses' => $request->number_of_businesses,
			'category_compatibility_score' => $request->category_compatibility_score,
			'type_compatibility_score' => $request->type_compatibility_score,
			'distinct_categories' => $request->distinct_categories,
			'distinct_types' => $request->distinct_types,
		]);

		return Redirect::back()->with('success', 'Analysis data saved.');
	}

	public function resolve(Request $request) {

	}

	public function findLatestResult(Request $request) {
			
	}

	public function listAllResultsForBusiness($id) {
		return $results = DB::select('get_results_for_business as results', [$id]);
	}

	public function showResult(Business $business) {
		return Inertia::render('Businesses/Result', [
			'dataset' => [
				'id' => $business->id,
				'title' => $business->title,
				'LocationLat' => (string)$business->LocationLat,
				'LocationLng' => (string)$business->LocationLng,
				'category_id' => (string)$business->category_id,
				'type_id' => (string)$business->type_id,
			],
			'core_categories' => CoreCategory::all(),
			'core_types' => CoreType::all(),
		]);
	}

	
	public function edit(AnalyserData $analyserData) {
		//
	}


	public function update(Request $request, AnalyserData $analyserData) {
		$analyserData->updateOrCreate([
			'radius' => $request->radius,
			'number_of_businesses' => $request->number_of_businesses,
			'category_compatibility_score' => $request->category_compatibility_score,
			'type_compatibility_score' => $request->type_compatibility_score,
			'distinct_categories' => $request->distinct_categories,
			'distinct_types' => $request->distinct_types,
		]);

		return Redirect::back()->with('success', 'Analysis data saved.');
	}


	public function destroy(AnalyserData $analyserData) {
		$analyserData->delete();

		return Redirect::back()->with('success', 'Analyser data deleted.');
	}


	public function restore(AnalyserData $analyserData) {
		$analyserData->restore();
		
		return Redirect::back()->with('success', 'Analyser data restored.');
	}
}

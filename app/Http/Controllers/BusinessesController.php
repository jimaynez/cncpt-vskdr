<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\CoreCategory;
use App\Models\CoreType;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;


class BusinessesController extends Controller {
	public function index() {
		return Inertia::render('Businesses/Index', [
			'filters' => Request::all('search', 'trashed'),
			'businesses' => Auth::user()->businesses()
				->with('category')->with('type')
				->OrderByLatestAdded()
				->filter(Request::only('search', 'trashed'))
				->paginate(10)->withQueryString()
				->through(fn ($business) => [
					'id' => $business->id,
					'title' => $business->title,
					'coordinates' => $business->location,
					'category' => $business->category ? $business->category->only('name_long') : null,
					'type' => $business->type ? $business->type->only('name_long') : null,
				]),
		]);
	}


	public function create() {
		return Inertia::render('Businesses/Create', [
			'core_categories' => CoreCategory::all(),
			'core_types' => CoreType::all(),
		]);
	}


	public function store(Request $request) {
		Request::validate([
			'title' => ['required', 'max:100'],
			'category_id' => ['required', Rule::exists('core_categories', 'id')],
			'type_id' => ['required', Rule::exists('core_types', 'id')],
			'latitude' => ['required', 'integer'],
			'longitude' => ['required', 'integer'],
		]);

		$lat = Request::get('latitude');
		$lng = Request::get('longitude');
		$businesscoords = new Point($lat, $lng, 3758);

		Auth::user()->businesses()->create([
			'user_id' => Auth::user()->id,
			'category_id' => Request::get('category_id'),
			'type_id' => Request::get('type_id'),
			'title' => Request::get('title'),
			'coordinates' => $businesscoords,
		]);

		return Redirect::route('businesses')->with('success', 'Business created.');
	}


	public function show(Business $business) {
		return Inertia::render('Businesses/Show', [
			'business' => [
				'id' => $business->id,
				'title' => $business->title,
				'LocationLat' => (string)$business->LocationLat,
				'LocationLng' => (string)$business->LocationLng,
				'category_id' => (string)$business->category_id,
				'type_id' => (string)$business->type_id,
				'analyserdata' => $business->analyserdata()->orderByDesc('updated_at')->limit(3)->get(),
				'latestdata' => $business->analyserdata()->orderByDesc('created_at')->limit(1)->get(),
				'category' => $business->category ? $business->category->only('name_long') : null,
				'type' => $business->type ? $business->type->only('name_long') : null,
			],
		]);
	}


	public function edit(Business $business) {
		return Inertia::render('Businesses/Edit', [
			'business' => [
				'id' => $business->id,
				'title' => $business->title,
				'LocationLat' => $business->LocationLat,
				'LocationLng' => $business->LocationLng,
				'category_id' => $business->category_id,
				'type_id' => $business->type_id,
			],
			'core_categories' => CoreCategory::all(),
			'core_types' => CoreType::all(),
		]);
	}


	public function update(Request $request, Business $business) {
		Request::validate([
			'title' => ['required', 'max:100'],
			'category_id' => ['required', Rule::exists('core_categories', 'id')],
			'type_id' => ['required', Rule::exists('core_types', 'id')],
			'latitude' => ['required', 'integer'],
			'longitude' => ['required', 'integer'],
		]);

		$lat = Request::get('latitude');
		$lng = Request::get('longitude');
		$businesscoords = new Point($lat, $lng, 3758);

		$business->update(Request::only('category_id', 'type_id', 'title'));

		if (Request::get('latitude') || Request::get('longitude')) {
			$business->update(['coordinates' => $businesscoords]);
		}

		return Redirect::back()->with('success', 'Business updated.');
	}


	public function destroy(Business $business) {
		$business->delete();

		return Redirect::back()->with('success', 'Business deleted.');
	}


	public function restore(Business $business) {
		$business->restore();
		
		return Redirect::back()->with('success', 'business restored.');
	}
}

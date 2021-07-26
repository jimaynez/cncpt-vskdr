<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller {
	public function index() {
		return Inertia::render('Reports/Index');
	}


	public function create() {
		//
	}


	public function store(Request $request) {
		//
	}


	public function show(Report $report) {
		//
	}


	public function edit(Report $report)  {
		//
	}


	public function update(Request $request, Report $report) {
		//
	}


	public function destroy(Report $report) {
		$report->delete();
		return Redirect::back()->with('success', 'Report deleted.');
	}

	
	public function restore(Report $report) {
		$report->restore();
		return Redirect::back()->with('success', 'Report restored.');
	}
}

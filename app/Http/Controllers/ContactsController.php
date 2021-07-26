<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;

class ContactsController extends Controller {

	public function index() {
		return Inertia::render('Contacts/Index', [
			'filters' => Request::all('search', 'trashed'),
			'contacts' => Auth::user()->account->contacts()
				->with('organisation')->orderByName()->filter(Request::only('search', 'trashed'))->paginate(10)->withQueryString()
				->through(fn ($contact) => [
					'id' => $contact->id,
					'name' => $contact->name,
					'email' => $contact->email,
					'phone' => $contact->phone,
					'deleted_at' => $contact->deleted_at,
					'organisation' => $contact->organisation ? $contact->organisation->only('name') : null,
				]),
		]);
	}


	public function create() {
		return Inertia::render('Contacts/Create', [
			'organisations' => Auth::user()->account
				->organisations()
				->orderBy('name')->get()
				->map->only('id', 'name'),
		]);
	}

	public function store() {
		Auth::user()->account->contacts()->create(
			Request::validate([
				'first_name' => ['required', 'max:50'],
				'last_name' => ['required', 'max:50'],
				'organisation_id' => ['nullable', 
					Rule::exists('organisations', 'id')->where(function ($query) {
						$query->where('account_id', Auth::user()->account_id);
				})],
				'email' => ['nullable', 'max:100', 'email'],
				'phone' => ['nullable', 'max:50'],
			])
		);
		
		return Redirect::route('contacts')->with('success', 'Contact created.');
	}


	public function show(Business $business) {
		return Inertia::render('Contacts/Show', [
			'contact' => [
					'id' => $contact->id,
					'first_name' => $contact->first_name,
					'last_name' => $contact->last_name,
					'organisation_id' => $contact->organisation_id,
					'email' => $contact->email,
					'phone' => $contact->phone,
					'deleted_at' => $contact->deleted_at,
			],
			'organisations' => Auth::user()->account->organisations()
					->orderBy('name')->get()->map->only('id', 'name'),
		]);
	}


	public function edit(Contact $contact) {
		return Inertia::render('Contacts/Edit', [
			'contact' => [
				'id' => $contact->id,
				'first_name' => $contact->first_name,
				'last_name' => $contact->last_name,
				'organisation_id' => $contact->organisation_id,
				'email' => $contact->email,
				'phone' => $contact->phone,
				'deleted_at' => $contact->deleted_at,
			],
			'organisations' => Auth::user()->account->organisations()->orderBy('name')->get()->map->only('id', 'name'),
		]);
	}


	public function update(Contact $contact) {
		$contact->update(
			Request::validate([
				'first_name' => ['required', 'max:50'],
				'last_name' => ['required', 'max:50'],
				'organisation_id' => [
					'nullable',
					Rule::exists('organisations', 'id')->where(fn ($query) => $query->where('account_id', Auth::user()->account_id)),
				],
				'email' => ['nullable', 'max:100', 'email'],
				'phone' => ['nullable', 'max:50'],
			])
		);

		return Redirect::back()->with('success', 'Contact updated.');
	}


	public function destroy(Contact $contact) {
		$contact->delete();

		return Redirect::back()->with('success', 'Contact deleted.');
	}

	public function restore(Contact $contact) {
		$contact->restore();

		return Redirect::back()->with('success', 'Contact restored.');
	}
}

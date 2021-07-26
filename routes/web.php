<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\OrganisationsController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\BusinessesController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\AnalyserController;
use App\Http\Controllers\AnalyserDataController;
use Illuminate\Support\Facades\Route;

//
// AUTHENTICATION
Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login')->middleware('guest');
Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store')->middleware('guest');
Route::delete('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// DASHBOARD
Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');


// USERS
Route::get('users', [UsersController::class, 'index'])->name('users')->middleware('auth');
Route::get('users/create', [UsersController::class, 'create'])->name('users.create')->middleware('auth');
Route::post('users', [UsersController::class, 'store'])->name('users.store')->middleware('auth');
Route::get('users/{user}/edit', [UsersController::class, 'edit'])->name('users.edit')->middleware('auth');
Route::put('users/{user}', [UsersController::class, 'update'])->name('users.update')->middleware('auth');
Route::delete('users/{user}', [UsersController::class, 'destroy'])->name('users.destroy')->middleware('auth');
Route::put('users/{user}/restore', [UsersController::class, 'restore'])->name('users.restore')->middleware('auth');


// ORGANISATIONS
Route::get('organisations', [OrganisationsController::class, 'index'])->name('organisations')->middleware('auth');
Route::get('organisations/create', [OrganisationsController::class, 'create'])->name('organisations.create')->middleware('auth');
Route::post('organisations', [OrganisationsController::class, 'store'])->name('organisations.store')->middleware('auth');
Route::get('organisations/{organisation}/edit', [OrganisationsController::class, 'edit'])->name('organisations.edit')->middleware('auth');
Route::put('organisations/{organisation}', [OrganisationsController::class, 'update'])->name('organisations.update')->middleware('auth');
Route::delete('organisations/{organisation}', [OrganisationsController::class, 'destroy'])->name('organisations.destroy')->middleware('auth');
Route::put('organisations/{organisation}/restore', [OrganisationsController::class, 'restore'])->name('organisations.restore')->middleware('auth');


// CONTACTS
Route::get('contacts', [ContactsController::class, 'index'])->name('contacts')->middleware('auth');
Route::get('contacts/create', [ContactsController::class, 'create'])->name('contacts.create')->middleware('auth');
Route::post('contacts', [ContactsController::class, 'store'])->name('contacts.store')->middleware('auth');
Route::get('contacts/{contact}/edit', [ContactsController::class, 'edit'])->name('contacts.edit')->middleware('auth');
Route::put('contacts/{contact}', [ContactsController::class, 'update'])->name('contacts.update')->middleware('auth');
Route::delete('contacts/{contact}', [ContactsController::class, 'destroy'])->name('contacts.destroy')->middleware('auth');
Route::put('contacts/{contact}/restore', [ContactsController::class, 'restore'])->name('contacts.restore')->middleware('auth');


// BUSINESSES
Route::get('businesses', [BusinessesController::class, 'index'])->name('businesses')->middleware('auth');
Route::get('businesses/create', [BusinessesController::class, 'create'])->name('businesses.create')->middleware('auth');
Route::post('businesses', [BusinessesController::class, 'store'])->name('businesses.store')->middleware('auth');
Route::get('businesses/{business}/edit', [BusinessesController::class, 'edit'])->name('businesses.edit')->middleware('auth');
Route::put('businesses/{business}', [BusinessesController::class, 'update'])->name('businesses.update')->middleware('auth');
Route::delete('businesses/{business}', [BusinessesController::class, 'destroy'])->name('businesses.destroy')->middleware('auth');
Route::put('businesses/{business}/restore', [BusinessesController::class, 'restore'])->name('businesses.restore')->middleware('auth');
Route::get('businesses/{business}/show', [BusinessesController::class, 'show'])->name('businesses.show')->middleware('auth');

// REPORTS
Route::get('reports', [ReportsController::class, 'index'])->name('reports')->middleware('auth');


// IMAGES
Route::get('/img/{path}', [ImagesController::class, 'show'])->where('path', '.*')->name('image');


// BUSINESS ANALYSER
Route::post('businesses/{business}/analyse', [AnalyserController::class, 'analyse'])->name('businesses.analyse')->middleware('auth');


// ANALYSER DATA
Route::get('analyserdata/{analyserdata}/view', [AnalyserDataController::class, 'view'])->name('analyserdata.view')->middleware('auth');
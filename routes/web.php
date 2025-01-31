<?php

use App\Models\Listings;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;


//All listings
Route::get('/', [ListingController::class, 'index'])->name('index');

//Show create Form
Route::get('/listings/create', [ListingController::class, 'create'])->name('createListingGet')->middleware('auth');

//Post Create Form
Route::post('/listings', [ListingController::class, 'store'])->name('createListingPost')->middleware('auth');

//Show edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->name('editForm')->middleware('auth');

//Update edit Form
Route::put('/listings/{listing}', [ListingController::class, 'update'])->name('updateForm')->middleware('auth');

//Delete Listing
Route::Delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('destroy')->middleware('auth');

//manage listing
Route::get('/listings/manage', [ListingController::class,'manage'])->name('manageListing')->middleware('auth');

//Single Listings
Route::get('/listings/{listing}', [ListingController::class, 'show'] );


//Show/Create user User 
Route ::get('/register', [UserController::class,'create'])->name('createUserGet')->middleware('guest');

//Create user
Route ::post('/users', [UserController::class,'store'])->name('createUserPost');

//Logout user
Route ::post('/logout', [UserController::class,'logout'])->name('logoutUser')->middleware('auth');

//LogIn user
Route ::get('/login', [UserController::class,'login'])->name('login')->middleware('guest');

//Authenticate user
Route ::post('/users/authenticate', [UserController::class,'authenticate'])->name('authenticateUser');
<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('/company', App\Http\Controllers\CompanyController::class);

// Route::get('/company/{company}/edit_situation',[App\Http\Controllers\CompanyController::class,'edit_situation'])->name('company.edit_situation');

Route::resource('/user', App\Http\Controllers\UserController::class);

Route::resource('/company.internship_offer', App\Http\Controllers\InternshipOfferController::class);
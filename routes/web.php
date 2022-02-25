<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageExpenses;
use App\Http\Controllers\ManageIncome;
use App\Http\Controllers\ManageProject;
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



Route::get("dashboard", [HomeController::class, "index"])->name("home");

Route::resource('/project', App\Http\Controllers\ProjectController::class);
Route::resource('/income', App\Http\Controllers\IncomeController::class);
Route::resource("/users", App\Http\Controllers\UserControler::class);
// Route::resource("/EXPENSES")
Route::resource("/expenses",App\Http\Controllers\ExpensesController::class);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

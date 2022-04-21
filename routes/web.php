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

Route::get("/", function(){
  if (auth()->guest()) {
    return redirect()->route("login");
  } else {
    return redirect()->route("home");
  }
});

Auth::routes(['register' => true, 'reset' => false]);

Route::middleware(['auth'])->group(function () {
  Route::get("home", [HomeController::class, "index"])->name("home");
  Route::get("update-password", [HomeController::class, "getUpdatePassword"])->name("get.update.password");
  Route::post("update-password", [HomeController::class, "setUpdatePassword"])->name("set.update.password");
  Route::resource('/income', App\Http\Controllers\IncomeController::class);
  Route::resource("/expenses",App\Http\Controllers\ExpensesController::class);
  Route::get("show-project/{id}", [HomeController::class, "showProject"])->name("project.show");
  Route::resource("/transfer", App\Http\Controllers\TransferController::class)->only([
    'index', 'create', 'store', 'destroy'
  ]);
  
});

Route::middleware(['auth', 'admin'])->group(function () {
  Route::resource('/project', App\Http\Controllers\ProjectController::class)->except(['show']);
  Route::resource("/users", App\Http\Controllers\UserControler::class);
  Route::resource("/category", App\Http\Controllers\CategoryController::class);
  
});






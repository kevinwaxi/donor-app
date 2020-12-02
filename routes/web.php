<?php

use App\Http\Controllers\AgencyController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
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
Route::prefix('app')->middleware('auth')->group(function(){

    //Agency Crud
    Route::post('/create_agency', [AgencyController::class, 'create']);
    Route::get('/get_agency',[AgencyController::class, 'index']);

    //Role Crud
    Route::post('/create_role', [RoleController::class, 'create']);
    Route::get('/get_role',[RoleController::class, 'index']);

    //Users Crud
    Route::get('/get_user', [UserController::class, 'index']);

    //Donation Crud
    Route::post('/create_donation', [DonationController::class, 'create']);
    Route::post('/assign_donation', [DonationController::class, 'update']);
    Route::get('/get_donation',[DonationController::class, 'index']);
});
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('{slug}', [HomeController::class, 'index']);

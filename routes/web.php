<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManualController;

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
Route::resource('manual', ManualController::class);


Route::get('/', function () {
    return redirect('/manual');
});

Route::group(['middleware' => 'auth'], function () {
  Route::resource('manual', ManualController::class);
});




require __DIR__.'/auth.php';

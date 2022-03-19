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
Route::post('manual/check', [ManualController::class,'check'])->name('manual.check');

Route::get('/', function () {
    return redirect('/manual');
});

Route::post('/manual/test', function () {
    return view('/manual/test');
});

Route::group(['middleware' => 'auth'], function () {
  Route::resource('manual', ManualController::class);
});




require __DIR__.'/auth.php';

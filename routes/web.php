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

Route::get('/','App\Http\Controllers\Frontend\ProductController@show')->name('home');
Route::get('/details/{id}','App\Http\Controllers\Frontend\ProductController@details')->name('details');

Route::get('/dashboard', function () {
    return view('backend/dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix'=>'/dashboard'], function () {
    Route::get('/create','App\Http\Controllers\Backend\ProductController@create')->middleware(['auth'])->name('create');
    Route::post('/add','App\Http\Controllers\Backend\ProductController@store')->middleware(['auth'])->name('add');
    Route::get('/manage','App\Http\Controllers\Backend\ProductController@index')->middleware(['auth'])->name('manage');
    Route::get('/edit/{id}','App\Http\Controllers\Backend\ProductController@edit')->middleware(['auth'])->name('edit');
    Route::post('/update/{id}','App\Http\Controllers\Backend\ProductController@update')->middleware(['auth'])->name('update');
    Route::get('/delete/{id}','App\Http\Controllers\Backend\ProductController@destroy')->middleware(['auth'])->name('delete');
});




require __DIR__.'/auth.php';

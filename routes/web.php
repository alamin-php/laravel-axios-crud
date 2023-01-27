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
Route::group(['namespace'=>'App\Http\Controllers'], function(){
    Route::group(['prefix'=>'employee'], function(){
        Route::get('/', 'EmployeeController@index')->name('employee.index');
        Route::get('/list', 'EmployeeController@getAllEmployee')->name('employee.data');
        Route::post('/store', 'EmployeeController@store')->name('employee.store');
        Route::get('/edit/{id}', 'EmployeeController@edit');
        Route::put('/update/{id}', 'EmployeeController@update')->name('employee.update');
        Route::get('/destroy/{id}', 'EmployeeController@destroy')->name('employee.destroy');
    });
});

<?php

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

Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/saveStudent', 'StudentController@saveStudent');
Route::get('/editStudent/{id}', 'StudentController@editStudent');
Route::get('/deleteStudent/{id}', 'StudentController@deleteStudent');
Route::post('/student_filter', 'StudentController@studentFilter');
Route::post('/import_student', 'StudentController@importStudent');
Route::get('/export_student', 'StudentController@exportStudent');

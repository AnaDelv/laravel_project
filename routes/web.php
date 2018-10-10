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


Route::get('/', 'PagesController@index');
Route::get('/dashboard', 'PagesController@dashboard')->middleware(['is_super_admin' || 'is_admin']);
Route::post('/dashboard',['uses' => 'FilesController@store'])->middleware(['is_super_admin']);
Route::post('/dashboard',['uses' => 'UsersController@store'])->middleware(['is_super_admin']);


Route::get('/files/delete', 'FilesController@deleteAll')->middleware(['is_super_admin']);
Route::resource('/files', 'FilesController');

Route::resource('/news', 'NewsController')->middleware(['is_super_admin' || 'is_admin']);

Route::get('/users/delete', 'UsersController@deleteAll')->middleware(['is_super_admin']);
Route::resource('/users', 'UsersController')->middleware(['is_super_admin']);
Route::post('/users','UsersController@csvUpload')->middleware(['is_super_admin']);

Route::resource('/classes','ClassesController');

Route::get('/about', 'PagesController@about');
Route::get('/agenda', 'PagesController@agenda');

Auth::routes();

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

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::get('/admin/dashboard', 'App\Http\Controllers\AdminPageController@index')->name('adminPage.index');

Route::get('/admin/user/create', 'App\Http\Controllers\UserController@create')->name('user.create');

Route::get('/user/settings', 'App\Http\Controllers\UserController@edit')->name('user.edit');
Route::get('/user/settings', 'App\Http\Controllers\UserController@update')->name('user.update');


Route::get('/project/{project}', 'App\Http\Controllers\ProjectController@show')->name('project.show');


Route::post('/project/{project}/story', 'App\Http\Controllers\StoryController@store')->name('story.store');
Route::get('/project/{project}/story/create', 'App\Http\Controllers\StoryController@create')->name('story.create');


Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', 'App\Http\Controllers\RoleController');
    Route::resource('users', 'App\Http\Controllers\UserController');
});

Route::get('/project/create/' [ProjectController@create]);
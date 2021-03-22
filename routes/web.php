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

Route::post('/ajax-get-users', 'App\Http\Controllers\ProjectController@userdataAjax')->name('project.userdataAjax');
Route::resource('/project', 'App\Http\Controllers\ProjectController');

Route::get('/project/{project}', 'App\Http\Controllers\ProjectController@show')->name('project.show');

Route::post('/project/{project}/story', 'App\Http\Controllers\StoryController@store')->name('story.store');
Route::post('/project/{project}/stories', 'App\Http\Controllers\StoryController@update_stories')->name('story.update_stories');
Route::get('/project/{project}/story/create', 'App\Http\Controllers\StoryController@create')->name('story.create');

Route::post('/project/{project}/sprint', 'App\Http\Controllers\SprintController@store')->name('sprint.store');
Route::get('/project/{project}/sprint/create', 'App\Http\Controllers\SprintController@create')->name('sprint.create');
Route::get('/project/{project}/sprint/{sprint}/edit', 'App\Http\Controllers\SprintController@edit')->name('sprint.edit');
Route::post('/project/{project}/sprint/{sprint}/edit', 'App\Http\Controllers\SprintController@update')->name('sprint.update');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('/admin/users', 'App\Http\Controllers\UserController');
});


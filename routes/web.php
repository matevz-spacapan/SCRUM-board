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

Route::get('/project', 'App\Http\Controllers\ProjectController@index')->middleware('auth')->name('project.index');
Route::post('/project', 'App\Http\Controllers\ProjectController@store')->name('project.store');
Route::get('/project/create', 'App\Http\Controllers\ProjectController@create')->name('project.create');
Route::get('/project/{project}', 'App\Http\Controllers\ProjectController@show')->name('project.show');
Route::delete('/project/{project}', 'App\Http\Controllers\ProjectController@destroy')->name('project.destroy');
Route::get('/project/{project}/edit', 'App\Http\Controllers\ProjectController@edit')->name('project.edit');

Route::post('/project/{project}/story', 'App\Http\Controllers\StoryController@store')->name('story.store');
Route::post('/project/{project}/stories', 'App\Http\Controllers\StoryController@update_stories')->name('story.update_stories');
Route::get('/project/{project}/accepted', 'App\Http\Controllers\ProjectController@accepted_stories')->name('story.accepted');
Route::get('/project/{project}/story/create', 'App\Http\Controllers\StoryController@create')->name('story.create');
Route::get('/project/{project}/story/{story}/edit', 'App\Http\Controllers\StoryController@edit')->name('story.edit'); #show the form
Route::patch('/project/{project}/story/{story}', 'App\Http\Controllers\StoryController@update')->name('story.update'); #actual process of updating the record
Route::post('/project/{project}/story/{story}/reject', 'App\Http\Controllers\StoryController@reject')->name('story.reject');
Route::post('/project/{project}/story/{story}/accept', 'App\Http\Controllers\StoryController@accept')->name('story.accept');
Route::get('/project/{project}/story/{story}/destroy', 'App\Http\Controllers\StoryController@destroy')->name('story.destroy');

Route::post('/project/{project}/sprint', 'App\Http\Controllers\SprintController@store')->name('sprint.store');
Route::get('/project/{project}/sprint/create', 'App\Http\Controllers\SprintController@create')->name('sprint.create');
Route::get('/project/{project}/sprint/index', 'App\Http\Controllers\SprintController@index')->name('sprint.index');
Route::get('/project/{project}/sprint/{sprint}/edit', 'App\Http\Controllers\SprintController@edit')->name('sprint.edit');
Route::put('/project/{project}/sprint/{sprint}', 'App\Http\Controllers\SprintController@update')->name('sprint.update');
Route::get('/project/{project}/sprint/{sprint}/delete', 'App\Http\Controllers\SprintController@destroy')->name('sprint.delete');

Route::get('/project/{project}/story/{story}/task', 'App\Http\Controllers\TaskController@show')->name('task.show');
Route::post('/project/{project}/story/{story}/task', 'App\Http\Controllers\TaskController@store')->name('task.store');
Route::get('/project/{project}/story/{story}/task/create', 'App\Http\Controllers\TaskController@create')->name('task.create');
Route::get('/project/{project}/story/{story}/task/{task}/destroy', 'App\Http\Controllers\TaskController@destroy')->name('task.destroy');


Route::get('/project/{project}/wall', 'App\Http\Controllers\WallController@index')->name('wall.index');
Route::get('/project/{project}/wall/create', 'App\Http\Controllers\WallController@create')->name('wall.create');
Route::post('/project/{project}/wall', 'App\Http\Controllers\WallController@store')->name('wall.store');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('/admin/users', 'App\Http\Controllers\UserController');
});


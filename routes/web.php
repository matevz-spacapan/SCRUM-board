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

Route::get('/user/settings', 'App\Http\Controllers\UserController@editOwn')->name('user.edit');
//Route::get('/user/settings', 'App\Http\Controllers\UserController@update')->name('user.update');

Route::get('/project', 'App\Http\Controllers\ProjectController@index')->middleware('auth')->name('project.index');
Route::post('/project', 'App\Http\Controllers\ProjectController@store')->name('project.store');
Route::get('/project/create', 'App\Http\Controllers\ProjectController@create')->name('project.create');
Route::get('/project/{project}', 'App\Http\Controllers\ProjectController@show')->name('project.show');
Route::get('/project/{project}/docs', 'App\Http\Controllers\ProjectController@view_docs')->name('project.docs');
Route::get('/project/{project}/docs/edit', 'App\Http\Controllers\ProjectController@edit_docs_view')->name('project.edit_docs_view');
Route::post('/project/{project}/docs', 'App\Http\Controllers\ProjectController@edit_docs')->name('project.edit_docs');
Route::get('/project/{project}/docs/download', 'App\Http\Controllers\ProjectController@download_docs')->name('project.download_docs');
Route::delete('/project/{project}', 'App\Http\Controllers\ProjectController@destroy')->name('project.destroy');
Route::get('/project/{project}/edit', 'App\Http\Controllers\ProjectController@edit')->name('project.edit');
Route::post('/project/{project}/update', 'App\Http\Controllers\ProjectController@update')->name('project.update');

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
Route::get('/project/{project}/sprint/backlog', 'App\Http\Controllers\SprintController@backlog')->name('sprint.backlog');
Route::get('/project/{project}/sprint/{sprint}/edit', 'App\Http\Controllers\SprintController@edit')->name('sprint.edit');
Route::put('/project/{project}/sprint/{sprint}', 'App\Http\Controllers\SprintController@update')->name('sprint.update');
Route::get('/project/{project}/sprint/{sprint}/delete', 'App\Http\Controllers\SprintController@destroy')->name('sprint.delete');

Route::get('/project/{project}/story/{story}/task', 'App\Http\Controllers\TaskController@show')->name('task.show');
Route::post('/project/{project}/story/{story}/task', 'App\Http\Controllers\TaskController@store')->name('task.store');
Route::get('/project/{project}/story/{story}/task/create', 'App\Http\Controllers\TaskController@create')->name('task.create');
Route::get('/project/{project}/story/{story}/task/{task}/edit', 'App\Http\Controllers\TaskController@edit')->name('task.edit'); #show the form
Route::patch('/project/{project}/story/{story}/task/{task}', 'App\Http\Controllers\TaskController@update')->name('task.update'); #actual process of updating the record
Route::get('/project/{project}/story/{story}/task/{task}/destroy', 'App\Http\Controllers\TaskController@destroy')->name('task.destroy');
Route::get('/project/{project}/story/{story}/task/{task}/accept', 'App\Http\Controllers\TaskController@accept')->name('task.accept');
Route::get('/project/{project}/story/{story}/task/{task}/complete', 'App\Http\Controllers\TaskController@complete')->name('task.complete');
Route::get('/project/{project}/story/{story}/task/{task}/startwork', 'App\Http\Controllers\TaskController@startwork')->name('task.startwork');
Route::get('/project/{project}/story/{story}/task/{task}/stopwork', 'App\Http\Controllers\TaskController@stopwork')->name('task.stopwork');
Route::get('/project/{project}/story/{story}/task/{task}/reject', 'App\Http\Controllers\TaskController@reject')->name('task.reject');
Route::get('/project/{project}/story/{story}/task/{task}/reopen', 'App\Http\Controllers\TaskController@reopen')->name('task.reopen');
Route::get('/project/{project}/taskview', 'App\Http\Controllers\TaskController@task_view')->name('task.task_view');
Route::get('/project/{project}/task/{task}/work', 'App\Http\Controllers\WorkController@index')->name('task.work');
Route::delete('work/{work}', 'App\Http\Controllers\WorkController@destroy')->name('work.delete');

Route::get('/project/{project}/wall', 'App\Http\Controllers\WallController@index')->name('wall.index');
Route::get('/project/{project}/wall/create', 'App\Http\Controllers\WallController@create')->name('wall.create');
Route::post('/project/{project}/wall', 'App\Http\Controllers\WallController@store')->name('wall.store');



Route::get('/admin/users/restore/{id}', 'App\Http\Controllers\UserController@restore')->name('user.restore');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('/admin/users', 'App\Http\Controllers\UserController');
});


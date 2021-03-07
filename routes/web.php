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

Route::get('/story', 'App\Http\Controllers\StoryController@index')->name('story.index');
Route::post('/story', 'App\Http\Controllers\StoryController@store')->name('story.store');
Route::get('/story/create', 'App\Http\Controllers\StoryController@create')->name('story.create');

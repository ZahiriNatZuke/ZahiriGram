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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/post', 'PostsController@index')->name('post.index');
Route::get('/post/create', 'PostsController@create')->name('post.create');
Route::get('/post/{post}', 'PostsController@show')->name('post.show');
Route::get('/post/search/{query}', 'PostsController@search')->name('post.search');
Route::post('/post', 'PostsController@store')->name('post.store');

Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');

Route::post('/follow/{user}', 'FollowsController@store')->name('follow');
Route::post('/like/{post}', 'LikesController@store')->name('like');

Route::get('/comment', 'CommentController@index')->name('comment.index');
Route::post('/comment/{post}', 'CommentController@show')->name('comment.show');
Route::post('/comment/{post}', 'CommentController@store')->name('comment.store');

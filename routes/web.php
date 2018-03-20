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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/**
 * Synchronize
 */
Route::get('/synchronize', 'SynchronizeController@index')->name('synchronize');
Route::post('/synchronize', 'SynchronizeController@sync');

/**
 * Posts
 */
Route::resource('/posts', 'PostsController');

/**
 * Comments
 */
Route::resource('/comments', 'CommentsController');
Route::get('/posts/{post}/comments', 'CommentsController@byPosts');

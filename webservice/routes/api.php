<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/user', 'UsersController@store')->name('users.store');


// users

// Get /users  controller@index
// Get /users/{id}  controller@show
// Post /users  controller@store
// PUT|PATCH /users/{id}  controller@update
// Delete /users/{id}  controller@destroy

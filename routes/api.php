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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'to-do'], function () {
    Route::get('/all', 'ToDoListController@listAll');
    Route::get('/{toDoListId}', 'ToDoListController@showToDoList');

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('/', 'ToDoListController@createToDoList');
        Route::put('/{toDoList}', 'ToDoListController@updateToDoList');

        Route::delete('/all', 'ToDoListController@deleteAllToDoList');
        Route::delete('/{toDoList}', 'ToDoListController@deleteToDoList');
    });
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {

    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    Route::post('status', 'AuthController@getTokenStatus');
});

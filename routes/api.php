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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::group(['middleware'=> 'lang'], function() {

    /*
     * Users Routes
     * */
    Route::post('login', 'UsersController@index');
    Route::post('logout', 'UsersController@logout');

    Route::post('users/rating', 'UsersController@rating');
    Route::resource('users', 'UsersController');
    Route::post('profile/{id}', 'UsersController@show');
    Route::post('getUsers', 'UsersController@getUsers');
    Route::post('users/update/{id}', 'UsersController@update');
    Route::post('users/active_phone', 'UsersController@active_phone');
    Route::post('users/check_phone', 'UsersController@check_phone');
    Route::post('users/settings', 'UsersController@settings');
    Route::post('specializations', 'UsersController@specializations');
    Route::post('home', 'HomeController@index');
    Route::post('upload_portfolio', 'UsersController@add_portfolio');
    Route::post('upload_documentations', 'UsersController@add_documentations');
    Route::post('documents/{id}', 'UsersController@documents');
    Route::post('comments/{id}', 'UsersController@comments');
    Route::post('portfolio/{id}', 'UsersController@portfolio');
    Route::post('forgetPassword', 'UsersController@forgetPassword');
    Route::post('update_password', 'UsersController@update_password');
    Route::post('work_days', 'UsersController@work_days');

    /* End Of Users Routes
     * ***************************************************************************
     * ***************************************************************************
     * */

    /*
     * Countries Routes
     * */
    Route::resource('countries', 'CountriesController');

    /* End Of Countries Routes
     * ***************************************************************************
     * ***************************************************************************
     * */

    /*
     * Times Routes
     * */
    Route::resource('times', 'TimesController');
    Route::post('calendar', 'TimesController@store');
    Route::post('workTimes', 'TimesController@show');
    Route::post('WorkCalendar', 'TimesController@WorkCalendar');


    /* End Of Times Routes
     * ***************************************************************************
     * ***************************************************************************
     * */

    /*
    * Consultations Routes
    * */
    Route::resource('consultations', 'ConsultationsController');
    Route::post('bookingNow', 'ConsultationsController@bookingNow');
    Route::post('my_consultations', 'ConsultationsController@my_consultations');
    Route::post('clients_consultations', 'ConsultationsController@clients_consultations');
    Route::post('my_prev_consultations', 'ConsultationsController@my_prev_consultations');
    Route::post('clients_prev_consultations', 'ConsultationsController@clients_prev_consultations');
    Route::post('changeStatus/{id}', 'ConsultationsController@updateStatus');

    /* End Of Times Routes
     * ***************************************************************************
     * ***************************************************************************
     * Filter
     * statistics
     * */

    Route::post('filter', 'HomeController@filter');
    Route::post('statistics', 'HomeController@index');

    /* End Of filter Routes
     * ***************************************************************************
     * ***************************************************************************
     * Favorites
     * */

    Route::resource('favorites', 'FavoritesController');
    Route::post('getFavorites', 'FavoritesController@index');

    /* End Of Favorites Routes
     * ***************************************************************************
     * ***************************************************************************
     * Chat
     * */

    Route::post('conversation', 'ChatController@index');
    Route::post('chat', 'ChatController@store');
    Route::post('chatInfo', 'ChatController@show');

    /**     PROJECT Routes **/
    Route::post('projects/show', 'ProjectController@show');
    Route::post('project/{id}', 'ProjectController@showproject');

    //Route::post('projects/add', 'ProjectController@addproject');
    Route::post('projects/', 'ProjectController@store');
    Route::post('projects/update/{id}', 'ProjectController@update');
    Route::post('projects/edit/{id}', 'ProjectController@edit');
    Route::post('myprojects/{id}', 'ProjectController@myproject');
    Route::post('projects/delete/{id}', 'ProjectController@destroy');

    Route::post('projects/filter', 'ProjectController@filter');

    ///project comments
    Route::post('comments/', 'ProjectController@storeComment');
    Route::post('comments/delete/{id}', 'ProjectController@destroyComment');

    Route::post('projects_types', 'ProjectController@projects_types');
    Route::post('projects_services', 'ProjectController@projects_services');

    Route::resource('projects', 'ProjectController');

});

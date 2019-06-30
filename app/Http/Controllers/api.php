<?php

Route::group(['middleware'=> 'lang'], function() {

    /*
     * Users Routes
     * */
    Route::post('login', 'UsersController@index');
    Route::post('logout', 'UsersController@logout');

    Route::resource('users', 'UsersController');
    Route::post('users/rating', 'UsersController@rating');
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
     * Countries Routes
     * */

    Route::resource('countries', 'CountriesController');

    /* End Of Countries Routes
     * ***************************************************************************
     * ***************************************************************************
     * Times Routes
     * */

    Route::resource('times', 'TimesController');
    Route::post('calendar', 'TimesController@store');
    Route::post('workTimes', 'TimesController@show');
    Route::post('WorkCalendar', 'TimesController@WorkCalendar');


    /* End Of Times Routes
     * ***************************************************************************
     * ***************************************************************************
     * Consultations Routes
     * */

    Route::resource('consultations', 'ConsultationsController_up');
    Route::post('consultations/show/{id}', 'ConsultationsController_up@show');
    Route::post('consultations/owner', 'ConsultationsController_up@store_for_me');
    Route::post('bookingNow', 'ConsultationsController_up@bookingNow');
    Route::post('my_consultations', 'ConsultationsController_up@my_consultations');
    Route::post('clients_consultations', 'ConsultationsController_up@clients_consultations');
    Route::post('my_prev_consultations', 'ConsultationsController_up@my_prev_consultations');
    Route::post('clients_prev_consultations', 'ConsultationsController_up@clients_prev_consultations');
    Route::post('changeStatus/{id}', 'ConsultationsController_up@updateStatus');

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

    /**PROJECT Routes **/
    Route::post('projects/show', 'ProjectController@show');
    Route::post('project/{id}', 'ProjectController@showproject');

    //Route::post('projects/add', 'ProjectController@addproject');
    Route::post('projects/store', 'ProjectController@store');
    Route::post('projects/update/{id}', 'ProjectController@update');
    Route::post('projects/edit/{id}', 'ProjectController@edit');
    Route::post('myprojects/{id}', 'ProjectController@myproject');
    Route::post('projects/delete/{id}', 'ProjectController@destroy');

    Route::post('projects/filter', 'ProjectController@filter');

    ///project comments
    Route::post('projectComments/store', 'ProjectController@storeComment');
    Route::post('projectComments/{id}', 'ProjectController@comments');
    Route::post('projectComments/delete/{id}', 'ProjectController@destroyComment');

    Route::post('projects_types', 'ProjectController@projects_types');
    Route::post('projects_services', 'ProjectController@projects_services');
    Route::post('acceptOffer/{id}', 'ProjectController@acceptOffer');
    Route::post('projectDone', 'ProjectController@projectDone');
    Route::post('projects/getAll', 'ProjectController@index');

    Route::resource('projects', 'ProjectController');

    /*
     * ***********************************************************
     * ***********************************************************
     * ******************** Studies Routes ***********************
     * */

    Route::resource('studies', 'StudiesController');
    Route::post('studies/mention', 'StudiesController@mention');
    Route::post('studies/show/{id}', 'StudiesController@show');
    Route::post('studies/store', 'StudiesController@store');
    Route::post('studies/update/{id}', 'StudiesController@update');
    Route::post('studies/delete/{id}', 'StudiesController@destroy');
    Route::post('studies', 'StudiesController@index');
    Route::post('userStudies', 'StudiesController@studies');
    Route::post('studies/types', 'StudiesController@study_types');

    /*  Study Comments */

    Route::post('study/comments', 'StudyCommentsController@index');
    Route::post('study/comment', 'StudyCommentsController@store');
    Route::post('study/comment/{id}', 'StudyCommentsController@destroy');
    Route::post('study/comment/{id}/accept', 'StudyCommentsController@accept');

    /*
     * ***********************************************************
     * ***********************************************************
     * ******************** Notifications Routes ***********************
     * */

    Route::resource('notifications', 'NotificationsController');
    Route::post('notifications', 'NotificationsController@index');
    Route::post('notification/seen/{id}', 'NotificationsController@seen');

    /*
    * ***********************************************************
    * ***********************************************************
    * ******************** Cash Transactions Routes ***********************
    * */

    Route::post('withdraw', 'CashTransactionsController@withdraw');
    Route::resource('transactions', 'CashTransactionsController');

});

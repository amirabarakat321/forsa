<?php

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index');


Route::post('/loginadmin', 'ManageuserController@loginadmin')->name('loginadmin');

/*
 * Users Routes
 * */
Route::get('users/clients', 'UsersController@clients');
Route::get('users/amateurs', 'UsersController@amateurs');
Route::get('users/experts', 'UsersController@experts');
Route::post('users/search', 'UsersController@search')->name('usersearch');
Route::get('users/status/{id}', 'UsersController@status');
Route::post('upgradeMark/{id}', 'UsersController@upgradeUser');
Route::post('sendNotifi/{id}', 'UsersController@sendNotifi');
Route::post('profile/{id}', 'UsersController@profile')->name('profile');

Route::resource('users', 'UsersController');

/*
 * End of users Routes
 * Specializations Routes
 * */

Route::get('specializations/delete/{id}', 'SpecializationsController@destroy')->name('deletespecialization');

Route::resource('specializations', 'SpecializationsController');

/*
 * End of Specializations Routes
 * countries Routes
 * */

Route::get('countries/delete/{id}', 'CountriesController@destroy');
Route::resource('countries', 'CountriesController');

/*
 * End of countries Routes
 * consultations Routes
 * */
Route::resource('consultations_categories', 'ConsultationsCategoriesController');
Route::get('/consultations_categories/status/{id}', 'ConsultationsCategoriesController@status');
Route::get('consultations/status/{id}', 'ConsultationsController@status');
Route::get('chatf', 'ChatController@index');
Route::get('/consultations_categories_destroy/{id}', 'ConsultationsCategoriesController@destroy');


Route::resource('consultations', 'ConsultationsController');



///// filter consultation
Route::get('consultation/filter','filterconsultation@index' )->name('filterview');
Route::post('consultation/filter','filterconsultation@filter' )->name('filter');
Route::get('consultation/view/{id}/{date}','filterconsultation@consultationview' )->name('consview');
Route::get('/study/{id}/destroy', 'studyController@delete');

/// main search consultation 
Route::post('consultation/searchcons','filterconsultation@searchcons' )->name('searchcons');



/*
 * project Routes
 * */

Route::resource('project', 'ProjectController');
Route::get('project', 'ProjectController@index')->name('projectindex');
Route::get('/project/{id}/{ty}/destroy', 'ProjectController@delete');
Route::get('/project/delete/{id}', 'ProjectController@deleteproject')->name('deleteproject');
Route::get('/projectstatus/{id}/{ty}', 'ProjectController@editstatue');
Route::get('project/{id}/show', 'ProjectController@projectview')->name('showproject');
Route::post('project/search', 'ProjectController@searchproject')->name('searchproject');

/*
 * project services Routes
 * */

Route::get('services', 'ProjectController@servicesindex')->name('servicesindex');
Route::post('services/add', 'ProjectController@addservice')->name('addservice');
Route::post('services/edit', 'ProjectController@editservice')->name('editservice');
Route::delete('services/delete/{id}', 'ProjectController@delService')->name('delService');

/*
 * project types Routes
 * */

Route::get('types', 'ProjectController@typesindex')->name('typesindex');
Route::post('types/add', 'ProjectController@addtype')->name('addtype');
Route::post('types/edit', 'ProjectController@edittype')->name('edittype');
Route::delete('types/delete/{id}', 'ProjectController@delType')->name('delType');

/////admin routes

Route::get('admins', 'AdminController@index')->name('adminview');
Route::post('admins/add', 'AdminController@addadmin')->name('addadmin');
Route::get('admins/{id}/statue', 'AdminController@editstatue');
Route::get('admins/{id}/delete', 'AdminController@delete');
Route::post('admins/edit', 'AdminController@edit')->name('editadmin');
Route::post('admins/search', 'AdminController@search')->name('searchadmin');
Route::resource('admin', 'AdminController');


Route::get('/chat/{id}/{type}/', 'ChatController@show')->name('showchat');
Route::post('chatload', 'ChatController@load_data')->name('loadmore');

Route::get('chatdownload/{id}', 'ChatController@download')->name('chatdownload');


Route::resource('chat', 'ChatController');

///// studies
Route::get('/study/{id}/destroy', 'studyController@delete');
Route::get('/studydestroy/{id}', 'studyController@destroy');
Route::get('/study/{id}/status', 'studyController@editstatus');
Route::get('/study/{id}/show', 'studyController@studyview')->name('studyview');
Route::post('study/search','studyController@search' )->name('searchstudy');

Route::resource('studies', 'studyController');
///study type
Route::get('studiestypes/status/{id}', 'studyTypeController@status');
Route::get('studiestypes/delete/{id}', 'studyTypeController@delete');
Route::post('studiestypesedit/', 'studyTypeController@update')->name('updatestudytype');


Route::resource('studiestypes', 'studyTypeController');
////supervisor
Route::get('Supervisor', 'SupervisorController@index')->name('Supervisorview');
Route::post('Supervisor/add', 'SupervisorController@addsupeervisor')->name('addSupervisor');
Route::get('Supervisor/{id}/statue', 'SupervisorController@editstatue');
Route::get('Supervisor/{id}/delete', 'SupervisorController@delete');
Route::post('Supervisor/edit', 'SupervisorController@edit')->name('editSupervisor');
Route::post('Supervisor/search', 'SupervisorController@search')->name('searchSupervisor');
Route::resource('Supervisor', 'SupervisorController');

//  massages
Route::get('inbox/{id}/status', 'massageController@editstatus');
Route::get('inbox/readMessage', 'massageController@readmessage');

Route::get('inbox/{id}/destroy', 'massageController@delete');
Route::get('inbox/{id}/delete', 'massageController@deletemessage');
Route::get('inbox/{id}/show', 'massageController@view')->name('messageview');
Route::post('send/email', 'massageController@mail')->name('sendmail');
Route::resource('inbox', 'massageController');

///notification
Route::post('notifications/add', 'notificationController@save')->name('addnotifi');
Route::get('notifications/{id}/delete', 'notificationController@delete');
Route::resource('notifications', 'notificationController');


/////tickets
Route::get('ticket/{id}/delete', 'TicketsController@delete');
Route::get('ticketchat/{id}', 'TicketsController@showchat');
Route::post('ticketchatload', 'TicketsController@load_dataticket')->name('ticketloadmore');
Route::resource('ticket', 'TicketsController');



/////wallet
Route::post('wallet/edit', 'WalletController@edit')->name('editwallet');
Route::post('wallet/recharge', 'WalletController@balancerecharge')->name('balancerecharge');
Route::post('balance/withdraw', 'WalletController@balancewithdraw')->name('balancewithdraw');
Route::post('wallet/search', 'WalletController@walletsearch')->name('balancesearch');
Route::get('wallet/withdraw', 'WalletController@indexwithdraw');

Route::resource('wallet', 'WalletController');


///setting
Route::post('setting/edit', 'SettingController@edit')->name('editsetting');
Route::resource('setting', 'SettingController');


Route::get('/phpfirebase_sdk','FirebaseController@index');
Route::resource('phpfirebase', 'FirebaseController');

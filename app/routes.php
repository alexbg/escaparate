<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*Route::get('/', function()
{
	return View::make('hello');
});*/

Route::get('/','HomeController@index');

Route::any('/login','HomeController@login');

Route::any('/register','HomeController@register');

Route::get('/logout','HomeController@logout');

Route::resource('brand','BrandController');

Route::resource('phone','PhoneController');

Route::resource('comment','CommentController');

Route::get('comment/create/{id}','CommentController@create');

Route::post('comment/store/{id}','CommentController@store');

Route::post('comment/{id}/edit','CommentController@edit');

Route::get('phone/create/{id}','PhoneController@create');

Route::get('/profile','HomeController@profile');

Route::get('/showPhones/{idBrand?}','HomeController@showPhones');

Route::any('/changePassword','HomeController@changePassword');

Route::any('/changeEmail','HomeController@changeEmail');

Route::get('/deleteUser','HomeController@deleteUser');

Route::any('/changeLanguage','HomeController@changeLanguage');

Route::post('/changeInformation','HomeController@changeInformation');

//Route::post('phone/store/{id}','PhoneController@store');
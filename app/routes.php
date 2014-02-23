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

Route::any('/login','UserController@login');

Route::any('/register','UserController@register');

Route::get('/logout','UserController@logout');

Route::get('/search','HomeController@search');

Route::resource('brand','BrandController');

Route::resource('phone','PhoneController');

Route::resource('comment','CommentController');

Route::get('comment/create/{id}','CommentController@create');

Route::post('comment/store/{id}','CommentController@store');

Route::post('comment/{id}/edit','CommentController@edit');

Route::get('phone/create/{id}','PhoneController@create');

Route::get('/profile','UserController@profile');

Route::get('/showPhones/{idBrand?}','HomeController@showPhones');

//Route::get('/showBrand/{idBrand?}','BrandController@showBrand');

Route::any('/changePassword','UserController@changePassword');

Route::any('/changeEmail','UserController@changeEmail');

Route::get('/deleteUser','UserController@deleteUser');

Route::any('/changeLanguage','UserController@changeLanguage');

Route::post('/changeInformation','UserController@changeInformation');

Route::get('/more','CommentController@more');

Route::get('/showPhonesByBrand/{id}','HomeController@showPhonesByBrand');

//Route::post('phone/store/{id}','PhoneController@store');
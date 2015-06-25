<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'TwilioController@index');
Route::get('/create', 'TwilioController@create');

Route::any('/call', 'TwilioController@call');
Route::any('/sms', 'TwilioController@sms');

Route::any('/code', 'TwilioController@code');
Route::any('/play', 'TwilioController@play');

Route::any('/dead', 'TwilioController@dead');
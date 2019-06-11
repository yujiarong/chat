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

// Route::get('/', function () {
//     return redirect('/dashboard');
// });

Route::group([
    'prefix'     => 'socialite',
    'as'         => 'socialite.',
    'namespace'  => 'Auth',
], function () {
	Route::get('redirect/{site}', 'SocialiteController@redirect')->name('redirect');
	Route::get('callback/{site}', 'SocialiteController@callback')->name('callback');
});

Auth::routes();
Route::get('/chat', 'HomeController@chat')->name('chat');
Route::get('/aichat', 'HomeController@aichat')->name('aichat');
Route::post('/chat_login', 'Auth\ChatLoginController@registerLogin')->name('chat.login');
Route::group(['middleware' => 'auth' ], function() {
	Route::get('/', 'HomeController@index')->name('/');
	Route::get('/dashboard', 'HomeController@index')->name('dashboard');
	includeRouteFiles(__DIR__.DIRECTORY_SEPARATOR.'Backend'.DIRECTORY_SEPARATOR);
});




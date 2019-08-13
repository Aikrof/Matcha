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
Route::group(['middleware' => ['auth', 'verified']], function(){
	Route::get('/', 'MainController@index');

	Route::post('/firstEntry', 'FirstEntryController@firstEntry');
	Route::post('/saveUserIcon', 'ImageController@userIcon');
	Route::post('/searchTag', 'TagsHelperController@tagWriter');

	Route::get('/{login}', [
		'uses' => 'Profile\ProfileController@getUserProfile'])->where(['login' => '^[A-Z].([a-z0-9-_])+$']);
	Route::post('/profileUpdate', 'Profile\UserProfileController@updateProfile');
});

Route::group(['as' => 'landing','prefix' => 'landing', 'namespace' => 'Auth'], function(){
	Route::get('', 'LandingController@landing');
});

Auth::routes(['verify' => true]);
Route::post('/resend', 'Auth\VerificationController@resend');
Route::post('/reset', 'Auth\ResetPasswordController@reset');
Route::post('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

// Route::post('/register', 'Auth\RegisterController@register');
// Route::post('/login', 'Auth\LoginController@login');
// Route::post('password/reset', 'Auth\ResetPasswordController@reset');
// Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// Route::post('logout', 'Auth\LoginController@logout')->name('logout');
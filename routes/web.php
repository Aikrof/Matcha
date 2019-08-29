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
	Route::post('/SuccessfulUserFirstEntry', 'FirstEntryController@SuccessfulUserFirstEntry');
	
	Route::post('/saveUserIcon', 'ImageController@userIcon');
	Route::post('/saveUserImg', 'ImageController@userImg');
	Route::post('/user/getImgs', 'ImageController@getImgs');

	Route::post('/searchTag', 'TagsHelperController@tagWriter');

	
	Route::get('/{login}', [
		'uses' => 'Profile\ProfileController@getUserProfile'])->where(['login' => '^[A-Z].([a-z0-9-_])+$']);

	Route::post('/profile/profileUpdate', 'Profile\UserProfileController@updateProfile');
	Route::post('/profile/removeBirthday', 'Profile\UserProfileController@removeBirthday');
	Route::post('/profile/removeTag', 'Profile\UserProfileController@removeTag');
	Route::post('/profile/removeLocation', 'Profile\UserProfileController@removeLocation');

	Route::post('/user/addComment', 'CommentController@addComment');
	Route::post('/user/getComments', 'CommentController@getComments');

	Route::post('/user/getCountLikes', 'LikeController@getCountLikes');
	Route::post('/user/getLikes', 'LikeController@getLikes');
	Route::post('/user/addLike', 'LikeController@addLike');
});

Route::group(['as' => 'landing','prefix' => 'landing', 'namespace' => 'Auth'], function(){
	Route::get('', 'LandingController@landing');
});

Auth::routes(['verify' => true]);
Route::post('/resend', 'Auth\VerificationController@resend');
Route::post('/reset', 'Auth\ResetPasswordController@reset');
Route::post('/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');

<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function viewSettings(Request $request)
    {
    	$title = 'Matcha :: Settings';

    	return (view('settings')->with(['title' => $title]));
    }

    public function changeLogin(Request $request)
    {
    	$this->validateData($request);

    	$user = User::find(Auth::user()->id);
    	$user->login = $request->new_login['login'];
    	$user->save();

    	return (json_encode(['changed' => true]));
    }

    public function changePassword(Request $request)
    {
    	$this->validateData($request);

    	$user = User::find(Auth::user()->id);
    	$user->password = Hash::make($request->new_password['new_password']);
    	$user->save();

    	return (json_encode(['changed' => true]));
    }

    public function changeEmail(Request $request)
    {
    	$this->validateData($request);

    	$user = User::find(Auth::user()->id);
    	$user->email = $request->new_email['email'];
    	$user->save();

    	return (json_encode(['changed' => true]));
    }

    protected function validateData(Request $request)
    {
    	if (!empty($request->new_login))
    	{
    		$validation = Validator::make($request->new_login, [
            	'login' => ['required', 'string', 'alpha_dash', 'between:4,24', 'unique:users'],
            	'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[0-9])(?=.*[^\w\s]).{8,}/'],
        	]);

        	$data = $request->new_login;
    	}
    	else if (!empty($request->new_password))
    	{
    		$validation = Validator::make($request->new_password, [
    			'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[0-9])(?=.*[^\w\s]).{8,}/'],
            	'new_password' => ['required', 'string', 'min:8', 'same:confirm', 'regex:/^(?=.*[a-z])(?=.*[0-9])(?=.*[^\w\s]).{8,}/'],
            	'confirm' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[0-9])(?=.*[^\w\s]).{8,}/'],
        	]);

        	$data = $request->new_password;
    	}
    	else if (!empty($request->new_email))
    	{
    		$validation = Validator::make($request->new_email, [
            	'email' => ['required', 'string', 'email', 'max:64', 'unique:users'],
            	'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[0-9])(?=.*[^\w\s]).{8,}/'],
        	]);

        	$data = $request->new_email;
    	}

        if ($validation->fails())
        {
            die(
                json_encode($validation->messages()->first())
            );
        }
        else if (!Hash::check($data['password'], Auth::user()->password))
        {
        	die(
        		json_encode('Password is not match this account')
        	);
        }
        else if (!empty($data['email']) && !User::checkEmailDomain($data['email']))
        {
        	die(
        		json_encode('Invalid email address')
        	);
        }
    }
}

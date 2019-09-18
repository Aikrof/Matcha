<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Info;
use App\BlockedUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class SettingsController extends Controller
{
    public function viewSettings(Request $request)
    {
    	$title = 'Matcha :: Settings';

        $blocked_users = BlockedUser::all();
        
        $data = collect();
        foreach ($blocked_users as $value){

            $user = User::find($value->blocked_user_id);
            $info = Info::find($user->id);

            $data = $data->push([
                'icon' => $info->icon === 'spy.png' ? '/img/icons/spy.png' : '/storage/' . $user->login . '/icon/' . $info->icon,
                'login' => ucfirst(strtolower($user->login)),
            ]);
        }
        
        $data = $data->paginate(10);

        return (view('settings', ['title' => $title,'data' => $data, 'param' => $request->all(), 'paginate' => $data]));
    }

    public function changeLogin(Request $request)
    {
    	$this->validateData($request);

        $old_login = Auth::user()->login;

    	$user = User::find(Auth::user()->id);
    	$user->login = $request->new_login['login'];
    	$user->save();

        $old_name = storage_path('app/public/' . $old_login . '/');

        if (file_exists(storage_path('app/public/' . $old_login)))
        {
            rename(
                $old_name,
                storage_path('app/public/' . $request->new_login['login'])
            );
        }

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

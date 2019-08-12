<?php

namespace App\Http\Controllers\Profile;

use Auth;
use App\User;
use App\Info;
use App\Location;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | User Profile Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling user page and act this user
    |
    */

    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile(Request $request)
    {
    	// abort(404);
    	$data = $this->creatArrInfo();

    	return (view('user_profile')->with('data', $data));
    }

    /**
     * Creating array with all user information
     *
     * @return array $data
     */
    private function creatArrInfo()
    {
    	$id = Auth::user()['id'];

    	$data = [
    		'user' => User::find($id),
    		'info' => Info::find($id),
    		'location' => Location::find($id)
    	];

    	return ($data);
    }
}

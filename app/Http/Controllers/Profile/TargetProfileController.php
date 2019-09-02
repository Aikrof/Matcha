<?php

namespace App\Http\Controllers\Profile;

use DB;
use App\Follow;
use Illuminate\Http\Request;
use App\Http\Controllers\Profile\ProfileController;

class TargetProfileController extends ProfileController
{
	/*
    |--------------------------------------------------------------------------
    | Target Profile Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling target user page and act this user
    |
    */

    /**
    * Show the target user profile page.
    *
    * @param  \Illuminate\Http\Request  $request
    * @var string user $login
    * @return \Illuminate\Http\Response
    */
    public function getProfile(Request $request, String $login)
    {
    	$select = DB::select('SELECT `id` FROM `users` WHERE `login` = "' . $login . '"');

    	if (empty($select))
    		abort(404);

    	$id = $select[0]->id;

        Follow::firstOrCreate([
            'followers_id' => $request->user()->id,
            'following_id' => $id,
        ]);
        
    	$data = $this->createArrInfo($id, $login);
    	return (view('target_profile')->with('data', $data));
    }
}

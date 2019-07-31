<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Profile\UserProfileController;
use App\Http\Controllers\Profile\TargetProfileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function getUserProfile(Request $request, $login)
    {
    	$title = [
    		'title' => env('APP_NAME') . ' -> ' . $login,
    	];
    	
    	if (ucfirst(strtolower($request->user()['login'])) === $login)
    		return ((new UserProfileController())->getProfile($request)->with($title));
    	else
    		return ((new TargetProfileController())->getProfile($request));
    }
}

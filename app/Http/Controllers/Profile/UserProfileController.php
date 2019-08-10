<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
    public function getProfile(Request $request)
    {
    	// abort(404);
    	return (view('user_profile'));
    }
}

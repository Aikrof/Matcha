<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TargetProfileController extends Controller
{
    public function getProfile()
    {
    	return (view('target_profile'));
    }
}

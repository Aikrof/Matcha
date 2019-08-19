<?php

namespace App\Helper;

use App\User;

class ProfileAddRatingHelper
{
	/*
    |--------------------------------------------------------------------------
    | Profile Add Rating Helper
    |--------------------------------------------------------------------------
    |
    | This class is responsible for calc and save user rating
    */

	/**
    * Updates user  rating instance.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  double $rating
    * @return void
    */
    public static function addToRating($user_id, $rating)
    {
        $user = User::find($user_id);
        $user->rating += $rating;
        $user->save();
    }
}


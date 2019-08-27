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
    * The constant array with rating points.
    *
    * @var array
    */
    const RATING = [
        'orientation' => 0.5,
        'age' => 0.5,
        'about' => 0.5,
        'birthday' => 0.5,
        'interests' => 0.5,
        'location' => 0.5,
        'icon' => 1,
        'comment' => 0.1,
        'like' => 0.1,
    ];
	/**
    * Updates user rating instance.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  double $rating
    * @return void
    */
    public static function addToRating($user_id, $name)
    {
        // if (!self::checkRating($user_id, $name))
        //     return;

        $user = User::find($user_id);
        $user->rating += self::RATING[$name];
        $user->save();
    }
}


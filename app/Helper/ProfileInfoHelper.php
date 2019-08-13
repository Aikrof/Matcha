<?php

namespace App\Helper;

use App\Info;
use Illuminate\Support\Facades\Validator;

class ProfileInfoHelper
{
	/*
    |--------------------------------------------------------------------------
    | Info Helper
    |--------------------------------------------------------------------------
    |
    | This class is responsible for validate user data
    */

    public static function validateInfo($data)
    {
        $validation = Validator::make($data, [
            'first_name' => ['string', 'max:20', 'alpha'],
            'last_name' => ['required', 'string', 'max:20', 'alpha'],
            'age' => ['max:2', 'integer']
        ]);

        if ($validation->fails())
            exit;
    }
}
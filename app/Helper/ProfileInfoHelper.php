<?php

namespace App\Helper;

use DB;
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

    public static function validateRequest($data, $user_id)
    {
        $validation = Validator::make($data, [
            'first_name' => ['string', 'max:20', 'alpha'],
            'last_name' => ['string', 'max:20', 'alpha'],
            'age' => ['max:2'],
        ]);

        if ($validation->fails())
        {
            echo"<pre>"; 
            var_dump(123);
            exit;
            exit;
        }

        if (isset($data['birthday']) && !self::validateBirthday($data, $user_id))
            exit;
        else if (isset($data['interests']))
            self::validateInterests($data['interests']);
    }

    public static function validateBirthday($data, $user_id)
    {   
        $birthday = $data['birthday'];

       if (!empty($birthday['month']) &&
            (is_numeric($birthday['day']) && ($birthday['day'] > 0 && $birthday['day'] <= 31)) &&
            is_numeric($birthday['year']))
        {
            $select = DB::select('SELECT `age` FROM `infos` WHERE `id` = ' . $user_id);
            $age = $select[0]->age;
            
            if (!empty($age))
            {
                $year = $birthday['year'] + $age;
                $birthday = ($year === (int)date('Y')) ? $birthday : null;
                if (empty($birthday))
                    return (false);
            }
            else
            {
                $birthday = date('Y') - $birthday['year'] >= 65 ? null : $birthday;
            }
        }
        else
            return (false);
    }

    public static function validateInterests($interests)
    {

    }
}
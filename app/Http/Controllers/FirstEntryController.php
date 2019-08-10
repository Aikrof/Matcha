<?php

namespace App\Http\Controllers;

use DB;
use App\Info;
use App\User;
use App\Location;
use App\Rating;
use Illuminate\Http\Request;

class FirstEntryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FirstEntry Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the first entry info about user
    | like user age, birthday, sexual orientation, information of user interests, and location.
    |
    */


    /**
    * Handle a user data request for the application.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    public function firstEntry(Request $request)
    {
        $this->SuccessfulUserFirstEntry($request);

    	$info = $this->validateRequest($request);

        $this->userAddInfo($request, $info);
        $this->createRating($request, $info);
        $this->createLocation($request, $info);
        exit();
    }

    /**
    * Validation an incoming data request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array $info
    */
    protected function validateRequest(Request $request)
    {
    	$info = [];

    	$info['orientation'] = !empty($request->orientation) ? 
                                lcfirst($request->orientation) : null;
    	$info['age'] = (is_numeric($request->age) &&
                        ($request->age > 10)) ? $request->age : 0;

    	if (!empty($request->birthday['month']) &&
            (is_numeric($request->birthday['day']) && ($request->birthday['day'] > 0 && $request->birthday['day'] <= 31)) &&
            is_numeric($request->birthday['year']))
    	{
    		if (!empty($info['age']))
    		{
                $year = $request->birthday['year'] + $request->age;
 
    			$info['birthday'] = ($year === (int)date('Y') || $year - 1 === (int)date('Y')) ? $request->birthday : null;
    			if (empty($info['birthday']))
    				$info['age'] = null;
    		}
    		else
    			$info['birthday'] = date('Y') - $request->birthday['year'] >= 100 ? null : $request->birthday;
    	}
    	else
    		$info['birthday'] = null;

    	if (!empty($request->location['latitude']) && !empty($request->location['longitude']))
    	{
    		$info['location'] = $request->location;
    	}
    	else
    		$info['location'] = null;

    	if (!empty($request->interests))
    	{
    		$interests = explode('#', $request->interests);
    		
    		$interests[0] = null;

    		foreach ($interests as $key => $value){
    			if ($value === "")
    				unset($interests[$key]);
    		}

    		$info['interests'] = !empty($interests) ? implode('#', $interests) : null;
    	}
    	else
    		$info['interests'] = null;

    	$info['about'] = !empty($request->about) ? $request->about : NULL;


    	return ($info);
    }

    /**
    * Add data to info table.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param   array $ifno 
    * @return void
    */
    protected function userAddInfo(Request $request, array $info)
    {
        $user_info = Info::find($request->user()['id']);
        $user_info->update([
            'orientation' => ($info['orientation'] !== null) ? $info['orientation'] : 'bisexual',
            'age' => $info['age'],
            'birthday' => $this->yearConversion($info['birthday']),
            'interests' => $info['interests'],
            'about' => $info['about']
        ]);
        $user_info->save();
    }


    /**
    * Remember the first user entrance add.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return void
    */
    private function SuccessfulUserFirstEntry(Request $request)
    {
        DB::update('update `users` set first_entry = false WHERE `id` = ?', [$request->user()['id']]);
    }

    /**
    * Conversion user birthday into string numeric date.
    *
    * @param  array  $birthday
    * @return string $birthday
    */
    private function yearConversion($birthday)
    {
        if (!$birthday)
            return (NULL);

        $month = [
            'January', 'February', 'March', 'April', 'May',
            'June', 'July', 'August', 'September', 'October',
            'November', 'December'
        ];

        foreach ($month as $key => $value){
            if ($birthday['month'] == $value)
            {
                $birthday['month'] = ($key + 1 < 10) ? '0' . ($key + 1) : $key + 1;
                break;
            }
        }
        return (implode('-', $birthday));
    }

    /**
    * Create a new location instance.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  array $info
    * @return void
    */
    protected function createLocation(Request $request, array $info)
    {
        $user_access = true;

        if (empty($info['location']))
        {
            $info['location'] = $this->getUserLocation($request->ip());
            $user_access = false;
        }

        Location::create([
            'id' => $request->user()['id'],
            'latitude' => $info['location']['latitude'],
            'longitude' => $info['location']['longitude'],
            'user_access' => $user_access,
        ]);
    }

    /**
    * Get user location if he did not indicate.
    *
    * @param  user ip $ip
    * @return array location cords 
    */
    private function getUserLocation($ip)
    {
        $query = @unserialize (file_get_contents('http://ip-api.com/php/'));

        return ([
            'latitude' => $query['lat'],
            'longitude' => $query['lon'],
        ]);
    }

    /**
    * Count the rating and create a new rating instance.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  array $info
    * @return void
    */
    protected function createRating(Request $request, array $info)
    {
        $rating = 0.0;

        foreach ($info as $key => $value){
            if ($value)
            {
                if ($key === 'location')
                    $rating += 2;
                else
                    $rating += 0.5;
            }
        }

        Rating::create([
            'id' => $request->user()['id'],
            'rating' => $rating
        ]);
    }
}

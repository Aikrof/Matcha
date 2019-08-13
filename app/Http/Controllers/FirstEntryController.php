<?php

namespace App\Http\Controllers;

use DB;
use App\Info;
use App\User;
use App\Location;
use App\Tags;
use Illuminate\Http\Request;

class FirstEntryController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | First Entry Controller
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
        // $this->SuccessfulUserFirstEntry($request);

    	$info = $this->validateRequest($request);

        $this->userAddInfo($request, $info);
        $this->createRating($request, $info);
        $this->createLocation($request, $info);
        $this->addTags($request, $info);
        exit;
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
                                $request->orientation : null;
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
    		$interests = array_unique(explode('#', $request->interests));
    		
    		$interests[0] = null;

    		foreach ($interests as $key => $value){
    			if ($value === "")
    				unset($interests[$key]);
                else if($value)
                {
                    $info['tags'][$key] = $value;
                    $interests[$key] = $value . "  ";
                }
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
            'orientation' => ($info['orientation'] !== null) ? $info['orientation'] : 'Bisexual',
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
    * Conversion array user birthday into string.
    *
    * @param  array  $birthday
    * @return string $birthday
    */
    private function yearConversion($birthday)
    {
        if (!$birthday)
            return (NULL);

        return (implode('-', [
            'month' => $birthday['month'],
            'day' => $birthday['day'],
            'year' => $birthday['year']
        ]));
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
            $info['location'] = $this->getUserLocation();
            $user_access = false;
        }

        Location::create([
            'id' => $request->user()['id'],
            'latitude' => $info['location']['latitude'],
            'longitude' => $info['location']['longitude'],
            'country' => $info['location']['country'],
            'city' => $info['location']['city'],
            'user_access' => $user_access,
        ]);
    }

    /**
    * Get user location if he did not indicate.
    *
    * @return array location cords 
    */
    private function getUserLocation()
    {
        $query = @unserialize (file_get_contents('http://ip-api.com/php/'));

        return ([
            'latitude' => $query['lat'],
            'longitude' => $query['lon'],
            'country' => $query['country'],
            'city' => $query['city'],
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

        $user = User::find($request->user()['id']);
        $user->rating = $rating;
        $user->save();
    }

    /**
    * Add user interests in to tags table.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  array $info
    * @return void
    */
    private function addTags(Request $request, $info)
    {
        if (!$info['interests'])
            return;

        foreach ($info['tags'] as $value) {
            $tag = Tags::firstOrNew(['tag' => $value]);
            $tag->count += 1;
            $tag->save();
        }
    }
}

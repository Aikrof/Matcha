<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Location;
use App\Interests;
use Illuminate\Http\Request;

class FirstEntryController extends Controller
{
    public function firstEntry(Request $request)
    {
        // $this->SuccessfulUserFirstEntry($request);

    	$info = $this->validateRequest($request);

        $this->userAddInfo($request, $info);
        $this->creatLocation($request, $info);
        $this->creatInterests($request, $info);
    }

    protected function validateRequest(Request $request)
    {
    	$info = [];

    	$info['orientation'] = !empty($request->orientation) ? 
                                lcfirst($request->orientation) : 'bisexual';
    	
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

    protected function userAddInfo(Request $request, $info)
    {
        $request->info()->fill([
            'id' => $request->user()['id'],
            'orientation' => $info['orientation'],
            'age' => $info['age'],
            'birthday' => $this->yearConversion($info['birthday']),
            'about' => $info['about']
        ]);
        $request->user()->save();
    }

    private function SuccessfulUserFirstEntry(Request $request)
    {
        DB::update('update `users` set first_entry = false WHERE `id` = ?', [$request->user()['id']]);
    }

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

    protected function creatLocation(Request $request, $info)
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

    private function getUserLocation($ip)
    {
        $query = @unserialize (file_get_contents('http://ip-api.com/php/'));

        return ([
            'latitude' => $query['lat'],
            'longitude' => $query['lon'],
        ]);
    }

    protected function creatInterests(Request $request, $info)
    {
        Interests::create([
            'id' => $request->user()['id'],
            'interests' => $info['interests'],
        ]);
    }
}

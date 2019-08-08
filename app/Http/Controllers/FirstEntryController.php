<?php

namespace App\Http\Controllers;

use App\User;
use App\Location;
use App\Interests;
use Illuminate\Http\Request;

class FirstEntryController extends Controller
{
    public function firstEntry(Request $request)
    {
    	$info = $this->validateRequest($request);
    	echo"<pre>"; 
    	var_dump($info);
    	exit;
    }

    protected function validateRequest(Request $request)
    {
    	$info = [];

    	$info['orient'] = $request->orient;
    	
    	$info['age'] = is_numeric($request->age) ? $request->age : null;

    	if (!empty($request->birthday['month']) && is_numeric($request->birthday['day']) &&
    		is_numeric($request->birthday['year']))
    	{
    		if (!empty($info['age']))
    		{
    			$info['birthday'] = date('Y') - $request->age === $request->birthday['year'] ? $request->birthday : null;
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

    	$info['about'] = !empty($request->about) ? $request->about : null;


    	return ($info);
    }
}

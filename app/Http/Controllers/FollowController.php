<?php

namespace App\Http\Controllers;

use App\User;
use App\Info;
use App\Follow;
use App\Interests;
use App\Location;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function getFollowing(Request $request)
    {
    	$title = [
    		'title' => 'Matcha' . ' :: Following'
    	];

    	$data = [];

    	foreach (Follow::where('followers_id', $request->user()->id)->cursor() as $follow){

    		$user = User::find($follow->following_id);
    		$info = Info::find($follow->following_id);

    		$userInfo = $this->getUserInformation($follow->following_id);

    		array_push($data, $userInfo);
		}
		
		return (view('following')->with($title)->with('data', $data));
    }

    public function getFollowers(Request $request)
    {
    	echo"<pre>"; 
    	var_dump('folowers');
    	exit;
    }

    private function getUserInformation(int $user_id)
    {
    	$user = User::find($user_id);
    	$info = Info::find($user_id);
    	$interests = Interests::find($user_id);
    	$location = Location::find($user_id);

    	return ([
    		'icon' => $info->icon === 'spy.png' ? '/img/icons/spy.png' : '/storage/' . $user->login . '/icon/' . $info->icon,
    		'login' => $user->login,
    		'rating' => $user->rating,
    		'gender' => $info->gender,
    		'orientation' => $info->orientation,
    		'about' => $info->about,
    		'interests' => explode(',', $interests->tags),
    		'location' => $location->user_access == 1 ? [
    			'country' => $location->country,
    			'city' => $location->city
    		] : null,
    	]);
    }
}

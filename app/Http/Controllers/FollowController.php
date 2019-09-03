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
    	$title =  'Matcha' . ' :: Following';

    	$data = [];

    	foreach ($paginate = Follow::where('followers_id', $request->user()->id)->paginate(10) as $follow){

    		$user = User::find($follow->following_id);
    		$info = Info::find($follow->following_id);

    		$userInfo = $this->getUserInformation($follow->following_id);

    		array_push($data, $userInfo);
		}

		return (view('follow', ['title' => $title, 'section' => 'following','data' => $data, 'paginate' => $paginate]));
    }

    public function getFollowers(Request $request)
    {
    	$title = 'Matcha' . ' :: Followers';

        $data = [];

        $additional_data = self::getAdditionDataRequest($request);

        foreach ($paginate = Follow::where('following_id', $request->user()->id)->paginate(10) as $follow){

            $user = User::find($follow->followers_id);
            $info = Info::find($follow->followers_id);

            $userInfo = $this->getUserInformation($follow->followers_id);

            array_push($data, $userInfo);
        }
        
        return (view('follow', ['title' => $title, 'section' => 'followers','data' => $data, 'additional_data' => $additional_data, 'paginate' => $paginate]));
    }

    private function getUserInformation(int $user_id)
    {
    	$user = User::find($user_id);
    	$info = Info::find($user_id);
    	$interests = Interests::find($user_id);
    	$location = Location::find($user_id);

    	return ([
    		'icon' => $info->icon === 'spy.png' ? '/img/icons/spy.png' : '/storage/' . $user->login . '/icon/' . $info->icon,
            'backgroundImg' => $user->backgroundImg,
    		'login' => ucfirst(strtolower($user->login)),
            'age' => $info->age,
    		'rating' => $user->rating,
    		'gender' => $info->gender,
    		'orientation' => $info->orientation,
    		'about' => $info->about,
    		'interests' => empty($interests) ? null : explode(',', $interests->tags),
    		'location' => $location->user_access == 1 ? [
    			'country' => $location->country,
    			'city' => $location->city
    		] : null,
    	]);
    }

    private static function getAdditionDataRequest(Request $request)
    {
        return ([
            'sorted' => $request->all()['sorted'],
            'filtered' => empty($request->all()['filtered']) ? null :  $request->all()['filtered']
        ]);
    }
}

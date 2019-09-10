<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Info;
use App\Follow;
use App\Interests;
use App\Location;
use Illuminate\Http\Request;

use Location\Line;
    use Location\Coordinate;
    use Location\Distance\Haversine;

class FollowController extends Controller
{
    public function getFollowing(Request $request)
    {
    	$title =  'Matcha' . ' :: Following';

    	$data = [];

        $additional_data = self::getAdditionDataRequest($request);

        $paginate = DB::table('follows')->select('following_id')->join('locations', 'locations.id', '=', 'follows.followers_id')->where('locations.city', 'Kyiv')->paginate(10);

    	foreach ($paginate = Follow::where('followers_id', $request->user()->id)->paginate(10) as $follow){

    		$user = User::find($follow->following_id);
    		$info = Info::find($follow->following_id);

    		$userInfo = $this->getUserInformation($follow->following_id);

    		array_push($data, $userInfo);
		}

		return (view('follow', ['title' => $title, 'section' => 'following','data' => $data, 'additional_data' => $additional_data, 'paginate' => $paginate]));
    }

    public function getFollowers(Request $request)
    {	
        $request_data = self::getAdditionDataRequest($request);

        $title = 'Matcha' . ' :: Followers';

        $data = [];

        $select = DB::table('follows')
                ->where('following_id', $request->user()->id)
                ->select('follows.followers_id', 'infos.icon', 'users.login', 'infos.age', 'users.rating', 'infos.first_name', 'infos.last_name', 'infos.about', 'interests.tags', 'locations.latitude', 'locations.longitude', 'locations.country', 'locations.city', 'locations.user_access')
                ->join('locations', 'locations.id', '=', 'follows.followers_id')
                ->join('infos', 'infos.id', '=', 'follows.followers_id')
                ->join('users', 'users.id', '=', 'follows.followers_id')
                ->join('interests', 'interests.id', '=', 'follows.followers_id')
                ->whereBetween('infos.age', [$request_data['filter']['age']['min'], $request_data['filter']['age']['max']])
                ->whereBetween('users.rating', [$request_data['filter']['rating'], '100'])
                ->get();

        $user_location = Location::find($request->user()->id);
        
        foreach ($select as $key => $value){

           if (!empty($request_data['filter']['distance']))
            {
                if ($value->user_access === 1)
                {
                    $distance = new Line(
                            new Coordinate($value->latitude, $value->longitude),
                            new Coordinate($user_location->latitude, $user_location->longitude)
                    );
                    $distance = (int)$distance->getLength(new Haversine());
                    echo"<pre>"; 
                    var_dump($distance);
                    exit;
                }
                else
                {
                    unset($select[$key]);
                }
            }
        }

        $paginate = $select->paginate(10);

        foreach ($paginate as $follow){

            $user = User::find($follow->followers_id);
            $info = Info::find($follow->followers_id);

            $userInfo = $this->getUserInformation($follow->followers_id);

            array_push($data, $userInfo);
        }
        
        return (view('follow', ['title' => $title, 'section' => 'followers','data' => $data, 'additional_data' => $request_data, 'paginate' => $paginate]));
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
    		'first_name' => $info->first_name,
    		'last_name' => $info->last_name,
    		'about' => $info->about,
    		'interests' => empty($interests) ? null : explode(',', $interests->tags),
    		'location' => $location->user_access == 1 ? [
    			'country' => $location->country,
    			'city' => $location->city
    		] : null,
    	]);
    }

    protected static function getAdditionDataRequest(Request $request)
    {
        return ([
            'sort' => self::validateSortRequest($request->sort),
            'filter' => self::validateFilterRequest($request->filter),
        ]);
    }

    protected static function validateSortRequest($sort)
    {
        return ([
            'priority' => empty($sort['priority']) ? 'location' : $sort['priority'],
            'interests' => empty($sort['interests']) ? null : $sort['interests'],
            'sorted_by' =>  empty($sort['sorted_by']) ? 'ASC' : $sort['sorted_by'],
        ]);
    }

    protected static function validateFilterRequest($filter)
    {
        return ([
            'age' => self::getRequestAge($filter),
            'distance' => self::getRequestDistance($filter),
            'rating' => self::getRequestRating($filter),
            'interests' => empty($filter['interests']) ? null : $filter['interests'],

        ]);
    }

    protected static function getRequestAge($filter)
    {
        if (empty($filter['age']))
            $age = null;
        else
            $age = explode('-', $filter['age']);

        if (empty($age) || ((!is_numeric($age[0]) ||
            !is_numeric($age[1])) ||
            (int)$age[0] > (int)$age[1]) ||
            ((int)$age[0] < 10 || (int)$age[1] > 60))
        {
            return ([
                'min' => '0',
                'max' => '60',
            ]);
        }
        else
        {
            return ([
                'min' => $age[0],
                'max' => $age[1],
            ]);
        }
    }

    protected static function getRequestDistance($filter)
    {
        if (empty($filter['distance']))
            $distance = null;
        else
            $distance = explode('-', $filter['distance']);

        if (empty($distance) ||
            ((!is_numeric($distance[0]) ||
            !is_numeric($distance[1])) ||
            (int)$distance[0] > (int)$distance[1]))
        {
            return (null);
        }
        else
        {
            return ([
                'min' => $distance[0],
                'max' => $distance[1],
            ]);
        }
    }

    protected static function getRequestRating($filter)
    {
        if (empty($filter['rating']) ||
            (!is_numeric($filter['rating']) ||
                $filter['rating'] < 0 ||
                $filter['rating'] > 100))
        {
            return ('0');
        }
        else
        {
            return ($filter['rating']);
        }
    }
}

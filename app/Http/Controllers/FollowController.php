<?php

namespace App\Http\Controllers;

use DB;
use App\Location;
use App\Helper\RangeHelper;
use App\Helper\FilterSearchHelper as Filter;
use App\Helper\SortSearchHelper as Sort;
use Illuminate\Http\Request;


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
        $title = 'Matcha' . ' :: Followers';

        $query = self::supplementUserInfo(
                    self::getFollowQuery(
                        'following_id',
                        $request->user()->id,
                        'follows.followers_id'
                    ),
                Location::find($request->user()->id),
                $request->sort
            );

        $query = Sort::sortData(
                Filter::filterData($query,$request->filter),
                $request->sort
            );

        $data = $query->paginate(5);

        return (view('follow', ['title' => $title, 'section' => 'followers','data' => $data, 'param' => $request->all(), 'paginate' => $data]));
    }

    protected static function supplementUserInfo($query, $user_location, $sort)
    {
        $range = new RangeHelper();

        foreach ($query as $value){
            $value->icon = $value->icon === 'spy.png' ? '/img/icons/spy.png' : '/storage/' . $value->login . '/icon/' . $value->icon;
            $value->login = ucfirst(strtolower($value->login));
            $value->tags = empty($value->tags) ? null : explode(',', $value->tags);

            if (!isset($sort['sorted_by']) || $sort['sorted_by'] !== 'DESC')
                $value->age = $value->age === 0 ? 999 : $value->age;
            
            $value->rating = (string)$value->rating;

            $value->distance = (string)($range->getDistance(
                $value->latitude,
                $value->longitude,
                $user_location->latitude,
                $user_location->longitude
            ) / 1000);
        }

        return ($query);
    }

    protected static function getFollowQuery(String $search_id, $user_id, $take_id)
    {
        return (
            DB::table('follows')
                ->where($search_id, $user_id)
                ->select($take_id, 'infos.icon', 'users.login', 'infos.age', 'users.rating', 'infos.first_name', 'infos.last_name', 'infos.about', 'interests.tags', 'locations.latitude', 'locations.longitude', 'locations.country', 'locations.city', 'locations.user_access')
                ->join('locations', 'locations.id', '=', $take_id)
                ->join('infos', 'infos.id', '=', $take_id)
                ->join('users', 'users.id', '=', $take_id)
                ->join('interests', 'interests.id', '=', $take_id)
                ->get()
        );
    }
}

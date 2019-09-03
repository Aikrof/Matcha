<?php

namespace App\Http\Controllers;

use App\Likes;
use App\Info;
use App\User;
use App\Imgs;
use App\Helper\ProfileAddRatingHelper as ProfileRating;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function getCountLikes(Request $request)
    {
        exit (json_encode(
            Likes::where('img', $request->img)->count()
        ));
    }

    public function getLikes(Request $request)
    {
        $likes = Likes::where('img', $request->img)->get();

        if (empty($likes[0]))
        	exit (json_encode(['empty' => 'There are no likes yet']));

        $data = [];

        foreach ($likes as $key => $value){
            $info = Info::find($value->id);
            $user = User::find($value->id);

            $icon = $info->icon === 'spy.png' ? '/img/icons/spy.png' : '/storage/' . $user->login . '/icon/' . $info->icon;

            array_push($data, [
                'icon' => $icon,
                'login' => ucfirst(strtolower($user->login)),
            ]);
        }
        
        exit (json_encode(['data' => $data]));
    }

    public function addLike(Request $request)
    {
    	$target_id = (int)base64_decode($request->like['id']);

    	if ($request->user()->id == $target_id)
    		exit;

        $info = Info::find($request->user()->id);
        $user = User::find($request->user()->id);

        if ($this->checkIfUserLike($request->like['img'], $request->user()->id))
        {
            ProfileRating::removeFromRating($target_id, 'like');
               
            Likes::where('img', $request->like['img'])->where('id', $request->user()->id)->delete();

            exit(json_encode(['remove' => ['login' => $user->login]]));
        }
        else
        {
            ProfileRating::addToRating($target_id, 'like');

            Likes::create([
                'id' => $request->user()->id,
                'img' => $request->like['img']
            ]);

            exit(json_encode(['add' => [
                'icon' => $info->icon === 'spy.png' ? '/img/icons/spy.png' : '/storage/' . $user->login . '/icon/' . $info->icon,
                'login' => $user->login
            ]]));
        }
    }

    private function checkIfUserLike(string $img, int $user_id)
    {
        $likes = Likes::where('img', $img)->where('id', $user_id)->first();

        return (!empty($likes));
    }
}

<?php

namespace App\Http\Controllers;

use App\Likes;
use App\Info;
use App\User;
use App\Imgs;
use App\Helper\ProfileAddRatingHelper as Rating;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function getLikes(Request $request)
    {
    	$img = $request->img;
        $likes = Likes::find($img);
        
        if (empty($likes))
        	exit (json_encode(['empty' => 'There are no likes yet']));
        
        $info = Info::find($likes->id);
        $user = User::find($likes->id);

        $icon = $info->icon === 'spy.png' ? '/img/icons/spy/png' : '/storage/' . $user->login . '/icon/' . $info->icon;

        exit (json_encode([
            'icon' => $icon,
            'login' => $user->login
        ]));
    }

    public function addLike(Request $request)
    {
    	$taget_id = (int)base64_decode($request->like['id']);

    	if ($request->user()->id == $taget_id)
    		exit;
    	
    	
    }
}

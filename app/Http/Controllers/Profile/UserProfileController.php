<?php

namespace App\Http\Controllers\Profile;

use File;
use Auth;
use App\User;
use App\Info;
use App\Location;
use App\Interests;
use App\Birthday;
use App\Tags;
use App\Img;
use App\Helper\ProfileInfoHelper as ProfileHelper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserProfileController extends Controller
{
	/*
    |--------------------------------------------------------------------------
    | User Profile Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling user page and act this user
    |
    */

    /**
     * Show the user profile page.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProfile(Request $request)
    {
    	// abort(404);
    	$data = $this->createArrInfo();

    	return (view('user_profile')->with('data', $data));
    }

    /**
     * Creating array with all user information
     *
     * @return array $data
     */
    private function createArrInfo()
    {
    	$id = Auth::user()['id'];

    	$data = [
    		'user' => User::find($id),
    		'info' => Info::find($id),
            'interests' => Interests::find($id),
    		'location' => Location::find($id),
            'birthday' => Birthday::find($id),
            'img' => $this->getBaseImg($id),
    	];

        if (!empty($data['interests']))
            $data['interests'] = array_reverse(explode(',', $data['interests']->tags));

        if ($data['info']['icon'] !== 'spy.png')
            $file_path = storage_path('app/profiles/' . Auth::user()['login'] . '/icon/' . $data['info']['icon']);
        else
            $file_path = public_path('img/icons/spy.png');

        if (!empty($data['birthday']) && $this->checkBirthday($data['birthday']))
            $data['birthday'] = null;

        $contents = file_get_contents($file_path);
        $mime_type = File::mimeType($file_path);
        $base = "data:image/" . $mime_type . ";base64," . base64_encode($contents);
        $data['info']['icon'] = $base;
    	
        return ($data);
    }

    private function getBaseImg(int $id)
    {
        $user_imgs = Img::find($id);
        
        if (empty($user_imgs))
            return (null);

        $file_path = storage_path('app/profiles/' . Auth::user()['login'] . '/');
        $img = explode(',', $user_imgs->img);
        $data = [];

        foreach ($img as $value){
            $img_path = $file_path . $value;

            $contents = file_get_contents($img_path);
            $mime_type = File::mimeType($img_path);

            array_push($data, "data:image/" . $mime_type . ";base64," . base64_encode($contents));
        }
        return ($data);
    }

    private function checkBirthday($birthday)
    {
        return (
            in_array(null,
                ['day' => $birthday->day,
                'month' => $birthday->month,
                'year' => $birthday->year
            ])
        );
    }


    public function updateProfile(Request $request)
    {
        $key = key($request->all());
        $user_id = $request->user()->id;

        $data[$key] = ProfileHelper::validateRequest($request->all(), $user_id);

        if ($key === 'birthday')
        {
            exit($this->updateBirthday($data, $user_id));
            $user = Birthday::find($request->user()->id);
            
        }
        else if ($key === 'location')
        {
            exit($this->updateLocation($data, $user_id));
            $user = Location::find($request->user()->id);
        }
        else if ($key === 'interests')
        {
            exit($this->updateInterests($data, $user_id));
            $user = Interests::find($request->user()->id);
            $tag = Tags::firstOrNew(['tag' => $data['interests'][0]]);
            $tag->count++;
            $tag->save();

        }
        else
        {
            exit($this->updateInfo($data, $key, $user_id));
            $user = Info::find($request->user()->id);
            $user->$key = $data[$key];
        }

        $user->save();
    }

    public function removeBirthday(Request $request)
    {
        $birthday = Birthday::find($request->user()->id);

        $birthday->day = null;
        $birthday->month = null;
        $birthday->year = null;

        $birthday->save();
    }

    public function removeTag(Request $request)
    {
        $interests = Interests::find($request->user()->id);

        if (empty($interests->tags))
            exit;

        $search =  Tags::where('tag', $request->tag)->first();
        $search->count--;
        if (!$search->count)
            $search->delete();
        else
            $search->save();

        $tags = explode(',', $interests->tags);
        $remove_element = array_search($request->tag, $tags);
        unset($tags[$remove_element]);
        $interests->tags = implode(',', $tags);
        
        $interests->save();
        exit;
    }

    public function removeLocation(Request $request)
    {
        $location = Location::find($request->user()->id);

        if (!$location->user_access)
            exit;

        $location->user_access = 0;
        $location->save();
        exit;
    }


    protected function updateBirthday(array $data, int $user_id)
    {
        if (empty($data['birthday']))
            exit;
        
        $birthday = Birthday::find($user_id);
        
        foreach ($data['birthday'] as $key => $value){
            $birthday->$key = $value;
        }

        $birthday->save();
    }

    protected function updateLocation(array $data, int $user_id)
    {
        $location = Location::find($user_id);

        foreach ($data['location'] as $key => $value){
            $location->$key = $value;
        }
        $location->user_access = 1;
        
        $location->save();
    }

    protected function updateInterests(array $data, int $user_id)
    {
        $newTag = $data['interests'][0];

        $interests = Interests::find($user_id);
        $tag = Tags::firstOrNew(['tag' => $newTag]);
        
        $interests_tags = explode(',', $interests->tags);
        array_push($interests_tags, $newTag);
        $interests->tags = implode(',', $interests_tags);
        
        $interests->save();

        $tag->count++;
        $tag->save();

    }

    protected function updateInfo(array $data, string $key, int $user_id)
    {
        $info = Info::find($user_id);

        $info->$key = $data[$key];

        $info->save();
    }
}

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
        echo "<pre>";
        var_dump($request->all());
        exit;
        $key = key($request->all());
        
        $data[$key] = ProfileHelper::validateRequest($request->all(), $request->user()->id);

        if (empty($data[$key]))
            exit;

        if ($key === 'birthday')
        {
            $select = Info::find($request->user()->id);
            
        }
        else if ($key === 'location')
        {

        }
        // if ($key === 'day' || $key === 'month' || $key === 'year')
        //     $table = Birthday::find($request->user()->id);
        // else
        //     $table = Info::find($request->user()->id);

        // foreach ($request->all() as $key => $value){
        //    $table->$key = $value;
        // }

        // $table->save();
    }

    public function saveTag(Request $request)
    {
        echo"<pre>"; 
        var_dump($request->tag);
        exit;
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
}

<?php

namespace App\Http\Controllers\Profile;

use File;
use Auth;
use App\User;
use App\Info;
use App\Location;
use App\Interests;
use App\Birthday;
use App\Helper\profileInfoHelper as ProfileHelper;
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
    		'location' => Location::find($id),
            'birthday' => Birthday::find($id),
    	];

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
        ProfileHelper::validateRequest($request->all(), $request->user()->id);
        
        $arr_key = key($request->all());
        if ($arr_key === 'day' || $arr_key === 'month' || $arr_key === 'year')
            $table = Birthday::find($request->user()->id);
        else
            $table = Info::find($request->user()->id);

        foreach ($request->all() as $key => $value){
           $table->$key = $value;
        }

        $table->save();

        // $user = User::where('login', 'denis_mina132')->first();
        // echo "<pre>";
        // var_dump($user['id']);
        // exit;
    }
}

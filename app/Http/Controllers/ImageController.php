<?php

namespace App\Http\Controllers;

use App\Info;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Image Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling users image save request
    |
    */

    /**
     * Take request with new user icon.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return base_64 icon path $base
     */
    public function userIcon(Request $request)
    {
        $file = ($request->only('icon'))['icon'];

        $this->validateImg($file);
        
        $this->deleteOldIcon($request->user()['login']);
    	
        $file_path = $this->saveIcon($request->file('icon'), $request->user()['login'], $request->user()['id']);
        
        $contents = file_get_contents($file_path);
        $mime_type = $file->getMimeType();
        $base = "data:image/" . $mime_type . ";base64," . base64_encode($contents);

        exit(json_encode(['src' => $base]));
    }

    //https://laravel.com/docs/5.8/filesystem

    /**
     * Get a validator for an incoming image save request.
     *
     * @param Symfony\Component\HttpFoundation\File\UploadedFile object with request user file $data
     * @return json answer || void
     */
    private function validateImg($data)
    {
        $file = array('image' => $data);

        $validator = Validator::make($file, [
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:7000000'
        ]);

        if ($validator->fails())
            die(json_encode(['error' => $validator->messages()->first()]));
    }

    /**
     * Delete old user icon if it exists
     *
     * @param  String user login  $request
     * @return void
     */
    private function deleteOldIcon(String $login)
    {
        $path_to_dir = storage_path('app/profiles/' . $login . '/icon');
        $glob = glob($path_to_dir . '/*');
        $is_empty = count(glob($path_to_dir . '/*')) ? false : true;
        if (!$is_empty)
            unlink($glob[0]);
    }

    /**
     * Save icon to storage/app/profiles/'user login'/icon
     * add new icon in to database
     *
     * @param  Illuminate\Http\UploadedFile $file
     * @param  String user login $login
     * @param  Integer user id $id
     * @return Path to new icon $path
     */
    private function saveIcon($file, $login, $id)
    {
        $created_path = $file->store('profiles/' . $login . '/icon');
        
        $name = explode('/', $created_path);
        $name = $name[count($name) - 1];
        
        $info = Info::find($id);
        $info->icon = $name;
        $info->save();

        return (storage_path('app/' . $created_path));
    }
}

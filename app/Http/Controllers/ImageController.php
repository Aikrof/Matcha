<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function userIcon(Request $request)
    {
    	// echo"<pre>"; 
    	var_dump($request->file('icon')->store('profiles/' . $request->user()['login'] . '/icon'));
    	// exit;
    	$path_to_dir = storage_path('app/profiles/' . $request->user()['login'] . '/icon');
    	$is_empty = count(glob($path_to_dir . '/*')) ? false : true;

    	$glob = glob($path_to_dir . '/*');
    	unlink($glob[0]);
    	// unlink(storage_path('app/profiles/' . $request->user()['login'] . '/AojJlzSsZuYBtpWx7HZYkw3CHmnaPb7V7xK3gITx.jpeg'));
    }

    //https://laravel.com/docs/5.8/filesystem
}

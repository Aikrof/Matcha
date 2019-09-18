<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
    	$title = 'Matcha :: Chat';

    	return (view('chat')->with('title', $title));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
	/**
     * Show the index page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	return (view('index'));
    }
}

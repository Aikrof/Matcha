<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
    	echo"<pre>"; 
    	var_dump('index');
    	exit;
    	// return ($this->_view->render());
    	// return (view('index')->with($this->title));
    }
}

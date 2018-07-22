<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class HomeController extends Controller
{
	public function __construct()
	{
		$this->middleware('alive');
	}

	public function home()
	{
		return view('home');
	}
}
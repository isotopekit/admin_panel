<?php

namespace IsotopeKit\AdminPanel\Http\Controllers;

// use Log;
use Mail;
use Session;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

	public function index(Request $request)
	{
		return $request->all();
	}

}
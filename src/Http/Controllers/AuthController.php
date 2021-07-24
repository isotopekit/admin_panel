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

class AuthController extends Controller
{

	public function getLogin(Request $request)
	{
		return view('admin_panel::auth.login');
	}

	public function getReset(Request $request)
	{
		return view('admin_panel::auth.reset');
	}

}
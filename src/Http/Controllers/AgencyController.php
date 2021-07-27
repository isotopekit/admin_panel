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


use IsotopeKit\AuthAPI\Models\User;
use IsotopeKit\AuthAPI\Models\User_Role;
use IsotopeKit\AuthAPI\Models\Levels;
use IsotopeKit\AuthAPI\Models\Site;

class AgencyController extends Controller
{

	// dashboard
	public function index(Request $request)
	{
		return view('admin_panel::agency.index');
	}

	// settings
	public function getSettings(Request $request)
	{
		$site_settings = Site::where('agency_id', Auth::id())->first();

		if($site_settings == null)
		{
			Site::create([
				'name'      =>  Auth::user()->first_name,
				'language'	=> 'en',
				'theme'		=> 'default',
                'agency_id' =>  Auth::id()
			]);

			$site_settings = Site::where('agency_id', Auth::id())->first();
		}

		return view('admin_panel::agency.settings')->with('settings', $site_settings);
	}

	// users
	public function getUsers(Request $request)
	{
		$users = User::where('id', '!=', '1')
					->where('created_by', Auth::id())
					->select('id','first_name', 'last_name', 'email', 'enabled', 'created_at')
					->get();

		foreach($users as $user)
		{
			$user->plan_name = null;
			// get user level
			$fetch_roles = User_Role::where('user_id', '=', $user->id)->first();
			if($fetch_roles)
			{
				$get_level_id = json_decode($fetch_roles->levels)[1];
				$level_info = Levels::where('id', $get_level_id)->first();
				if($level_info)
				{
					$user->plan_name = $level_info->name;
				}
			}

		}

		$can_add_more = false;

		// agency plan
		$get_agency_levels = User_Role::where('user_id', Auth::id())->first();
		if($get_agency_levels)
		{
			$get_agency_level_id = json_decode($get_agency_levels->levels)[1];
			$get_agency_level_info = Levels::where('id', $get_agency_level_id)->first();
			if($get_agency_level_info)
			{
				// agency total users
				$total_users = $get_agency_level_info->agency_members;
				// agency current users
				$current_users = User::where('created_by', Auth::id())->count();

				if($total_users > $current_users)
				{
					$can_add_more = true;
				}
			}
		}

		return view('admin_panel::agency.users.index')
				->with('users', $users)
				->with('can_add_more', $can_add_more);
	}

	// add user (post)
	public function postAddUser(Request $request)
	{
		// check if agency can add more user
		$can_add_more = false;
		$get_agency_level_info = null;

		// agency plan
		$get_agency_levels = User_Role::where('user_id', Auth::id())->first();
		if($get_agency_levels)
		{
			$get_agency_level_id = json_decode($get_agency_levels->levels)[1];
			$get_agency_level_info = Levels::where('id', $get_agency_level_id)->first();
			if($get_agency_level_info)
			{
				// agency total users
				$total_users = $get_agency_level_info->agency_members;
				// agency current users
				$current_users = User::where('created_by', Auth::id())->count();

				if($total_users > $current_users)
				{
					$can_add_more = true;
				}
			}
		}

		if($can_add_more == false)
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'Cannot Add More Users');
		}

		if($get_agency_level_info == null)
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'Unable to access Plan Details');
		}

		try
		{
			$isValid =  Validator::make($request->all(), [
				'first_name'    =>  'required|string|min:3',
                'last_name'     =>  'required|string|min:3',
                'email'         =>  'required|string|email|min:5|max:50|unique:users',
                'password'      =>  'required|string|min:6|max:20'
			]);
			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_users_index', ['mode'	=>	'user_add'])->withErrors($isValid)->withInput();
			}

			$random_text_generator = new \IsotopeKit\Utility\RandomTextGenerator();
			$random_token = $random_text_generator->get_random_value_in_string(20);

			// create account
			$user = User::create([
				'first_name'    =>  $request->input('first_name'),
				'last_name'     =>  $request->input('last_name'),
				'email'         =>  $request->input('email'),
				'password'      =>  bcrypt($request->input('password')),
				'email_token'   =>  $random_token,
				'enabled'       =>  true,
				'created_by'    =>  Auth::id()
			]);

			// same as agency level id
			$plan_id = json_encode($get_agency_level_info->id);
			// save role
			$save_role = User_Role::create([
				'user_id'	=>	$user->id,
				'levels'    => '["1","'.$plan_id.'"]', // by default user with 'basic' plan
			]);
			
			// $app_library = new \App\Libraries\Utility();
			// $res = $app_library->send_email_agency_generic($request->input('first_name'), $request->input('email'), $request->input('password'), 0);

			return redirect()->route('get_agency_users_index')->with('status.success', 'User Created.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'Something went wrong, try again later');

		}
	}

	// agency settings general (post)
	public function postSettingsGeneral(Request $request)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'name'			=> 'required',
				'language'		=> 'required',
				'theme'			=> 'required'
			]);

			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_settings')->withErrors($isValid)->withInput();
			}

			Site::where('agency_id', Auth::id())->update([
				'name'		=>	$request->input('name'),
				'language'	=>	$request->input('language'),
				'theme'		=>	$request->input('theme'),
				'logo'		=>	$request->input('logo'),
				'favicon'	=>	$request->input('favicon'),
				'page_description'	=>	$request->input('page_description'),
				'support_email'		=>	$request->input('support_email'),
				'support_url'		=>	$request->input('support_url'),
				'show_training_url'	=>	$request->input('show_training_url'),
				'training_url'		=>	$request->input('training_url')
			]);

			return redirect()->route('get_agency_settings')->with('status.success', 'General Settings Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_settings')->with('status.error', 'Something Went Wrong');
		}
	}

	// agency settings email (post)
	public function postSettingsEmail(Request $request)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'from_name'			=> 'required',
				'from_address'		=> 'required'
			]);

			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_settings')->withErrors($isValid)->withInput();
			}

			Site::where('agency_id', Auth::id())->update([
				'host'			=>	$request->input('host'),
				'port'			=>	$request->input('port'),
				'encryption'	=>	$request->input('encryption'),
				'username'		=>	$request->input('username'),
				'password'		=>	$request->input('password'),
				'from_address'	=>	$request->input('from_address'),
				'from_name'		=>	$request->input('from_name')
			]);

			return redirect()->route('get_agency_settings')->with('status.success', 'Email Settings Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_settings')->with('status.error', 'Something Went Wrong');
		}
	}

	// agency settings domain (post)
	public function postSettingsDomain(Request $request)
	{
		try
		{
			$site = Site::where('agency_id', Auth::id())->first();
			$isValid =  Validator::make($request->all(), [
				'unique_name'   =>  'required|min:3|max:50|unique:site_settings,unique_name,'.$site->id,
			]);
			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_settings')->withErrors($isValid)->withInput();
			}

			Site::where('agency_id', Auth::id())->update([
				'unique_name'	=>	$request->input('unique_name'),
				'external_url'	=>	$request->input('external_url')
			]);

			return redirect()->route('get_agency_settings')->with('status.success', 'Domain Settings Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_settings')->with('status.error', 'Something Went Wrong');
		}
	}

	// agency settings password (post)
	public function postSettingsPassword(Request $request)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'password'      =>  'required|string|min:6|max:50',
				'password_confirm' =>  'required|string|min:6|max:50|same:password',
			]);
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_settings')->withErrors($isValid)->withInput();
			}
			$user = User::find(Auth::id());
			if($user)
			{
				$user->password = bcrypt($request->input('password'));
				$user->save();
				return redirect()->route('get_agency_settings')->with('status.success', 'Password Changed.');
			}
			else
			{
				return redirect()->route('get_agency_settings')->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_settings')->with('status.error', 'Something went wrong');
		}
	}

}
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
use IsotopeKit\AdminPanel\Models\CustomProperties;
use IsotopeKit\AuthAPI\Models\Levels;
use IsotopeKit\AuthAPI\Models\Site;

use Illuminate\Support\Facades\Storage;

class AgencyController extends Controller
{

	// dashboard
	public function index(Request $request)
	{
		return redirect()->route('get_agency_users_index');
		return view('admin_panel::agency.index');
	}

	// users
	public function getUsers(Request $request)
	{
		$users = User::where('id', '!=', '1')
					->where('created_by', Auth::id())
					->select('id','first_name', 'last_name', 'email', 'enabled', 'created_at')
					->orderBy('id', 'desc')
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

		$total_users = 0;
		$current_users = 0;

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

				// TODO
				// use config paramter, instead of 101 for team
				$team_users = User::join('user_role', 'users.id', '=', 'user_role.user_id')
									->where('created_by', Auth::id())
									->whereJsonContains('levels', '101')
									->count();

				$current_users = $current_users - $team_users;

				if($total_users > $current_users)
				{
					$can_add_more = true;
				}
			}
		}

		return view('admin_panel::agency.users.index')
				->with('users', $users)
				->with('can_add_more', $can_add_more)
				->with('total_users', $total_users)
				->with('current_users', $current_users);
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
                'password'      =>  'required|string|min:6|max:20|confirmed'
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

			if($user)
			{
				$get_site_settings = Site::where('id', '1')->first();
				if($get_site_settings != null)
				{
					$site_settings = $get_site_settings;
				}

				// set agency settings
				$get_agency_settings = Site::where('agency_id', Auth::id())->first();
				if($get_agency_settings)
				{
					if($get_agency_settings->name != null)
					{
						$site_settings->name = $get_agency_settings->name;
					}

					if($get_agency_settings->external_url != null)
					{
						$site_settings->external_url = $get_agency_settings->external_url;
					}

					if($get_agency_settings->from_address != null)
					{
						$site_settings->from_address = $get_agency_settings->from_address;
						$site_settings->from_name = $get_agency_settings->from_name;
					}
				}

				$data = [
					'email' =>  $request->input('email'),
					'name'  =>  $request->input('first_name'),
					'password'  =>  $request->input('password'),
					'app_name'	=>	$site_settings->name,
					'app_domain'	=>	$site_settings->external_url
				];

				$emails_to = array(
					'email' => $request->input('email'),
					'name' => $request->input('first_name'),
					'subject'	=> 'Welcome to '. $site_settings->name
				);

				Config::set('mail.encryption',$site_settings->encryption);
				Config::set('mail.host', $site_settings->host);
				Config::set('mail.port', $site_settings->port);
				Config::set('mail.username', $site_settings->username);
				Config::set('mail.password', $site_settings->password);
				Config::set('mail.from',  ['address' => $site_settings->from_address , 'name' => $site_settings->from_name]);
				
				Mail::send('admin_panel::emails.welcome', $data, function($message) use ($emails_to)
				{
					$message->to($emails_to['email'], $emails_to['name'])->subject($emails_to['subject']);
				});
			}

			return redirect()->route('get_agency_users_index')->with('status.success', 'User Created.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'Something went wrong, try again later');

		}
	}

	// edit user
	public function getEditUser(Request $request, $id)
	{
		// check if agency is the owner of this user
		$user = User::find($id);
		if($user->created_by != Auth::id())
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'You cannot access this user.');
		}

		$user = User::find($id);
		if($user)
		{
			$plans = Levels::where('id', '!=', '1')->get();
			$user_plan = User_Role::where('user_id', $id)->first();
			$plan_id = null;
			if($user_plan != null)
			{
				$levels = json_decode($user_plan->levels);
				$plan_id = $levels[1];

				$user->plan_name = null;
				$level_info = Levels::where('id', $plan_id)->first();
				if($level_info)
				{
					$user->plan_name = $level_info->name;
				}
			}

			$custom_properties = CustomProperties::get();

			return view('admin_panel::agency.users.edit')
				->with('user', $user)
				->with('plans', $plans)
				->with('plan_id', $plan_id)
				->with('custom_properties', $custom_properties);
		}
		else
		{
			return view('admin_panel::errors.404');
		}
	}

	// update user (post)
	public function postEditUser(Request $request, $id)
	{
		// check if agency is the owner of this user
		$user = User::find($id);
		if($user->created_by != Auth::id())
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'You cannot access this user.');
		}

		try
		{
			$isValid =  Validator::make($request->all(), [
				'first_name'    =>  'required|string|min:3',
				'last_name'     =>  'required|string|min:3',
				'email'         =>  'required|string|email|min:5|max:50|unique:users,email,'.$id,
				'plan_id'       =>  'required'
			]);

			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->withErrors($isValid)->withInput();
			}

			$user = User::find($id);
			if($user)
			{
				$user->first_name = $request->input('first_name');
				$user->last_name = $request->input('last_name');
				$user->email = $request->input('email');
				$user->save();

				$user_role = User_Role::where('user_id', $id)->first();
				if($user_role)
				{
					$user_role->levels = '["1",'.json_encode($request->input('plan_id')).']';
					$user_role->save();
				}
				else
				{
					$user_role = User_Role::create([
						'user_id'	=>	$id,
						'levels'    => '["1",'.json_encode($request->input('plan_id')).']',
					]);
				}
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.success', 'User Updated.');
			}
			else
			{
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
		}
	}

	public function postChangeUserBonus(Request $request, $id)
	{
		try
		{
			$user = User::find($id);
			if($user)
			{
				$custom_property = [];
				$custom_properties_id = $request->input('custom_properties_id');
				$custom_properties_value = $request->input('custom_properties_value');
				foreach ($custom_properties_id as $key => $val) {
					if(array_key_exists($key, $custom_properties_value))
					{
						$item = [
							"id"	=>	$val,
							"value"	=>	$custom_properties_value[$key]
						];
						array_push($custom_property, $item);
					}
				}

				User::where('id', $id)->update([	
					// branding
					'remove_branding'	=>	$request->input('remove_branding'),
					'custom_branding'	=>	$request->input('custom_branding'),

					// team
					'enable_team'	=>	$request->input('enable_team'),
					'team_members'	=>	$request->input('team_members'),

					// custom domains
					'enable_custom_domains'	=>	$request->input('enable_custom_domains'),
					'custom_domains'	=>	$request->input('custom_domains'),

					'custom_properties'		=>	json_encode($custom_property)
				]);
				
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.success', 'Bonus Settings Updated.');

			}
			else
			{
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
		}
	}

	// change user password (post)
	public function postChangeUserPassword(Request $request, $id)
	{
		// check if agency is the owner of this user
		$user = User::find($id);
		if($user->created_by != Auth::id())
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'You cannot access this user.');
		}

		try
		{
			$isValid =  Validator::make($request->all(), [
				'password'      =>  'required|string|min:6|max:50',
				'password_confirm' =>  'required|string|min:6|max:50|same:password',
			]);
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->withErrors($isValid)->withInput();
			}
			$user = User::find($id);
			if($user)
			{
				$user->password = bcrypt($request->input('password'));
				$user->save();
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.success', 'Password Changed.');
			}
			else
			{
				return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
		}
	}

	// change user status
	public function postChangeUserStatus(Request $request, $id)
	{
		// check if agency is the owner of this user
		$user = User::find($id);
		if($user->created_by != Auth::id())
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'You cannot access this user.');
		}

		try
		{
			$isValid =  Validator::make($request->all(), [
				'enabled'	=> 'required|boolean'
			]);

			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_agency_users_index')->with('status.error', 'Something Went Wrong');
			}

			User::where('id', $id)->update([
				'enabled'	=>	$request->input('enabled')
			]);

			if($request->input('enabled') == true)
			{
				return redirect()->route('get_agency_users_index')->with('status.success', 'User now Active.');
			}
			else
			{
				return redirect()->route('get_agency_users_index')->with('status.error', 'User now Inactive.');
			}

		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'Something Went Wrong');
		}
	}

	// delete user (post)
	public function postDeleteUser(Request $request, $id)
	{
		// check if agency is the owner of this user
		$user = User::find($id);
		if($user->created_by != Auth::id())
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'You cannot access this user.');
		}

		try
		{
			User::where('id', $id)->delete();
			return redirect()->route('get_agency_users_index')->with('status.success', 'User Deleted.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'Something Went Wrong');
		}
	}

	// access user (post)
	public function postAccessUser(Request $request, $id)
	{
		// check if agency is the owner of this user
		$user = User::find($id);
		if($user->created_by != Auth::id())
		{
			return redirect()->route('get_agency_users_index')->with('status.error', 'You cannot access this user.');
		}

		Auth::loginUsingId($id);
		return redirect('/user/');
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

			$file_to_upload = $request->file('favicon');
			$path = null;

			if($file_to_upload)
			{
				$random_text_generator = new \IsotopeKit\Utility\RandomTextGenerator();
				$random_name = $random_text_generator->get_random_value_in_string(10);

                Storage::disk('uploads')->putFileAs('logos', $request->file('favicon'), $random_name);
                $path = "/uploads/logos/".$random_name;
			}
			else
			{
				$site_settings = Site::where('agency_id', Auth::id())->first();
                $path = $site_settings->favicon;
            }
            
            $file_to_upload_logo = $request->file('logo');
			$path_logo = null;

			if($file_to_upload_logo)
			{
				$random_text_generator = new \IsotopeKit\Utility\RandomTextGenerator();
				$random_name = $random_text_generator->get_random_value_in_string(10);

                Storage::disk('uploads')->putFileAs('logos', $request->file('logo'), $random_name);
                $path_logo = "/uploads/logos/".$random_name;
			}
			else
			{
				$site_settings = Site::where('agency_id', Auth::id())->first();
                $path_logo = $site_settings->logo;
			}

			Site::where('agency_id', Auth::id())->update([
				'name'		=>	$request->input('name'),
				'language'	=>	$request->input('language'),
				'theme'		=>	$request->input('theme'),
				'logo'		=>	$path_logo,
				'favicon'	=>	$path,
				'page_description'	=>	$request->input('page_description'),
				'support_email'		=>	$request->input('support_email'),
				'support_url'		=>	$request->input('support_url'),
				'show_training_url'	=>	$request->input('show_training_url'),
				'training_url'		=>	$request->input('training_url'),
				'show_plan_info'	=>	$request->input('show_plan_info')
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

	// agency settings domain (post)
	public function postSettingsCustomization(Request $request)
	{
		try
		{
			$file_to_upload_logo = $request->file('logo_bg_image');
			$logo_bg_image_path = null;

			if($file_to_upload_logo)
			{
				$random_text_generator = new \IsotopeKit\Utility\RandomTextGenerator();
				$random_name = $random_text_generator->get_random_value_in_string(10);

                Storage::disk('uploads')->putFileAs('bg', $request->file('logo_bg_image'), $random_name);
                $logo_bg_image_path = "/uploads/bg/".$random_name;
			}
			else
			{
				$site_settings = Site::where('agency_id', Auth::id())->first();
                $logo_bg_image_path = $site_settings->logo_bg_image;
			}

			Site::where('agency_id', Auth::id())->update([
				'navbar_link_color'		=>	$request->input('navbar_link_color'),
				'navbar_active_color'	=>	$request->input('navbar_active_color'),

				'primary_btn_bg_color'	=>	$request->input('primary_btn_bg_color'),
				'primary_btn_txt_color'	=>	$request->input('primary_btn_txt_color'),
				
				'bg_color'				=>	$request->input('bg_color'),
				'progress_bar_color'	=>	$request->input('progress_bar_color'),

				'login_custom_css'		=>	$request->input('login_custom_css'),
				'login_custom_js'		=>	$request->input('login_custom_js'),
				'login_custom_header'	=>	$request->input('login_custom_header'),
				'login_custom_footer'	=>	$request->input('login_custom_footer'),
				'login_logo_bg_color'	=>	$request->input('login_logo_bg_color'),
				'logo_bg_image'			=>	$logo_bg_image_path,

				'user_custom_css'		=>	$request->input('user_custom_css'),
				'user_custom_js'		=>	$request->input('user_custom_js'),
				'user_custom_header'	=>	$request->input('user_custom_header'),
				'user_custom_footer'	=>	$request->input('user_custom_footer')
			]);

			return redirect()->route('get_agency_settings')->with('status.success', 'Customization Settings Updated.');
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

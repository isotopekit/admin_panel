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
use IsotopeKit\AdminPanel\Models\CustomProperties;
use IsotopeKit\AuthAPI\Models\User;
use IsotopeKit\AuthAPI\Models\User_Role;
use IsotopeKit\AuthAPI\Models\Domains;
use IsotopeKit\AuthAPI\Models\Levels;
use IsotopeKit\AuthAPI\Models\Site;

class AdminController extends Controller
{

	// dashboard
	public function index(Request $request)
	{
		return redirect()->route('get_admin_users_index');
		return view('admin_panel::admin.index');
	}

	// users
	public function getUsers(Request $request)
	{
		$admin_accounts = config('isotopekit_admin.account_list');
		$plans = Levels::where('id', '!=', '1')->get();
		$users = User::whereNotIn('id', $admin_accounts)->select('id','first_name', 'last_name', 'email', 'enabled', 'created_at', 'created_by')->orderByDesc('id')->get();

		$filter = null;

		if($request->filter)
		{
			if($request->filter == "appsumo")
			{
				$filter = "appsumo";
				$users = User::whereNotIn('id', $admin_accounts)->where('code_used_one', '!=', null)->select('id','first_name', 'last_name', 'email', 'enabled', 'created_at', 'created_by', 'code_used_one', 'code_used_two', 'code_used_three', 'code_used_four', 'code_used_five')->orderByDesc('id')->get();
			}

			if($request->filter == "direct")
			{
				$filter = "direct";
				$users = User::whereNotIn('id', $admin_accounts)->where('created_by', 'direct')->select('id','first_name', 'last_name', 'email', 'enabled', 'created_by', 'created_at')->orderByDesc('id')->get();
			}
		}

		foreach($users as $user)
		{
			$user->plan_name = null;
			$user->owner_details = null;
			$user->agency_details = null;

			// get user level
			$fetch_roles = User_Role::where('user_id', '=', $user->id)->first();
			if($fetch_roles)
			{
				if(json_decode($fetch_roles->levels) != null && json_decode($fetch_roles->levels) != "")
				{
					if(array_key_exists(1, json_decode($fetch_roles->levels)))
					{
						$get_level_id = json_decode($fetch_roles->levels)[1];
						$level_info = Levels::where('id', $get_level_id)->first();
						if($level_info)
						{
							$user->plan_name = $level_info->name;
						}
					}
				}
			}

			// agency details
			if($user->created_by != "direct")
			{
				$owner_details = User::where('id', $user->created_by)->first();
				if($owner_details)
				{
					$user->owner_details = $owner_details;
					$agency_details = Site::where('agency_id', $owner_details->id)->first();
					if($agency_details)
					{
						$user->agency_details = $agency_details;
					}
				}
			}

			// check if is agency
			$user->is_agency = false;
			$get_sub_users = User::where('created_by', $user->id)->count();
			if($get_sub_users > 0)
			{
				$user->is_agency = true;
			}

		}

		return view('admin_panel::admin.users.index')
				->with('filter', $filter)	
				->with('plans', $plans)
				->with('users', $users);
	}

	// add user (post)
	public function postAddUser(Request $request)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'first_name'    =>  'required|string|min:3',
                'last_name'     =>  'required|string|min:3',
                'email'         =>  'required|string|email|min:5|max:50|unique:users',
                'password'      =>  'required|string|min:6|max:20',
                'plan_id'       =>  'required'
			]);
			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_users_index', ['mode'	=>	'user_add'])->withErrors($isValid)->withInput();
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
				'enabled'       =>  true
			]);

			$plan_id = json_encode($request->input('plan_id'));
			// save role
			$save_role = User_Role::create([
				'user_id'	=>	$user->id,
				'levels'    => '["1",'.$plan_id.']', // by default user with 'basic' plan
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
					'subject'	=>	config('isotopekit_admin.mail_subject')
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

			return redirect()->route('get_admin_users_index')->with('status.success', 'User Created.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_index')->with('status.error', 'Something went wrong, try again later');

		}
	}

	// edit user
	public function getEditUser(Request $request, $id)
	{
		$user = User::find($id);
		if($user)
		{
			$plans = Levels::where('id', '!=', '1')->get();
			$user_plan = User_Role::where('user_id', $id)->first();
			$plan_id = null;
			if($user_plan != null)
			{
				$levels = json_decode($user_plan->levels);
				if($levels != null)
				{
					if(array_key_exists(1, $levels))
					{
						$plan_id = $levels[1];

						$user->plan_name = null;
						$level_info = Levels::where('id', $plan_id)->first();
						if($level_info)
						{
							$user->plan_name = $level_info->name;
						}
					}
				}
			}
			
			$custom_properties = CustomProperties::get();

			return view('admin_panel::admin.users.edit')
				->with('user', $user)->with('plans', $plans)
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
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->withErrors($isValid)->withInput();
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
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.success', 'User Updated.');
			}
			else
			{
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
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
					$item = [
						"id"	=>	$val,
						"value"	=>	$custom_properties_value[$key]
					];
					array_push($custom_property, $item);
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
				
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.success', 'Bonus Settings Updated.');

			}
			else
			{
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
		}
	}

	// change user password (post)
	public function postChangeUserPassword(Request $request, $id)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'password'      =>  'required|string|min:6|max:50',
				'password_confirm' =>  'required|string|min:6|max:50|same:password',
			]);
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->withErrors($isValid)->withInput();
			}
			$user = User::find($id);
			if($user)
			{
				$user->password = bcrypt($request->input('password'));
				$user->save();
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.success', 'Password Changed.');
			}
			else
			{
				return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_edit', ['id'	=>	$id])->with('status.error', 'Something went wrong');
		}
	}

	// change user status
	public function postChangeUserStatus(Request $request, $id)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'enabled'	=> 'required|boolean'
			]);

			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_users_index')->with('status.error', 'Something Went Wrong');
			}

			User::where('id', $id)->update([
				'enabled'	=>	$request->input('enabled')
			]);

			if($request->input('enabled') == true)
			{
				return redirect()->route('get_admin_users_index')->with('status.success', 'User now Active.');
			}
			else
			{
				return redirect()->route('get_admin_users_index')->with('status.error', 'User now Inactive.');
			}

		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_index')->with('status.error', 'Something Went Wrong');
		}
	}

	// delete user (post)
	public function postDeleteUser(Request $request, $id)
	{
		try
		{
			User::where('id', $id)->delete();
			return redirect()->route('get_admin_users_index')->with('status.success', 'User Deleted.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_index')->with('status.error', 'Something Went Wrong');
		}
	}

	// delete multiple user (post)
	public function postDeleteMultipleUser(Request $request)
	{
		try
		{
			$user_ids = $request->input("users_id");
			$user_ids = explode(",", $user_ids);

			foreach($user_ids as $id)
			{
				User::where('id', $id)->delete();
			}
			
			return redirect()->route('get_admin_users_index')->with('status.success', 'Users Deleted.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_index')->with('status.error', 'Something Went Wrong');
		}
	}

	// change plans of multiple users
	public function postPlanMultipleUser(Request $request)
	{
		try
		{
			$user_ids = $request->input("users_id");
			$user_ids = explode(",", $user_ids);

			foreach($user_ids as $id)
			{
				$user_role = User_Role::where('user_id', $id)->first();
				if($user_role)
				{
					$user_role->levels = '["1",'.json_encode($request->input('new_plan_id')).']';
					$user_role->save();
				}
				else
				{
					$user_role = User_Role::create([
						'user_id'	=>	$id,
						'levels'    => '["1",'.json_encode($request->input('new_plan_id')).']',
					]);
				}
			}
			
			return redirect()->route('get_admin_users_index')->with('status.success', 'Users Plan Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_index')->with('status.error', 'Something Went Wrong');
		}
	}

	// access user (post)
	public function postAccessUser(Request $request, $id)
	{
		Auth::loginUsingId($id);
		return redirect('/user/');
	}

	// reset user (post)
	public function postResetUser(Request $request, $id)
	{
		try
		{
			$user = User::where('id', $id)->first();

			if($user)
			{
				$random_text_generator = new \IsotopeKit\Utility\RandomTextGenerator();
				$new_password = $random_text_generator->get_random_value_in_string(12);
			
				$user->password = bcrypt($new_password);
				$user->save();

				$get_site_settings = Site::where('id', '1')->first();
				if($get_site_settings != null)
				{
					$site_settings = $get_site_settings;
				}

				$data = [
					'email' =>  $user->email,
					'name'  =>  $user->first_name,
					'password'  =>  $new_password,
					'app_name'	=>	$site_settings->name,
					'app_domain'	=>	$site_settings->external_url
				];

				$emails_to = array(
					'email'	=> $user->email,
					'name'	=> $user->first_name,
					'subject'	=>	config('isotopekit_admin.mail_subject')
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

				return redirect('/admin/users')->with('status.success', 'Email with credentials sent.');
			}
			else
			{
				return redirect()->route('get_admin_users_index')->with('status.error', 'User Not Found.');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_users_index')->with('status.error', 'Something went wrong, try again later');
		}
	}

	// custom domains
	public function getDomains(Request $request)
	{
		$domains = Domains::get();
		return view('admin_panel::admin.domains.index')->with('domains', $domains);
	}

	// agency domains
	public function getAgencyDomains(Request $request)
	{
		$domains = Site::where('external_url', '!=', null)->where('id', '!=', 1)->get();
		return view('admin_panel::admin.domains.agency')->with('domains', $domains);
	}

	public function getDomainsCheckAll(Request $request)
	{
		$domains = Domains::where('checked', false)->orWhere('checked', null)->get();
		
		foreach($domains as $domain_info)
		{
			if($domain_info == null)
			{
				continue;
			}

			try
			{
				$doamin_verification = new \IsotopeKit\Utility\Domain($domain_info->url, config('isotopekit_admin.ip'));
				
				$domain_status = $doamin_verification->verify();

				if($domain_status == "managed_by_cloudflare")
				{
					// return "managed by cloudflare";
					Domains::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	false,
						'is_secured'	=>	true
					]);

					continue;
				}

				if($domain_status == "not_pointing_to_ip")
				{
					// return "not pointing to correct IP";
					Domains::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	true,
						'is_secured'	=>	false
					]);

					continue;
				}

				if($domain_status == "ssl_enabled")
				{
					// return "now secured";
					Domains::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	false,
						'is_secured'	=>	true
					]);
					
					continue;
				}

				if($domain_status == "already_secured")
				{
					// return "already secured";
					Domains::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	false,
						'is_secured'	=>	true
					]);
					
					continue;
				}

				if($domain_status == "something_went_wrong")
				{
					// return "something went wrong";
					Domains::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	true,
						'is_secured'	=>	false
					]);
					
					continue;
				}
			}
			catch(\Exception $ex)
			{
				continue;
			}
		}

		return redirect($request->header('Referer'))->with('status.success', 'All Domains checked');
	}

	public function getDomainsCheck($id, Request $request)
	{
		
		// check domain info exists in database
		$domain_info = Domains::where('id', $id)->first();
		if($domain_info == null)
		{
			return redirect($request->header('Referer'))->with('status.error', 'Domain not found');
		}

		try
		{
			$doamin_verification = new \IsotopeKit\Utility\Domain($domain_info->url, config('isotopekit_admin.ip'));
			$domain_status = $doamin_verification->verify();

			if($domain_status == "managed_by_cloudflare")
			{
				// return "managed by cloudflare";
				Domains::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	false,
					'is_secured'	=>	true
				]);
				return redirect($request->header('Referer'))->with('status.error', 'Cloudflare Managed Domain: '. $domain_info->url);
			}

			if($domain_status == "not_pointing_to_ip")
			{
				// return "not pointing to correct IP";
				Domains::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	true,
					'is_secured'	=>	false
				]);
				return redirect($request->header('Referer'))->with('status.error', 'A Record not exists or incorrect for domain: '. $domain_info->url);
			}

			if($domain_status == "ssl_enabled")
			{
				// return "now secured";
				Domains::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	false,
					'is_secured'	=>	true
				]);
				return redirect($request->header('Referer'))->with('status.success', 'SSL Enabled for Domain: '. $domain_info->url);
			}

			if($domain_status == "already_secured")
			{
				// return "already secured";
				Domains::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	false,
					'is_secured'	=>	true
				]);
				return redirect($request->header('Referer'))->with('status.success', 'Already Secured Domain: '. $domain_info->url);
			}

			if($domain_status == "something_went_wrong")
			{
				// return "something went wrong";
				Domains::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	true,
					'is_secured'	=>	false
				]);
				return redirect($request->header('Referer'))->with('status.error', 'Unable to Secure Domain: '. $domain_info->url);
			}
		}
		catch(\Exception $ex)
		{
			Domains::where('id', $id)->update([
				'checked'		=>	true,
				'has_error'		=>	true,
				'is_secured'	=>	false
			]);
			return redirect($request->header('Referer'))->with('status.error', 'Unable to Secure Domain: '. $domain_info->url);
		}
	}

	public function getAgencyDomainsCheck($id, Request $request)
	{
		
		// check domain info exists in database
		$domain_info = Site::where('id', $id)->first();
		if($domain_info == null)
		{
			return redirect($request->header('Referer'))->with('status.error', 'Domain not found');
		}

		try
		{
			$doamin_verification = new \IsotopeKit\Utility\Domain($domain_info->external_url, config('isotopekit_admin.ip'));
			$domain_status = $doamin_verification->verify();

			if($domain_status == "managed_by_cloudflare")
			{
				// return "managed by cloudflare";
				Site::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	false,
					'is_secured'	=>	true
				]);
				return redirect($request->header('Referer'))->with('status.error', 'Cloudflare Managed Domain: '. $domain_info->external_url);
			}

			if($domain_status == "not_pointing_to_ip")
			{
				// return "not pointing to correct IP";
				Site::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	true,
					'is_secured'	=>	false
				]);
				return redirect($request->header('Referer'))->with('status.error', 'A Record not exists or incorrect for domain: '. $domain_info->external_url);
			}

			if($domain_status == "ssl_enabled")
			{
				// return "now secured";
				Site::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	false,
					'is_secured'	=>	true
				]);
				return redirect($request->header('Referer'))->with('status.success', 'SSL Enabled for Domain: '. $domain_info->external_url);
			}

			if($domain_status == "already_secured")
			{
				// return "already secured";
				Site::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	false,
					'is_secured'	=>	true
				]);
				return redirect($request->header('Referer'))->with('status.success', 'Already Secured Domain: '. $domain_info->external_url);
			}

			if($domain_status == "something_went_wrong")
			{
				// return "something went wrong";
				Site::where('id', $id)->update([
					'checked'		=>	true,
					'has_error'		=>	true,
					'is_secured'	=>	false
				]);
				return redirect($request->header('Referer'))->with('status.error', 'Unable to Secure Domain: '. $domain_info->external_url);
			}
		}
		catch(\Exception $ex)
		{
			Site::where('id', $id)->update([
				'checked'		=>	true,
				'has_error'		=>	true,
				'is_secured'	=>	false
			]);
			return redirect($request->header('Referer'))->with('status.error', 'Unable to Secure Domain: '. $domain_info->external_url);
		}
	}

	public function getAgencyDomainsCheckAll(Request $request)
	{
		$domains = Site::where('checked', false)->orWhere('checked', null)->get();
		
		foreach($domains as $domain_info)
		{
			if($domain_info == null)
			{
				continue;
			}

			try
			{
				$doamin_verification = new \IsotopeKit\Utility\Domain($domain_info->external_url, config('isotopekit_admin.ip'));
				
				$domain_status = $doamin_verification->verify();

				if($domain_status == "managed_by_cloudflare")
				{
					// return "managed by cloudflare";
					Site::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	false,
						'is_secured'	=>	true
					]);

					continue;
				}

				if($domain_status == "not_pointing_to_ip")
				{
					// return "not pointing to correct IP";
					Site::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	true,
						'is_secured'	=>	false
					]);

					continue;
				}

				if($domain_status == "ssl_enabled")
				{
					// return "now secured";
					Site::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	false,
						'is_secured'	=>	true
					]);
					
					continue;
				}

				if($domain_status == "already_secured")
				{
					// return "already secured";
					Site::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	false,
						'is_secured'	=>	true
					]);
					
					continue;
				}

				if($domain_status == "something_went_wrong")
				{
					// return "something went wrong";
					Site::where('id', $domain_info->id)->update([
						'checked'		=>	true,
						'has_error'		=>	true,
						'is_secured'	=>	false
					]);
					
					continue;
				}
			}
			catch(\Exception $ex)
			{
				continue;
			}
		}
		
		return redirect($request->header('Referer'))->with('status.success', 'All Domains checked');
	}

	public function getDomainsRefresh(Request $request)
	{
		exec("sudo apache2ctl graceful");
		// return "all new domains scheduled for activation";
		return redirect($request->header('Referer'))->with('status.success', 'All new domains scheduled for activation');
	}

	// plans
	public function getPlans(Request $request)
	{
		// get all levels except admin level (id: 1)
		$levels = Levels::where('id','!=',1)->get();
		return view('admin_panel::admin.plans.index')->with('plans', $levels);
	}

	// plan schema
	public function getPlanSchema(Request $request)
	{
		$custom_properties = CustomProperties::get();
		return view('admin_panel::admin.plans.schema')->with('custom_properties', $custom_properties);
	}

	public function postPlanSchema(Request $request)
	{
		// return json_encode($request->all());

		try
		{
			$isValid =  Validator::make($request->all(), [
				'name'    			=> 'required|string',
				'unique_name'     	=> 'required|alpha_dash|string|unique:custom_properties',
				'type'				=> 'required|string',
				'agency_enabled'	=>	'required'
			]);
			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_plans_schema')->withErrors($isValid)->withInput();
			}

			CustomProperties::insert([
				'name'				=>	$request->input('name'),
				'unique_name'		=>	$request->input('unique_name'),
				'type'				=>	$request->input('type'),
				'agency_enabled'	=>	$request->input('agency_enabled')
			]);

			return redirect()->route('get_admin_plans_schema')->with('status.success', 'Plans Schema Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_plans_schema')->with('status.error', 'Something went wrong, try again later');
		}
	}

	public function getDeletePlanSchema(Request $request, $id)
	{
		try
		{
			CustomProperties::where('id', $id)->delete();
			return redirect()->route('get_admin_plans_schema')->with('status.success', 'Custom Property Deleted.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_plans_schema')->with('status.error', 'Something Went Wrong');
		}

	}

	// add plan
	public function getAddPlan(Request $request)
	{
		$custom_properties = CustomProperties::get();
		return view('admin_panel::admin.plans.add')->with('custom_properties', $custom_properties);
	}

	// add plan (post)
	public function postAddPlan(Request $request)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'name'    		=> 'required|string',
				'price'     		=> 'required|string',
				'valid_time'	=> 'required|string'
			]);
			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_plans_add')->withErrors($isValid)->withInput();
			}

			$custom_property = [];
			$custom_properties_id = $request->input('custom_properties_id');
			$custom_properties_value = $request->input('custom_properties_value');
			if($custom_properties_id)
			{
				foreach ($custom_properties_id as $key => $val) {
					$item = [
						"id"	=>	$val,
						"value"	=>	$custom_properties_value[$key]
					];
					array_push($custom_property, $item);
				}
			}

			$agency_custom_property = [];
			$agency_custom_properties_id = $request->input('agency_custom_properties_id');
			$agency_custom_properties_value = $request->input('agency_custom_properties_value');

			if($custom_properties_id)
			{
				foreach ($agency_custom_properties_id as $key => $val) {
					$item = [
						"id"	=>	$val,
						"value"	=>	$agency_custom_properties_value[$key]
					];
					array_push($agency_custom_property, $item);
				}
			}

			Levels::insert([
				'name'			=>	$request->input('name'),
				'price'			=>	$request->input('price'),
				'enabled'		=>	$request->input('enabled'),
				'valid_time'	=>	$request->input('valid_time'),

				// branding
				'remove_branding'	=>	$request->input('remove_branding'),
				'custom_branding'	=>	$request->input('custom_branding'),

				// team
				'enable_team'	=>	$request->input('enable_team'),
				'team_members'	=>	$request->input('team_members'),

				// custom domains
				'enable_custom_domains'	=>	$request->input('enable_custom_domains'),
				'custom_domains'	=>	$request->input('custom_domains'),

				// agency
				'enable_agency'		=>	$request->input('enable_agency'),
				'agency_members'	=>	$request->input('agency_members'),

				// agency team
				'agency_enable_team'	=>	$request->input('agency_enable_team'),
				'agency_team_members'	=>	$request->input('agency_team_members'),

				// agency custom domains
				'agency_enable_custom_domains'	=>	$request->input('agency_enable_custom_domains'),
				'agency_custom_domains'			=>	$request->input('agency_custom_domains'),

				'custom_properties'		=>	json_encode($custom_property),
				'agency_custom_properties'		=>	json_encode($agency_custom_property)
			]);

			return redirect()->route('get_admin_plans_index')->with('status.success', 'Plan Created.');
		}
		catch(\Exception $ex)
		{
			return $ex;
			return redirect()->route('get_admin_plans_add')->with('status.error', 'Something went wrong, try again later');
		}
	}

	// edit plan
	public function getEditPlan(Request $request, $id)
	{
		$custom_properties = CustomProperties::get();
		$plan = Levels::find($id);
		if($plan)
		{
			return view('admin_panel::admin.plans.edit')->with('plan', $plan)->with('custom_properties', $custom_properties);
		}
		else
		{
			return view('admin_panel::errors.404');
		}
	}
	
	// edit plan (post)
	public function postEditPlan(Request $request, $id)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'name'    		=> 'required|string',
				'price'     	=> 'required|string',
				'valid_time'	=> 'required|string'
			]);

			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_plans_edit', ['id' => $id])->withErrors($isValid)->withInput();
			}

			$custom_property = [];
			$custom_properties_id = $request->input('custom_properties_id');
			$custom_properties_value = $request->input('custom_properties_value');
			foreach ($custom_properties_id as $key => $val) {
				$item = [
					"id"	=>	$val,
					"value"	=>	$custom_properties_value[$key]
				];
				array_push($custom_property, $item);
			}

			$agency_custom_property = [];
			$agency_custom_properties_id = $request->input('agency_custom_properties_id');
			$agency_custom_properties_value = $request->input('agency_custom_properties_value');
			foreach ($agency_custom_properties_id as $key => $val) {
				$item = [
					"id"	=>	$val,
					"value"	=>	$agency_custom_properties_value[$key]
				];
				array_push($agency_custom_property, $item);
			}

			Levels::where('id', $id)->update([
				'name'			=>	$request->input('name'),
				'price'			=>	$request->input('price'),
				'enabled'		=>	$request->input('enabled'),
				'valid_time'	=>	$request->input('valid_time'),

				// branding
				'remove_branding'	=>	$request->input('remove_branding'),
				'custom_branding'	=>	$request->input('custom_branding'),

				// team
				'enable_team'	=>	$request->input('enable_team'),
				'team_members'	=>	$request->input('team_members'),

				// custom domains
				'enable_custom_domains'	=>	$request->input('enable_custom_domains'),
				'custom_domains'	=>	$request->input('custom_domains'),

				// agency
				'enable_agency'		=>	$request->input('enable_agency'),
				'agency_members'	=>	$request->input('agency_members'),

				// agency team
				'agency_enable_team'	=>	$request->input('agency_enable_team'),
				'agency_team_members'	=>	$request->input('agency_team_members'),

				// agency custom domains
				'agency_enable_custom_domains'	=>	$request->input('agency_enable_custom_domains'),
				'agency_custom_domains'			=>	$request->input('agency_custom_domains'),

				'custom_properties'		=>	json_encode($custom_property),
				'agency_custom_properties'		=>	json_encode($agency_custom_property)
			]);

			return redirect()->route('get_admin_plans_index')->with('status.success', 'Plan Updated.');

		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_plans_edit', ['id' => $id])->with('status.error', 'Something went wrong, try again later');
		}
	}

	// change plan status
	public function postChangePlanStatus(Request $request, $id)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'enabled'	=> 'required|boolean'
			]);

			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_plans_index')->with('status.error', 'Something Went Wrong');
			}

			Levels::where('id', $id)->update([
				'enabled'	=>	$request->input('enabled')
			]);

			if($request->input('enabled') == true)
			{
				return redirect()->route('get_admin_plans_index')->with('status.success', 'Plan now Active.');
			}
			else
			{
				return redirect()->route('get_admin_plans_index')->with('status.error', 'Plan now Inactive.');
			}

		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_plans_index')->with('status.error', 'Something Went Wrong');
		}
	}

	// delete plan (post)
	public function postDeletePlan(Request $request, $id)
	{
		try
		{
			Levels::where('id', $id)->delete();
			return redirect()->route('get_admin_plans_index')->with('status.success', 'Plan Deleted.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_plans_index')->with('status.error', 'Something Went Wrong');
		}
	}


	// settings
	public function getSettings(Request $request)
	{
		$site_settings = Site::first();
		return view('admin_panel::admin.settings')->with('settings', $site_settings);
	}

	// admin settings general (post)
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
				return redirect()->route('get_admin_settings')->withErrors($isValid)->withInput();
			}

			Site::where('id', 1)->update([
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

			return redirect()->route('get_admin_settings')->with('status.success', 'General Settings Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_settings')->with('status.error', 'Something Went Wrong');
		}
	}

	// admin settings email (post)
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
				return redirect()->route('get_admin_settings')->withErrors($isValid)->withInput();
			}

			Site::where('id', 1)->update([
				'host'			=>	$request->input('host'),
				'port'			=>	$request->input('port'),
				'encryption'	=>	$request->input('encryption'),
				'username'		=>	$request->input('username'),
				'password'		=>	$request->input('password'),
				'from_address'	=>	$request->input('from_address'),
				'from_name'		=>	$request->input('from_name')
			]);

			return redirect()->route('get_admin_settings')->with('status.success', 'Email Settings Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_settings')->with('status.error', 'Something Went Wrong');
		}
	}

	// admin settings domain (post)
	public function postSettingsDomain(Request $request)
	{
		try
		{
			$isValid =  Validator::make($request->all(), [
				'unique_name'   =>  'required|min:3|max:50|unique:site_settings,unique_name,1',
			]);
			
			if($isValid->fails()){
				$messages = $isValid->messages();
				return redirect()->route('get_admin_settings')->withErrors($isValid)->withInput();
			}

			Site::where('id', 1)->update([
				'unique_name'	=>	$request->input('unique_name'),
				'external_url'	=>	$request->input('external_url')
			]);

			return redirect()->route('get_admin_settings')->with('status.success', 'Domain Settings Updated.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_settings')->with('status.error', 'Something Went Wrong');
		}
	}

	// admin settings password (post)
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
				return redirect()->route('get_admin_settings')->withErrors($isValid)->withInput();
			}
			$user = User::find(Auth::id());
			if($user)
			{
				$user->password = bcrypt($request->input('password'));
				$user->save();
				return redirect()->route('get_admin_settings')->with('status.success', 'Password Changed.');
			}
			else
			{
				return redirect()->route('get_admin_settings')->with('status.error', 'Something went wrong');
			}
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_settings')->with('status.error', 'Something went wrong');
		}
	}

}
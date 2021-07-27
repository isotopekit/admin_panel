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
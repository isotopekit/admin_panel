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

use IsotopeKit\AuthAPI\Models\Levels;

class AdminController extends Controller
{

	public function index(Request $request)
	{
		return view('admin_panel::admin.index');
	}

	// users
	public function getUsers(Request $request)
	{
		return view('admin_panel::admin.users.index');
	}

	// domains
	public function getDomains(Request $request)
	{
		return view('admin_panel::admin.domains.index');
	}

	// plans
	public function getPlans(Request $request)
	{
		// get all levels except admin level (id: 1)
		$levels = Levels::where('id','!=',1)->get();
		return view('admin_panel::admin.plans.index')->with('plans', $levels);
	}

	// add plan
	public function getAddPlan(Request $request)
	{
		return view('admin_panel::admin.plans.add');
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
				'agency_custom_domains'			=>	$request->input('agency_custom_domains')
			]);

			return redirect()->route('get_admin_plans_index')->with('status.success', 'Plan Created.');
		}
		catch(\Exception $ex)
		{
			return redirect()->route('get_admin_plans_add')->with('status.error', 'Something went wrong, try again later');
		}
	}

	// edit plan
	public function getEditPlan(Request $request, $id)
	{
		$plan = Levels::find($id);
		return view('admin_panel::admin.plans.edit')->with('plan', $plan);
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
				'agency_custom_domains'			=>	$request->input('agency_custom_domains')
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
		return view('admin_panel::admin.settings');
	}

}
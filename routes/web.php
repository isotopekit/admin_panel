<?php

use Illuminate\Support\Facades\Route;
use IsotopeKit\AdminPanel\Http\Controllers\AuthController;
use IsotopeKit\AdminPanel\Http\Controllers\AdminController;
use IsotopeKit\AdminPanel\Http\Controllers\AgencyController;

use IsotopeKit\AuthAPI\Http\Controllers\AuthController as auth_api_auth_controller;

Route::group(
	[
		'prefix'		=>	config('isotopekit_admin.route_admin'),
		'middleware'	=>	['guest']
	],
	function () {
		Route::get('/login', [AuthController::class, 'getLogin'])->name('get_admin_login_route');
		Route::get('/reset', [AuthController::class, 'getReset'])->name('get_admin_reset_route');
	}
);

Route::group(
	[
		'prefix'		=>	config('isotopekit_admin.route_admin'),
		'middleware'	=>	['admin']
	],
	function () {
		Route::get('/', [AdminController::class, 'index'])->name('get_admin_index');
		Route::post('/logout', [auth_api_auth_controller::class, 'postLogout'])->name('post_admin_logout_route');

		// users
		Route::get('/users', [AdminController::class, 'getUsers'])->name('get_admin_users_index');

		// users/create (post)
		Route::post('/users/add', [AdminController::class, 'postAddUser'])->name('post_admin_users_add');

		// edit user
		Route::get('/users/edit/{id}', [AdminController::class, 'getEditUser'])->name('get_admin_users_edit');

		// edit user (post)
		Route::post('/users/edit/{id}', [AdminController::class, 'postEditUser'])->name('post_admin_users_edit');

		// change user password (post)
		Route::post('/users/change-password/{id}', [AdminController::class, 'postChangeUserPassword'])->name('post_admin_users_password');

		// access user
		Route::post('/users/access/{id}', [AdminController::class, 'postAccessUser'])->name('post_admin_users_access');

		// user status (post)
		Route::post('/users/change_status/{id}', [AdminController::class, 'postChangeUserStatus'])->name('post_admin_users_edit_status');
		// user delete
		Route::post('/users/delete/{id}', [AdminController::class, 'postDeleteUser'])->name('post_admin_users_delete');
		
		
		Route::get('/domains', [AdminController::class, 'getDomains'])->name('get_admin_domains_index');
		
		// plans
		Route::get('/plans', [AdminController::class, 'getPlans'])->name('get_admin_plans_index');

		// add a plan
		Route::get('/plans/add', [AdminController::class, 'getAddPlan'])->name('get_admin_plans_add');
		Route::post('/plans/add', [AdminController::class, 'postAddPlan'])->name('post_admin_plans_add');

		// edit plan
		Route::get('/plans/edit/{id}', [AdminController::class, 'getEditPlan'])->name('get_admin_plans_edit');
		Route::post('/plans/edit/{id}', [AdminController::class, 'postEditPlan'])->name('post_admin_plans_edit');

		// plan status (post)
		Route::post('/plans/change_status/{id}', [AdminController::class, 'postChangePlanStatus'])->name('post_admin_plans_edit_status');
		// plan delete (post)
		Route::post('/plans/delete/{id}', [AdminController::class, 'postDeletePlan'])->name('post_admin_plans_delete');

		// admin settings
		Route::get('/settings', [AdminController::class, 'getSettings'])->name('get_admin_settings');

		// admin settings general (post)
		Route::post('/settings-general', [AdminController::class, 'postSettingsGeneral'])->name('post_admin_settings_general');

		// admin settings email (post)
		Route::post('/settings-email', [AdminController::class, 'postSettingsEmail'])->name('post_admin_settings_email');

		// admin settings domain (post)
		Route::post('/settings-domain', [AdminController::class, 'postSettingsDomain'])->name('post_admin_settings_domain');

		// admin settings password (post)
		Route::post('/settings-password', [AdminController::class, 'postSettingsPassword'])->name('post_admin_settings_password');


	}
);

Route::group(
	[
		'prefix'		=>	config('isotopekit_admin.route_agency'),
		'middleware'	=>	['agency']
	],
	function () {
		Route::get('/', [AgencyController::class, 'index'])->name('get_agency_index');
		Route::post('/logout', [auth_api_auth_controller::class, 'postLogout'])->name('post_agency_logout_route');

		// users
		Route::get('/users', [AgencyController::class, 'getUsers'])->name('get_agency_users_index');

		// users/create (post)
		Route::post('/users/add', [AgencyController::class, 'postAddUser'])->name('post_agency_users_add');

		// edit user
		Route::get('/users/edit/{id}', [AgencyController::class, 'getEditUser'])->name('get_agency_users_edit');

		// edit user (post)
		Route::post('/users/edit/{id}', [AgencyController::class, 'postEditUser'])->name('post_agency_users_edit');

		// change user password (post)
		Route::post('/users/change-password/{id}', [AgencyController::class, 'postChangeUserPassword'])->name('post_agency_users_password');

		// access user
		Route::post('/users/access/{id}', [AgencyController::class, 'postAccessUser'])->name('post_agency_users_access');

		// user status (post)
		Route::post('/users/change_status/{id}', [AgencyController::class, 'postChangeUserStatus'])->name('post_agency_users_edit_status');
		// user delete
		Route::post('/users/delete/{id}', [AgencyController::class, 'postDeleteUser'])->name('post_agency_users_delete');


		// agency settings
		Route::get('/settings', [AgencyController::class, 'getSettings'])->name('get_agency_settings');

		// agency settings general (post)
		Route::post('/settings-general', [AgencyController::class, 'postSettingsGeneral'])->name('post_agency_settings_general');

		// agency settings email (post)
		Route::post('/settings-email', [AgencyController::class, 'postSettingsEmail'])->name('post_agency_settings_email');

		// agency settings domain (post)
		Route::post('/settings-domain', [AgencyController::class, 'postSettingsDomain'])->name('post_agency_settings_domain');

		// agency settings password (post)
		Route::post('/settings-password', [AgencyController::class, 'postSettingsPassword'])->name('post_agency_settings_password');
	}
);

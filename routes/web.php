<?php

use Illuminate\Support\Facades\Route;
use IsotopeKit\AdminPanel\Http\Controllers\AuthController;
use IsotopeKit\AdminPanel\Http\Controllers\AdminController;

use IsotopeKit\AuthAPI\Http\Controllers\AuthController as auth_api_auth_controller;

Route::group(
	[
		'prefix'		=>	'admin',
		'middleware'	=>	['guest']
	],
	function () {
		Route::get('/login', [AuthController::class, 'getLogin'])->name('get_admin_login_route');
		Route::get('/reset', [AuthController::class, 'getReset'])->name('get_admin_reset_route');
	}
);

Route::group(
	[
		'prefix'		=>	'admin',
		'middleware'	=>	['admin']
	],
	function () {
		Route::get('/', [AdminController::class, 'index'])->name('get_admin_index');
		Route::post('/logout', [auth_api_auth_controller::class, 'postLogout'])->name('post_admin_logout_route');

		Route::get('/users', [AdminController::class, 'getUsers'])->name('get_admin_users_index');
		
		Route::get('/domains', [AdminController::class, 'getDomains'])->name('get_admin_domains_index');
		
		// plans
		Route::get('/plans', [AdminController::class, 'getPlans'])->name('get_admin_plans_index');

		// add a plan
		Route::get('/plans/add', [AdminController::class, 'getAddPlan'])->name('get_admin_plans_add');
		Route::post('/plans/add', [AdminController::class, 'postAddPlan'])->name('post_admin_plans_add');

		// edit plan
		Route::get('/plans/edit/{id}', [AdminController::class, 'getEditPlan'])->name('get_admin_plans_edit');
		Route::post('/plans/edit/{id}', [AdminController::class, 'postEditPlan'])->name('post_admin_plans_edit');

		// plan status
		Route::post('/plans/change_status/{id}', [AdminController::class, 'postChangePlanStatus'])->name('post_admin_plans_edit_status');
		// plan delete
		Route::post('/plans/delete/{id}', [AdminController::class, 'postDeletePlan'])->name('post_admin_plans_delete');

		Route::get('/settings', [AdminController::class, 'getSettings'])->name('get_admin_settings');
	}
);

// Route::group(
// 	[
// 		'prefix'		=>	config('adminpanel.route_prefix'),
// 		'middleware'	=>	['agency']
// 	],
// 	function () {
		
// 	}
// );

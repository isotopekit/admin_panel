<?php

use Illuminate\Support\Facades\Route;
use IsotopeKit\AdminPanel\Http\Controllers\AuthController;
use IsotopeKit\AdminPanel\Http\Controllers\AdminController;

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
		Route::get('/', [AdminController::class, 'index']);
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

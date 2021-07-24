<?php

namespace IsotopeKit\AdminPanel;

use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Container\Container;

use Illuminate\Routing\Router;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
	public function boot()
	{
		// views
		$this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin_panel');

		// routes
		$this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

		if ($this->app->runningInConsole()) {
			
			// publish views
			$this->publishes([
				__DIR__ . '/../resources/views' => resource_path('views/vendor/isotopekit/admin_panel')
			], 'views');

			// publish assets
			$this->publishes([
				__DIR__ . '/../resources/assets' => public_path('admin_panel')
			], 'assets');
		}
	}

	public function register()
	{

	}
}

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

			// migrations
			if (!class_exists('CreateCustomAttributesTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/create_custom_attributes_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_custom_attributes_table.php'),
					// you can add any number of migrations here
				], 'migrations');
			}

			if (!class_exists('AddBonusPointsToUsersTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/add_bonus_points_to_users_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_add_bonus_points_to_users_table.php'),
					// you can add any number of migrations here
				], 'migrations');
			}

			if (!class_exists('CreateSumoTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/create_sumo_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_sumo_table.php'),
					// you can add any number of migrations here
				], 'migrations');
			}

			if (!class_exists('AddCustomizationToSiteSettingsTable')) {
				$this->publishes([
					__DIR__ . '/../database/migrations/add_customization_to_site_settings_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_add_customization_to_site_settings_table.php'),
					// you can add any number of migrations here
				], 'migrations');
			}
			
			// publish config
			$this->publishes([
				__DIR__ . '/../config/config.php' => config_path('isotopekit_admin.php'),
			], 'config');
			
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

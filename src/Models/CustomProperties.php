<?php

namespace IsotopeKit\AdminPanel\Models;

use Illuminate\Database\Eloquent\Model;

class CustomProperties extends Model
{
	protected $table = 'custom_properties';

	protected $fillable = [
		'name', 'unique_name', 'type', 'agency_enabled'
	];
}

## Install
### local
```
"repositories": [
	{
		"type": "path",
		"url": "/packages/admin_panel",
		"options": {
			"symlink": true
		}
	}
]
```

### github
```
"repositories": [
	{
		"type": "vcs",
        "url": "git@github.com:isotopekit/admin_panel.git"
	}
]
```

```
"config": {
	"github-oauth": {
		"github.com": "token_here"
	}
}
```

```
composer require isotopekit/admin_panel @dev
```

## Views

```
php artisan vendor:publish --provider="IsotopeKit\AdminPanel\ServiceProvider" --tag="views"
```

## Assets

```
php artisan vendor:publish --provider="IsotopeKit\AdminPanel\ServiceProvider" --tag="assets"
```

## Config

```
php artisan vendor:publish --provider="IsotopeKit\AdminPanel\ServiceProvider" --tag="config"
```

## Migrations

```
php artisan vendor:publish --provider="IsotopeKit\AdminPanel\ServiceProvider" --tag="migrations"
```

## Db Seed

```
php artisan db:seed --class="IsotopeKit\AdminPanel\Database\Seeders\DatabaseSeeder"
```

## Config

in config/auth.php add
```
'model' => \IsotopeKit\AuthAPI\Models\User::class,
```
under providers users array e.g.
```
'users' => [
    'driver' => 'eloquent',
	'model' => \IsotopeKit\AuthAPI\Models\User::class
],
```
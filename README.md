# Laravel Frontend

Laravel package to provide frontend template routes for non-production environments.

## Installation

```sh
composer require engage/laravel-frontend
```

The package's service provider will be autoloaded on startup.

Next publish the templates and config file:

```sh
php artisan vendor:publish --provider="Engage\LaravelFrontend\ServiceProvider"
```

The files published this way are examples of structure and are not enforced by the package. Edit `config/frontend.php` to change the paths of these files. If you also need to change the filename of `config/frontend.php` see [Config File Customisation](#config-file-customisation).

## Basic Usage

Add the following key to your `.env` file to enable the frontend routes (typically, local and staging:)

```sh
FRONTEND_ENABLED=true
```

If this key is already in use for your project, you can change this in the `config/frontend.php` file.

Now you can visit `/frontend/` and see the templates

## Config File Customisation

By default the package uses the `config/frontend.php` file to define all the settings, such as route name, url path, template file paths etc. The package provides a mechanism to change which file is used, by binding your own instance of `ConfigProvider` in your `AppServiceProvider`. This is useful in cases where `config/frontend.php` is already in use within your project for example.

First create your own provider:

```php
<?php

namespace App\Config;

use Engage\LaravelFrontend\ConfigProvider;

class FrontendConfigProvider extends ConfigProvider
{
    /**
     * Key to use when retrieving config values.
     *
     * @var string
     */
    protected $configKey = 'laravel-frontend';
}
```

Then, add the provider to your bindings on startup.

```php
class AppServiceProvider extends ServiceProvider
{
...

    /**
     * All of the container bindings that should be registered.
     *
     * @var array
     */
    public $bindings = [
        \Engage\LaravelFrontend\ConfigProvider::class => \App\Config\FrontendConfigProvider::class,
    ];

...
}
```

Now, throughout the package when the `ConfigProvider` is requested via the laravel service container, yours will be created instead.

## Laravel Compatibility

Works on Larvel 5.5 and 5.6.

## License

Laravel Tinker is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

<p align="center"><img src="logo.svg" width="474px" alt="Laravel Frontend" /></p>

<p align="center">
<a href="https://travis-ci.org/engageinteractive/laravel-frontend"><img src="https://travis-ci.org/engageinteractive/laravel-frontend.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/engageinteractive/laravel-frontend"><img src="https://poser.pugx.org/engageinteractive/laravel-frontend/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/engageinteractive/laravel-frontend"><img src="https://poser.pugx.org/engageinteractive/laravel-frontend/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/engageinteractive/laravel-frontend"><img src="https://poser.pugx.org/engageinteractive/laravel-frontend/license.svg" alt="License"></a>
</p>

Laravel package to provide frontend template routes for non-production environments.

## Installation

```sh
composer require engageinteractive/laravel-frontend
```

The package's service provider will be autoloaded on startup.

Next publish the templates and config file:

```sh
php artisan vendor:publish --provider="Engage\LaravelFrontend\ServiceProvider"
```

The files published this way are examples of structure and are not enforced by the package. Edit `config/frontend.php` to change the paths of these files. If you also need to change the filename of `config/frontend.php` see [Config File Customisation](#config-file-customisation).

## Basic Usage

Add the following key to your `.env` file to enable the frontend routes (typically, local and staging):

```sh
FRONTEND_ENABLED=true
```

If this key is already in use for your project, you can change this in the `config/frontend.php` file.

Now you can visit `/frontend/` and see the templates

## Config File Customisation

By default the package uses the `config/frontend.php` file to define all the settings, such as route name, URL path, template file paths etc. However, the package uses [Laravel Config Provider](https://github.com/engageinteractive/laravel-config-provider) to allow you change to which file is used. To do so bind your own instance of `ConfigProvider` in your `AppServiceProvider`. This is useful in cases where `config/example-package.php` is already in use within your project for example.

First create your own provider:

```php
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

Now, throughout the package when the `ConfigProvider` is requested via the Laravel service container, yours will be created instead.

## Laravel Compatibility

Works on Laravel 5.5, 5.6 and 5.7.

## License

Laravel Frontend is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

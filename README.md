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
php artisan vendor:publish --provider="EngageInteractive\LaravelFrontend\ServiceProvider"
```

The files published this way are examples of structure and are not enforced by the package. Edit `config/frontend.php` to change the paths of these files. If you also need to change the filename of `config/frontend.php` see [Config File Customisation](#config-file-customisation).

## Basic Usage

Add the following key to your `.env` file to enable the frontend routes (typically, local and staging):

```sh
FRONTEND_ENABLED=true
```

If this key is already in use for your project, you can change this in the `config/frontend.php` file.

Now you can visit `/frontend/` and see the templates.

## Page Defaults

Often within an app, it is useful to have view composers that load fallback variables from a configuration or the database when not provided by the controller explicitly. An example of this could be the page title in the HTML `<head>` for example. Depending on the setup you might not have a database defined when building the frontend templates, or you might not even want the database involved. In this case you still want your layout templates to recieve this variables, but it would be nice to hard code them for all the frontend templates.

To do this you can subclass the `PageDefaultsViewComposer` and add register it within a service provider:

### Subclass and implement your own defaults

```
<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use EngageInteractive\LaravelFrontend\PageDefaultsViewComposer as BaseViewComposer;

class PageDefaultViewComposer extends BaseViewComposer
{
    /**
     * Gets frontend default variables.
     *
     * @return array
     */
    protected function defaultsForFrontend()
    {
        return [
            'page' => [
                'title' => 'HTML Meta Title',
                'description' => 'HTML Meta Description',
                ...
            ],
        ];
    }

    /**
     * Gets application default variables (i.e. ones used when not in the
     * frontend templates.)
     *
     * @return array
     */
    protected function defaultsForApp()
    {
        return [
            'page' => [
                'title' => config('app.name'),
                ...
            ],
        ];
    }
}
```

### Register your ViewComposer

```
<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

use App\Http\ViewComposers\PageDefaultsViewComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Here the 'app/' directory is assumed to be all the individual pages,
        // and does not contain partials, or layouts. This is because the
        // composer will be ran multiple times if the Blade template extends
        // from files also in the 'app/' directory.
        View::composer('app/*', PageDefaultsViewComposer::class);
    }
}

```

## Config File Customisation

By default the package uses the `config/frontend.php` file to define all the settings, such as route name, URL path, template file paths etc. However, the package uses [Laravel Config Provider](https://github.com/engageinteractive/laravel-config-provider) to allow you change to which file is used. To do so bind your own instance of `ConfigProvider` in your `AppServiceProvider`. This is useful in cases where `config/example-package.php` is already in use within your project for example.

First create your own provider:

```php
namespace App\Config;

use EngageInteractive\LaravelFrontend\ConfigProvider;

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
        \EngageInteractive\LaravelFrontend\ConfigProvider::class => \App\Config\FrontendConfigProvider::class,
    ];

...
}
```

Now, throughout the package when the `ConfigProvider` is requested via the Laravel service container, yours will be created instead.

## Laravel Compatibility

Works on Laravel 5.5, 5.6 and 5.7.

## License

Laravel Frontend is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

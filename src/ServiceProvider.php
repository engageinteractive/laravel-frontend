<?php

namespace Engage\LaravelFrontend;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

class ServiceProvider extends BaseServiceProvider
{
    use Concerns\InteractsWithConfigProvider;

    /**
     * Define the routes for the Frontend Build if not in production.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/frontend.php' => config_path('frontend.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../resources/views/app/frontend.blade.php' => resource_path('app/frontend.blade.php'),
            __DIR__.'/../resources/views/frontend/example.blade.php' => resource_path('frontend/example.blade.php'),
        ], 'templates');

        $this->configProvider = $this->app->make(ConfigProvider::class);

        if ($this->configProvider->get('enabled')) {
            $this->mapRoutes();
        }
    }

    /**
     * Define the "frontend" routes for the application. Uses the RouteProvider
     * to define the route context (url prefix, middleware etc.)
     *
     * @return void
     */
    protected function mapRoutes()
    {
        Route::prefix($this->getRoutePath())->middleware('web')->group(function () {
            $routeName = app(ConfigProvider::class)->get('route_name');

            Route::get('/', TemplateController::class . '@index')
                ->name($routeName . '.index');

            Route::match(array_diff(Router::$verbs, ['GET']), '/', TemplateController::class . '@echo')
                ->name($routeName . '.echo');

            Route::any('/{template}', TemplateController::class . '@show')
                ->where('template', '.+$')
                ->name($routeName . '.show');
        });
    }
}

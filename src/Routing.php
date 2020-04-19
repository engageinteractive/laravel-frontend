<?php

namespace Engage\LaravelFrontend;

use Illuminate\Support\Facades\Route;
use Engage\LaravelFrontend\Templates\TemplateController;

class Routing
{
    /**
     * @var string @index route action.
     */
    const ACTION_INDEX = 'index';

    /**
     * @var string @show route action.
     */
    const ACTION_SHOW = 'show';

    /**
     * @var string @echo route action.
     */
    const ACTION_ECHO = 'echo';

    /**
     * @var string {template} route parameter.
     */
    const PARAM_TEMPLATE = 'template';
    
    /**
     * Defines the package routes with middleware
     * and prefix group.
     * 
     * @return void
     */
    public static function routes(): void
    {
        Route::prefix(self::cleanRoutePrefix())
            ->middleware(Config::get('middleware'))
            ->group(function () {
                self::routeTemplateIndex();
                self::routeTemplateEcho();
                self::routeTemplateShow();
            });
    }

    /**
     * Defines template index route.
     * 
     * @return void
     */
    protected static function routeTemplateIndex(): void
    {
        Route::get('/')
            ->uses(TemplateController::class.'@'.self::ACTION_INDEX)
            ->name(self::routeName(self::ACTION_INDEX));
    }

    /**
     * Defines template show route.
     * 
     * @return void
     */
    protected static function routeTemplateShow(): void
    {
        Route::any('{'.self::PARAM_TEMPLATE.'}')
            ->uses(TemplateController::class .'@'.self::ACTION_SHOW)
            ->where(self::PARAM_TEMPLATE, '.+$')
            ->name(self::routeName(self::ACTION_SHOW));
    }

    /**
     * Defines template echo route.
     * 
     * @return void
     */
    protected static function routeTemplateEcho(): void
    {
        Route::any(self::ACTION_ECHO)
            ->uses(TemplateController::class.'@'.self::ACTION_ECHO)
            ->name(self::routeName(self::ACTION_ECHO));
    }

    /**
     * Returns true if the request is running the template show route.
     * 
     * @return bool
     */
    public static function isRunningTemplateRoute(): bool
    {
        return (Route::currentRouteName() == self::routeName(self::ACTION_SHOW));
    }

    /**
     * Returns sanitised route prefix without a
     * trailing slash.
     * 
     * @return string
     */
    public static function cleanRoutePrefix(): string
    {
        return rtrim(Config::get('route_path'), '/');
    }

    /**
     * Returns the name of a route prefixed with
     * the package route prefix.
     *
     * @param string $name
     * 
     * @return string
     */
    public static function routeName(string $name): string
    {
        return Config::get('route_name') . '.' . $name;
    }

    /**
     * Returns the generated URI for a template.
     *
     * @param string $name
     * 
     * @return string
     */
    public static function getTemplateRoute(string $name): string
    {
        return route(self::routeName(self::ACTION_SHOW), [
            self::PARAM_TEMPLATE => $name,
        ]);
    }
}

<?php

namespace Engage\LaravelFrontend;

use Illuminate\Support\ServiceProvider;

class FrontendServiceProvider extends ServiceProvider
{
    /**
     * @var string Config file prefix.
     */
    const CONFIG_PREFIX = 'templates';

    /**
     * Defines Laravel resources and routes.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishesPackageConfig();

        if (Config::get('enabled')) {
            $this->loadPackageRoutes();
            $this->loadPackageViews();
        }
    }

    /**
     * Loads package config publishes.
     *
     * @return void
     */
    protected function publishesPackageConfig()
    {
        $this->publishes([
            __DIR__.'/../config/'.self::CONFIG_PREFIX.'.php' => config_path(self::CONFIG_PREFIX.'.php'),
        ], 'config');
    }

    /**
     * Loads mapped package routes.
     *
     * @return void
     */
    protected function loadPackageRoutes()
    {
        Routing::routes();
    }

    /**
     * Loads package views.
     *
     * @return void
     */
    protected function loadPackageViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'frontend');
    }
}

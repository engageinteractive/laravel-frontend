<?php

namespace Tests;

use Orchestra\Testbench\TestCase as TestBenchTestCase;

use Engage\LaravelFrontend\ServiceProvider;

class TestCase extends TestBenchTestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [ ServiceProvider::class ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app->config->set('app.key', 'AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
        $app->config->set('frontend', require __DIR__.'/../publishes/config/frontend.php');
        $app->config->set('frontend.enabled', true);
    }
}

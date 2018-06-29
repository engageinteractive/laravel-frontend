<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;

use Tests\TestCase;

class ProductionAppTest extends TestCase
{
    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app->config->set('frontend.enabled', false);
    }

    public function test_Given_InProduction_When_RoutesLoaded_Then_ThereAreNoRoutes()
    {
        $this->assertCount(0, Route::getRoutes());
    }
}

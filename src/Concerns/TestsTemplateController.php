<?php

namespace Engage\LaravelFrontend\Concerns;

use PHPUnit\Framework\Assert as PHPUnit;

use Engage\LaravelFrontend\TemplateProvider;
use Engage\LaravelFrontend\ConfigProvider;

trait TestsTemplateController
{
    public function test_When_IndexRouteCalled_Then_200()
    {
        $configProvider = $this->app->make(ConfigProvider::class);
        $configProvider->set('enabled', true);

        $routeName = $configProvider->get('route_name');

        $response = $this->get(route("{$routeName}.index"));
        $response->assertStatus(200);
    }

    public function test_When_ShowRouteCalled_Then_200()
    {
        $configProvider = $this->app->make(ConfigProvider::class);
        $configProvider->set('enabled', true);

        $provider = $this->app->make(TemplateProvider::class);
        $templates = $provider->allTemplatesPaths();

        foreach ($templates as $template)
        {
            $response = $this->get($template);

            PHPUnit::assertEquals(
                $response->status(),
                200,
                'Path "' . $template . '" did not return 200 status code'
            );
        }
    }

    public function test_When_EchoRouteCalled_Then_OutputMatchesInput()
    {
        $configProvider = $this->app->make(ConfigProvider::class);
        $configProvider->set('enabled', true);

        $routeName = $configProvider->get('route_name');

        $status = 418;
        $json = [ 'redirect' => '/test' ];

        $response = $this->post(route("{$routeName}.echo", compact('status', 'json')));

        $response->assertStatus($status);
        $response->assertJson($json);
    }
}

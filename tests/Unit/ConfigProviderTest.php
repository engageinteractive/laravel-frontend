<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config;

use Tests\TestCase;
use EngageInteractive\LaravelFrontend\ConfigProvider;

class ConfigProviderTest extends TestCase
{
    public function test_Given_NoParameters_When_Called_Then_ReturnsAll()
    {
        $this->assertEquals(config('frontend'), (new ConfigProvider)->get());
    }

    public function test_Given_Key_WhenCalled_Then_AccessValueAtPath()
    {
        $this->assertEquals(config('frontend.route_name'), (new ConfigProvider)->get('route_name'));
    }

    public function test_Given_CustomConfigKey_When_Called_Then_UsesCustomKey()
    {
        $provider = new class extends ConfigProvider {
            protected $configKey = 'test';
        };

        Config::set('test', config('frontend'));
        Config::set('frontend', null);

        $this->assertEquals(config('test'), $provider->get());
    }
}

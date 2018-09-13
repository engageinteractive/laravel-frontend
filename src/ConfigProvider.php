<?php

namespace EngageInteractive\LaravelFrontend;

use Illuminate\Support\Facades\Config;

use EngageInteractive\LaravelConfigProvider\ConfigProvider as BaseConfigProvider;

class ConfigProvider extends BaseConfigProvider
{
    /**
     * Key to use when retrieving config values.
     *
     * @var string
     */
    protected $configKey = 'frontend';
}

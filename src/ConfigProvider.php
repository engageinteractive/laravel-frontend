<?php

namespace Engage\LaravelFrontend;

use Illuminate\Support\Facades\Config;

/**
 * Layer that the package uses to interact with the config file that is
 * published regardless of the name uses at runtime.
 */
class ConfigProvider
{
    /**
     * Key to use when retrieving config values. Override this in your
     * subclass if you need to use a different filename.
     *
     * @var string
     */
    protected $configKey = 'frontend';

    /**
     * Retreives config values using the config key property as a prefix to all
     * keys given.
     *
     * @param string  $key  used after the configKey
     * @param string  $default  fallback used if not set
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return Config::get($this->configKey);
        }

        return Config::get("{$this->configKey}.{$key}", $default);
    }

    /**
     * Sets config values using the config key property as a prefix to all
     * keys given.
     *
     * @param string  $key  used after the configKey
     * @param string  $value  value key is set to
     * @return mixed
     */
    public function set($key = null, $value = null)
    {
        if (is_null($key)) {
            return Config::set($this->configKey);
        }

        return Config::set("{$this->configKey}.{$key}", $value);
    }
}

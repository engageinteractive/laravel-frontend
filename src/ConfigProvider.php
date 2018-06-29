<?php

namespace Engage\LaravelFrontend;

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
     * @param string  $key  used after the set configKey
     * @param string  $default  fallback uses if not set.
     * @return mixed
     */
    public function get($key = null, $default = null)
    {
        if (is_null($key)) {
            return config($this->configKey);
        }

        return config("{$this->configKey}.{$key}", $default);
    }
}

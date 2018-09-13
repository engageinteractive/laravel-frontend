<?php

namespace EngageInteractive\LaravelFrontend\Concerns;

use EngageInteractive\LaravelFrontend\ConfigProvider;

/**
 * Convience methods for working with config values, performing common
 * transforms on the values in one place. E.g. trimming trailing slashes.
 */
trait InteractsWithConfigProvider
{
    /**
     * @var ConfigProvider
     */
    protected $configProvider;

    /**
     * Retrieves the ConfigProvider.
     *
     * @return ConfigProvider
     */
    protected function getConfigProvider() : ConfigProvider
    {
        return $this->configProvider;
    }

    /**
     * Gets the Template Path directory, optionally adding on the given
     * template path.
     *
     * @param string  $template
     * @return string
     */
    protected function getTemplatePath(string $template = null) : string
    {
        return rtrim($this->getConfigProvider()->get('resource_path'), '/') . '/' . $template;
    }

    /**
     * Gets the Route Path, optionally adding on the given template path.
     *
     * @param string  $template
     * @return string
     */
    protected function getRoutePath(string $template = null) : string
    {
        return rtrim($this->getConfigProvider()->get('route_path'), '/') . '/' . $template;
    }
}

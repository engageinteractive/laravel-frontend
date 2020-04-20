<?php

namespace Engage\LaravelFrontend;

use Engage\LaravelFrontend\Support\Path;

class Config
{
    /**
     * @var string data file directory.
     */
    const DIR_DATA = '_data';

    /**
     * @var string styleguide directory.
     */
    const DIR_STYLEGUIDE = 'styleguide';

    /**
     * @var array Directories to be excluded from FS search.
     */
    public static $excludeTemplateDirs = [
        self::DIR_DATA,
        self::DIR_STYLEGUIDE,
    ];

    /**
     * Returns config data from templates package config file.
     *
     * @param $key
     * @param $default
     * 
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        return config(FrontendServiceProvider::CONFIG_PREFIX.'.'.$key, $default);
    }

    /**
     * Returns relative resource path from views.
     *
     * @return string
     */
    public static function getRelativeResourcePath(): string
    {
        return Path::trimTrailingSlash(self::get('resource_path'));
    }

    /**
     * Returns absolute resource path.
     *
     * @return string
     */
    public static function getAbsoluteResourcePath(): string
    {
        $path = Path::join('views', self::getRelativeResourcePath());
        return realpath(resource_path($path));
    }

    /**
     * Returns absolute data path.
     *
     * @return string
     */
    public static function getAbsoluteDataPath(): string
    {
        return Path::join(self::getAbsoluteResourcePath(), self::DIR_DATA);
    }
}

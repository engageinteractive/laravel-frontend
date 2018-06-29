<?php

namespace Engage\LaravelFrontend;

use Illuminate\Support\Facades\File;

class TemplateProvider
{
    /**
     * Creates an instance of TemplateProvider
     *
     * @param ConfigProvider  $configProvider
     * @return void
     */
    public function __construct(ConfigProvider $configProvider)
    {
        $this->configProvider = $configProvider;
    }

    /**
     * Gets all the template paths for the frontend static build, with their
     * 'frontend/' path prefixes and without their '.blade.php' suffixes.
     *
     * @return \Illuminate\Support\Collection<string>
     */
    public function allTemplatesPaths()
    {
        $resourcePath = resource_path('views/');
        $templatePath = $this->configProvider->get('resource_path');
        $pathPrefix = $resourcePath . rtrim($templatePath, '/');

        $files = File::allFiles($pathPrefix);

        return collect($files)->sort()->map(function ($file) use ($pathPrefix) {
            $withoutPrefix = substr($file, strlen($pathPrefix));

            // Finally, remove the file extension
            $path = preg_replace('/\.blade\.php$/', '', $withoutPrefix);

            return $this->configProvider->get('route_path') . $path;
        });
    }
}

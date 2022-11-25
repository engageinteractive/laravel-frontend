<?php

use Engage\LaravelFrontend\Data\DataFile;
use Engage\LaravelFrontend\Templates\TemplateService;
use Engage\LaravelFrontend\Routing;

if (! function_exists('_use')) {
    /**
     * Returns the result of a data file.
     *
     * @param string $key
     * 
     * @return mixed
     */
    function _use($key)
    {
        return (new DataFile)->use($key);
    }
}

if (! function_exists('str_format_domain')) {
    /**
     * Returns the reverse string of a slug, with each
     * word in uppercase.
     *
     * @return string
     */
    function str_format_domain($string)
    {
        return ucwords(TemplateService::strReverseSlug($string));
    }
}

if (! function_exists('templates_echo')) {
    function templates_echo($data = [], $status = 200)
    {
        $parameters = [
            'status' => $status,
        ];

        if ($data) {
            $parameters['data'] = base64_encode(json_encode($data));
        }

        return route(
            name: Routing::routeName(Routing::ACTION_ECHO),
            parameters: $parameters,
        );
    }
}

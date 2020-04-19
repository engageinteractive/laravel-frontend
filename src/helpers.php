<?php

use Engage\LaravelFrontend\Data\DataFile;
use Engage\LaravelFrontend\Mocking\Mock;

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

if (! function_exists('_mock')) {
    /**
     * Returns an instance of Mock.
     *
     * @return \Engage\LaravelFrontend\Mocking\Mock
     */
    function _mock()
    {
        return new Mock;
    }
}

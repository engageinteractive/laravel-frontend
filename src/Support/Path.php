<?php

namespace Engage\LaravelFrontend\Support;

class Path
{
    /**
     * Returns leading name component of path.
     *
     * @param string $path
     * 
     * @return string
     */
    public static function leadingName(string $path): string
    {
        if (strpos($path, DIRECTORY_SEPARATOR)) {
            $components = self::components($path);

            if (is_array($components) && count($components) > 0) {
                return $components[0];
            }
        }

        return $path;
    }

    /**
     * Trims trailing slash from a path.
     *
     * @param string $path
     * 
     * @return string
     */
    public static function trimTrailingSlash(string $path): string
    {
        return rtrim($path, DIRECTORY_SEPARATOR);
    }
    
    /**
     * Trims leading slash from a path.
     *
     * @param string $path
     * 
     * @return string
     */
    public static function trimLeadingSlash(string $path): string
    {
        return ltrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Trims leading and trailing slashes from a path.
     *
     * @param string $path
     * 
     * @return string
     */
    public static function trimSlashes(string $path): string
    {
        return trim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Removes string from the first occurance of a dot.
     *
     * @param string $path
     * 
     * @return string
     */
    public static function withoutExtension(string $path): string
    {
        if (!strpos($path, '.')) {
            return $path;
        }

        return substr($path, 0, strpos($path, '.'));
    }

    /**
     * Breaks a path down into components and returns
     * parts in an array.
     *
     * @param string $path
     * 
     * @return array
     */
    public static function components(string $path): array
    {
        if (!strpos($path, DIRECTORY_SEPARATOR)) {
            return [$path];
        }

        return explode(DIRECTORY_SEPARATOR, $path);
    }

    /**
     * Breaks a path down into components and returns
     * parts in an array.
     *
     * @param string $path
     * 
     * @return string
     */
    public static function withoutRoot(string $path): string
    {
        if (strpos($path, DIRECTORY_SEPARATOR)) {
            $components = self::components($path);

            if (is_array($components) && count($components) > 0) {
                unset($components[0]);
                return implode(DIRECTORY_SEPARATOR, $components);
            }
        }

        return $path;
    }

    /**
     * Joins strings together with directory separator
     * to create a path.
     *
     * @param string ...$paths
     * 
     * @return string
     */
    public static function join(string ...$paths): string
    {
        return implode(DIRECTORY_SEPARATOR, $paths);
    }
}

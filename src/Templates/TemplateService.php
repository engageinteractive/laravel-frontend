<?php

namespace Engage\LaravelFrontend\Templates;

use Engage\LaravelFrontend\File\FileParser;
use Engage\LaravelFrontend\Support\Path;
use Engage\LaravelFrontend\Routing;
use Engage\LaravelFrontend\Config;
use Symfony\Component\Finder\Finder;

class TemplateService
{
    /**
     * Returns an array representation directory structure of templates.
     *
     * @return array
     */
    public function getTemplates(): array
    {
        $files = $this->getFinderFiles();

        $templates = [];

        foreach ($files as $file) {
            $path = Path::withoutExtension($file->getRelativePathname());
            $domain = Path::leadingName($path);
            $templates[$domain][] = $this->processFile($file);
        }

        // Errors should always show last.
        if (isset($templates['errors'])) {
            $errors = $templates['errors'];
            unset($templates['errors']);
            $templates['errors'] = $errors;
        }
        
        return $templates;
    }

    /**
     * Generates the data structure for a template file.
     *
     * @param 
     * 
     * @return array
     */
    protected function processFile($file): array
    {
        $path = Path::withoutExtension($file->getRelativePathname());

        $parser = new FileParser($file->getRealPath());
        $meta = $parser->getMeta();

        $templateData = [
            'path' => Routing::getTemplateRoute($path),
            'located' => $file->getRelativePathname(),
            'name' => Path::withoutRoot($path),
        ];

        return array_merge($templateData, $meta);
    }

    /**
     * Searches and returns an istance of Finder with files from the 
     * templates directory, sorted by name.
     *
     * @return \Symfony\Component\Finder\Finder
     */
    protected function getFinderFiles()
    {
        $resourcePath = Config::getAbsoluteResourcePath();
        $pathPrefix = Path::trimTrailingSlash($resourcePath);
        
        return Finder::create()
            ->files()
            ->in($pathPrefix)
            ->name('*.blade.php')
            ->notName('_*')
            ->notPath(Config::$excludeTemplateDirs)
            ->sortByName();
    }
    
    /**
     * Returns the full template view path.
     *
     * @param string|null $template
     * 
     * @return string
     */
    public function getTemplatePath(string $template = null) : string
    {
        $resourcePath = Config::getRelativeResourcePath();
        return Path::join($resourcePath, $template);
    }

    /**
     * Coverts a string from a slug back into a word.
     *
     * @param string
     * 
     * @return string
     */
    public static function strReverseSlug(string $string) : string
    {
        return str_replace('-', ' ', $string);
    }
}

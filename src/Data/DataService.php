<?php

namespace Engage\LaravelFrontend\Data;

use Symfony\Component\Finder\Finder;
use Illuminate\Config\Repository;
use Engage\LaravelFrontend\Config;

class DataService
{
    /**
     * Factory method to return data file repository.
     * 
     * @return \Illuminate\Config\Repository
     */
    public static function repository()
    {
        return (new self)->getDataRepository();
    }

    /**
     * Returns a repository of all data in data files.
     * 
     * @return \Illuminate\Config\Repository
     */
    public function getDataRepository()
    {
        $files = $this->getDataFiles();

        $repository = new Repository;

        foreach ($files as $key => $path) {
            $repository->set($key, require $path);
        }
        
        return $repository;
    }

    /**
     * Gets a flat array of data files.
     * 
     * @return array
     */
    protected function getDataFiles(): array
    {
        $path = Config::getAbsoluteDataPath();
        $results = $this->searchFilesystem($path);
        $files = [];
        
        foreach ($results as $file) {
            $output = $this->processFile($file, $path);
            $files[$output['name']] = $output['path'];
        }

        ksort($files, SORT_NATURAL);

        return $files;
    }

    /**
     * Processes a file, and returns array with the
     * dot-syntax name, and the realpath.
     * 
     * @param \Symfony\Component\Finder\SplFileInfo $file
     * @param string $path
     * 
     * @return array
     */
    protected function processFile($file, $path)
    {
        $this->validateDataFile($file);

        $directory = $file->getPath();

        if ($nested = trim(str_replace($path, '', $directory), DIRECTORY_SEPARATOR)) {
            $nested = str_replace(DIRECTORY_SEPARATOR, '.', $nested).'.';
        }
        
        return [
            'name' => $nested.basename($file->getRealPath(), '.'.DataFile::EXT),
            'path' => $file->getRealPath(),
        ];
    }

    /**
     * Validates the contents of a data file.
     *
     * @param \Symfony\Component\Finder\SplFileInfo $file
     * 
     * @return void
     * @throws \Engage\LaravelFrontend\Data\DataFileException
     */
    protected function validateDataFile($file): void
    {
        $contents = $file->getContents();

        if (strpos($contents, '_use(')) {
            throw new DataFileException('Circular reference in '.$file->getRelativePathname());
        }
    }

    /**
     * Returns finder instance representation of
     * the data filesystem.
     *
     * @param string $path
     * 
     * @return \Symfony\Component\Finder\Finder
     */
    protected function searchFilesystem(string $path)
    {
        return Finder::create()
            ->files()
            ->in($path)
            ->name('*.'.DataFile::EXT);
    }
}

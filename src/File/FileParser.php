<?php

namespace Engage\LaravelFrontend\File;

use Illuminate\Support\Str;
use SplFileObject;
use Exception;

class FileParser
{
    const TOKEN = '@';
    const STOP_TOKEN = '@extends';

    protected $path;
    protected $file;

    protected $reserved = [
        'path',
        'located',
    ];

    /**
     * Initiates FileParser with working file.
     *
     * @param string $path
     * 
     * @return void
     */
    public function __construct(string $path)
    {
        $this->path = $path;
        $this->file = new SplFileObject($path);
    }

    /**
     * Returns meta information from working file.
     * 
     * @return array
     */
    public function getMeta(): array
    {
        $meta = [];

        foreach ($this->file as $line) {
            if ($this->shouldStopParse($line)) {
                break;
            }

            $comment = $this->isBladeComment($line);

            if (!$comment) {
                continue;
            }

            if (!$this->isMetaToken($comment)) {
                continue;
            }

            $parsed = $this->processMetaTokenLine($comment);
            $meta[$parsed['key']] = $parsed['value'];
        }

        return $meta;
    }

    /**
     * Returns false if the line is not a comment
     * or returns the matched string if it is.
     *
     * @param string $line
     * 
     * @return string|false
     */
    protected function isBladeComment(string $line)
    {
        preg_match('/{{--(.*?)--}}/s', $line, $matches);

        if (! $matches) {
            return false;
        }

        return (isset($matches[1])) ? trim($matches[1]) : false;
    }

    /**
     * Returns true if the line starts with the meta token.
     *
     * @param string $line
     * 
     * @return bool
     */
    protected function isMetaToken(string $line): bool
    {
        return Str::startsWith(trim($line), self::TOKEN);
    }

    /**
     * Returns true if the line starts with the stop token.
     *
     * @param string $line
     * 
     * @return bool
     */
    protected function shouldStopParse(string $line): bool
    {
        return Str::startsWith(trim($line), self::STOP_TOKEN);
    }

    /**
     * Returns key/value pair from meta line.
     * Throws if the key is a reserved word.
     *
     * @param string $line
     * 
     * @return array
     * @throws \Exception
     */
    protected function processMetaTokenLine(string $line): array
    {
        $line = Str::replaceFirst(self::TOKEN, null, $line);
        $words = explode(' ', $line, 2);
        $key = array_shift($words);
        $value = $words[0] ?? null;

        if (in_array($key, $this->reserved)) {
            throw new Exception(self::TOKEN.$key. ' is a reserved word in: '.$this->path);
        }

        return ['key' => $key, 'value' => $value];
    }
}

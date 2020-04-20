<?php

namespace Engage\LaravelFrontend\Mocking;

use Faker\Generator;
use Faker\Provider\en_GB\Person;
use Faker\Provider\Lorem;
use Faker\Provider\Internet;

class Mock
{
    protected $generator;

    /**
     * Intialises the class with a faker instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->generator = $this->getFakerInstance();
    }

    /**
     * Returns a random name.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->generator->name;
    }

    /**
     * Returns a random first name, an optional gender can be passed.
     *
     * @return string
     */
    public function firstName($gender = null)
    {
        return $this->generator->firstName($gender);
    }

    /**
     * Returns a random last name.
     *
     * @return string
     */
    public function lastName(): string
    {
        return $this->generator->lastName;
    }

    /**
     * Returns a random Lorem Ipsum word.
     *
     * @return string
     */
    public function word(): string
    {
        return $this->generator->word;
    }

    /**
     * Returns a string of the specified number of words
     * if no words are passed, it will generate words between 3 and 6.
     *
     * @return string|array
     */
    public function words(int $words = null, bool $asText = true)
    {
        if (!$words) {
            return $this->wordsBetween(3,6);
        }

        return $this->generator->words($words, $asText);
    }

    /**
     * Returns a random Lorem Ipsum string between
     * the passed min and max using a random number generator.
     *
     * @return string|array
     */
    public function wordsBetween(int $min, int $max, bool $asText = true)
    {
        $words = mt_rand($min, $max);

        return $this->generator->words($words, $asText);
    }

    /**
     * Returns the Faker generator instance.
     * 
     * @return \Faker\Generator
     */
    public function generate()
    {
        return $this->generator;
    }

    /**
     * Returns an instance of Faker.
     *
     * @return \Faker\Generator
     */
    protected function getFakerInstance()
    {
        $generator = new Generator;
        $generator->addProvider(new Person($generator));
        $generator->addProvider(new Lorem($generator));
        $generator->addProvider(new Internet($generator));

        return $generator;
    }
}

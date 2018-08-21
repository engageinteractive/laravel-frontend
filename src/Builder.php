<?php

namespace Engage\LaravelFrontend;

abstract class Builder
{
    /**
     * Builds the array version on the input parameter.
     *
     * @param mixed  $source
     * @return Array
     */
    public function build($source)
    {
        return $this->buildOne($source);
    }

    /**
     * Applies the buildOne method to each element in the iterable.
     *
     * @param iterable  $iterable
     * @return Array[]
     */
    public function buildAll(iterable $iterable)
    {
        return array_values(array_map( [ $this, 'buildOne' ], $iterable ));
    }

    /**
     * Transform the source into a simple nested array.
     *
     * @param mixed  $source
     * @return array
     */
    abstract public function buildOne($source);

    /**
     * Calls array_set using args if $value is not null.
     *
     * @param array  &$model
     * @param string  $path
     * @param mixed  $value
     * @return void
     */
    protected function assignNotNull(&$model, $path, $value)
    {
        if ($value === null) {
            return;
        }

        array_set($model, $path, $value);
    }
}

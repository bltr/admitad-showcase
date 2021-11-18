<?php

namespace App\Utils;

use ArrayIterator;
use Closure;
use Illuminate\Support\LazyCollection as BaseLazyCollection;
use IteratorAggregate;

class LazyCollection extends BaseLazyCollection
{
    public function __construct($source = null)
    {
        if ($source instanceof Closure || $source instanceof self || $source instanceof \Traversable) {
            $this->source = $source;
        } elseif (is_null($source)) {
            $this->source = static::empty();
        } else {
            $this->source = $this->getArrayableItems($source);
        }
    }

    public function makeIterator($source)
    {
        if ($source instanceof IteratorAggregate) {
            return $source->getIterator();
        }

        if ($source instanceof \Iterator) {
            return $source;
        }

        if (is_array($source)) {
            return new ArrayIterator($source);
        }

        return $source();
    }
}

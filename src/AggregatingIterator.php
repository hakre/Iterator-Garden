<?php
/*
 * Iterator Garden
 */

/**
 * Class AggregatingIterator
 *
 * Iterator that aggregates an Iterator on rewind()
 */
class AggregatingIterator extends TraversableDecorator
{
    private $iterator;

    public function __construct(Traversable $iterator)
    {
        $this->iterator = $iterator;
    }

    public function getIterator()
    {
        return new IteratorIterator($this->iterator);
    }

    public function rewind()
    {
        $this->traversable = $this->getIterator();
    }
}

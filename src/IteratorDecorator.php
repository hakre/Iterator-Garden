<?php
/**
 * Iterator Garden
 */

/**
 * IteratorDecorator
 *
 * Iterator Decorator class that also allows to set the Iterator
 */
class IteratorDecorator extends TraversableDecorator implements OuterIterator
{
    public function __construct(Iterator $iterator)
    {
        $this->setInnerIterator($iterator);
    }

    public function getInnerIterator()
    {
        return $this->traversable;
    }

    public function setInnerIterator(Iterator $iterator)
    {
        $this->traversable = $iterator;
    }
}

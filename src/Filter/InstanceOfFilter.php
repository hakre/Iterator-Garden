<?php
/*
 * Iterator Garden
 */

/**
 * Class InstanceOfFilter
 *
 * General purpose type filter.
 */
class InstanceOfFilter extends FilterIterator
{
    private $className;

    public function __construct(Iterator $iterator, $className) {
        parent::__construct($iterator);

        $this->className = $className;
    }

    public function accept() {
        return ($this->getInnerIterator()->current() instanceof $this->className);
    }
}

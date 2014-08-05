<?php
/*
 * Iterator Garden
 */

/**
 * Class DebugFilterIterator
 *
 * A Debug FilterIterator based on a DebugIteratorIterator which is a IteratorIterator and not
 * a TraversableDecorator.
 *
 * Useful to test differences between parent::current() and $this->getInnerIterator()->current()
 */
class DebugFilterIterator extends FilterIterator implements DebugIteratorModes
{
    private $innerIterator;
    private $debugIterator;

    public function __construct(Iterator $iterator)
    {
        $this->innerIterator = $iterator;
        $this->debugIterator = new DebugIteratorIterator($iterator);

        parent::__construct($this->debugIterator);
    }

    public function getInnerIterator()
    {
        return $this->innerIterator;
    }

    public function accept()
    {
        $this->debugIterator->debugEvent(__FUNCTION__ . '()');
        $current = $this->innerIterator->current();
        $this->debugIterator->debugEvent(
            sprintf('self::$innerIterator::current() is %s', DebugIterator::debugVarLabel($current))
        );

        return TRUE;
    }
}

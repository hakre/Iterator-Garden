<?php
/*
 * Iterator Garden
 */

/**
 * Class NumericKeyIterator
 *
 * Iteration that has an Index as key
 */
class NumericKeyIterator extends IndexIteration
{
    public function key()
    {
        return $this->getIndex();
    }
}

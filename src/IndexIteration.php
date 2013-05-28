<?php
/**
 * Iterator Garden
 */

/**
 * Class IndexIteration
 *
 * An Iteration that keeps an Index while iterating
 */
class IndexIteration extends IteratorIterator
{
    private $index;

    public function rewind() {
        $this->index = 0;
        parent::rewind();
    }

    public function next() {
        parent::valid() && $this->index++;
        parent::next();
    }

    public function getIndex() {
        return $this->index;
    }
}

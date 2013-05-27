<?php
/**
 * Iterator Garden
 */

abstract class ForeachFilterIterator extends FilterIterator
{
    public function __construct($foreachAble) {
        parent::__construct(ForeachIterator::getIterator($foreachAble));
    }
}

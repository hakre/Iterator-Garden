<?php
/**
 * Iterator Garden
 */

/**
 * Class CountFilterIterator
 */
class CountFilterIterator extends ForeachFilterIterator
{
    /**
     * @var int
     */
    private $count;

    public function __construct($foreachAble, $count = 1)
    {
        $this->count = (int)$count;
        parent::__construct($foreachAble);
    }

    public function accept()
    {
        return $this->count === count($this->current());
    }
}

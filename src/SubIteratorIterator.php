<?php
/**
 * Iterator Garden
 */

/**
 * Class SubIteratorIterator
 */
class SubIteratorIterator extends TraversableDecorator
{
    const UP = 0;
    const DOWN = 1;
    const USE_ITERATOR = 0;
    const USE_KEY = 1;

    /**
     * @var RecursiveIteratorIterator
     */
    private $iterator;

    private $flags;
    private $direction;

    public function __construct(RecursiveIteratorIterator $iterator, $flags = self::USE_ITERATOR, $direction = self::UP)
    {
        $this->iterator  = $iterator;
        $this->flags     = (int)$flags;
        $this->direction = (int)(bool)$direction;

        parent::__construct();
    }

    public function rewind()
    {
        $low  = 0;
        $high = $this->iterator->getDepth();

        if ($this->direction === self::DOWN) {
            list($high, $low) = array($low, $high);
        }

        $this->traversable = new RangeIterator($low, $high, 1);
    }

    public function current()
    {
        $level = parent::current();

        $subIterator = $this->iterator->getSubIterator($level);

        return ($this->flags & self::USE_KEY) ? $subIterator->key() : $subIterator;
    }
}

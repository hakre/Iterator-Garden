<?php
/**
 * Iterator Garden
 */

/**
 * Iterator that caches up to a whole iteration while iterating
 *
 * In difference to CachingIterator:
 *
 *  - Keeps a cache of data and state: current, key and valid.
 *  - Does not rewind (like NoRewindIterator)
 *  - Accepts any kind of key values incl. those that lead to data-loss
 *    with CachingIterator.
 */
class FullCachingIterator extends IteratorIterator
{
    /**
     * @var int|NULL
     */
    private $index;

    /**
     * @var IterationStep[]
     */
    private $steps;

    /**
     * @var IterationStep
     */
    private $cache;

    public function __construct(Traversable $iterator)
    {
        parent::__construct($iterator);
    }

    public function rewind()
    {
        if (!isset($this->index)) {
            parent::rewind();
            $this->steps[0] = IterationStep::createFromIterator($this->getInnerIterator());
        }
        $this->cache = $this->steps[$this->index = 0];
    }

    public function valid()
    {
        return $this->cache->getValid();
    }

    public function current()
    {
        return $this->cache->getCurrent();
    }

    public function key()
    {
        return $this->cache->getKey();
    }

    public function next()
    {
        $index = ++$this->index;
        if (!isset($this->steps[$index])) {
            parent::next();
            $this->steps[$index] = IterationStep::createFromIterator($this->getInnerIterator());
        }
        $this->cache = $this->steps[$index];
    }
}

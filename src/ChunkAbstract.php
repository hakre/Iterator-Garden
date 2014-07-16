<?php
/**
 * Iterator Garden
 */

/**
 * Class ChunkAbstract
 */
abstract class ChunkAbstract implements Iterator
{
    /**
     * @var Iterator
     */
    protected $traversable;

    protected $size;

    protected $standAlone = true;

    /**
     * @param Traversable $traversable
     * @param int         $size
     */
    final public function __construct(Traversable $traversable, $size) {
        $this->setTraversable($traversable);
        $this->size = max(0, (int) $size);
    }

    /**
     * @param Traversable $traversable
     */
    protected function setTraversable(Traversable $traversable)
    {
        $this->traversable =
            $traversable instanceof Iterator
                ? $traversable
                : new IteratorIterator($traversable);
    }

    public function rewind()
    {
        $this->traversable->rewind();
    }

    public function valid()
    {
        return $this->traversable->valid();
    }

    public function current()
    {
        return $this->traversable->current();
    }

    public function key()
    {
        return $this->traversable->key();
    }

    public function next()
    {
        $this->traversable->next();
    }
}

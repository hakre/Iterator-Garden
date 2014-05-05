<?php
/**
 * Iterator Garden
 */

/**
 * Class TraversableDecorator
 *
 * A Decorator Class for a Traversable (Iterator)
 *
 * Because Traversable can not be implemented in PHP Userspace, Iterator - which is a Traversable - is implemented
 */
class TraversableDecorator implements Iterator
{
    /**
     * @var Iterator
     */
    protected $traversable;

    /**
     * @param Traversable $traversable (optional)
     */
    public function __construct(Traversable $traversable = NULL)
    {
        $traversable || $traversable = new EmptyIterator();

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

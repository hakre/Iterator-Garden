<?php
/**
 * Iterator Garden
 */

/**
 * CountableForeachIterator Class A
 *
 * For Class A/B/C see ForeachIterator
 */
class CountableForeachIterator extends IteratorIterator implements Countable
{
    public function __construct($iterable)
    {
        if (is_array($iterable)) {
            $iterator = new ArrayIterator($iterable);
        } elseif ($iterable instanceof Traversable) {
            $iterator = $iterable;
        } elseif (is_object($iterable)) {
            $iterator = new ArrayObject($iterable);
        } else {
            throw new InvalidArgumentException('Not an Array, Traversable or Object.');
        }

        parent::__construct($iterator);
    }

    public function count()
    {
        $inner = $this->getInnerIterator();
        if ($inner instanceof Countable) {
            return $inner->count();
        }

        return iterator_count($this);
    }
}

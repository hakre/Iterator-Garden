<?php
/**
 * Iterator Garden
 */

/**
 * ForeachIterator Class A
 *
 *  A: Wrapped with SPL existing
 *  B: reset() / current() / key() / next() (/end() / prev())
 *  C: generator (PHP 5.5)
 */
class ForeachIterator extends IteratorIterator
{
    /**
     * @param array|object $foreachAble
     * @return Iterator
     */
    public static function getIterator($foreachAble)
    {
        return $foreachAble instanceof Iterator ? $foreachAble : new ArrayIterator($foreachAble);
    }

    /**
     * @param array|object $foreachAble
     * @return Traversable
     */
    public static function getTraversable($foreachAble)
    {
        return $foreachAble instanceof Traversable ? $foreachAble : new ArrayIterator($foreachAble);
    }

    public function __construct($foreachAble)
    {
        parent::__construct(self::getTraversable($foreachAble));
    }
}

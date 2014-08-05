<?php
/*
 * Iterator Garden
 */

/**
 * ForeachIterator Class B
 *
 *  A: Wrapped with SPL existing
 *  B: reset() / current() / key() / next() (/end() / prev())
 *  C: generator (PHP 5.5)
 */
class ForeachIteratorB implements Iterator
{
    private $subject;
    private $key;

    /**
     * @param array|object $foreachAble
     */
    public function __construct($foreachAble)
    {
        $this->subject = $foreachAble;
    }

    public function rewind() {
        reset($this->subject);
        $this->key = key($this->subject);
    }

    public function valid() {
        return NULL !== $this->key;
    }

    public function current() {
        return current($this->subject);
    }

    public function key() {
        return $this->key;
    }

    public function next() {
        next($this->subject);
        $this->key = key($this->subject);
    }
}

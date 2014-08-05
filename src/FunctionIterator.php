<?php
/*
 * Iterator Garden
 */

/**
 * Class ApplyIterator
 *
 * Iteration of a function until it returns a false-y value
 */
class FunctionIterator implements Iterator
{
    private $position;
    private $current;
    private $function;

    public function __construct(callable $function)
    {
        $this->function = $function;
    }

    public function rewind()
    {
        if (NULL !== $this->position) {
            return;
        }
        $this->position = 0;
        $this->current  = call_user_func($this->function);
    }

    public function valid()
    {
        return (bool)$this->current;
    }

    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        if (!$this->current) {
            return;
        }
        $this->position++;
        $this->current = call_user_func($this->function);
    }
}

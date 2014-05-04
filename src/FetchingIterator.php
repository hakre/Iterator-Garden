<?php
/**
 * Iterator Garden
 */

/**
 * Class FetchingIterator
 */
class FetchingIterator implements Iterator
{
    private $callback;
    private $index;
    private $current;
    private $valid;
    private $stopValue;

    /**
     * @param Callable $callback
     * @param mixed $stopValue (optional)
     */
    public function __construct($callback, $stopValue = NULL)
    {
        if (!is_callable($callback, TRUE)) {
            throw new InvalidArgumentException('Invalid callback given.');
        }
        $this->callback = $callback;
        $this->stopValue = $stopValue;
    }

    public function rewind()
    {
        $this->index = -1;
        $this->fetchNext();
    }

    public function valid()
    {
        return $this->valid;
    }

    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->fetchNext();
    }

    protected function fetchNext()
    {
        $this->index++;
        $this->valid = $this->stopValue !== $this->current = call_user_func($this->callback);
    }
}

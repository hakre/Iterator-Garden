<?php
/*
 * Iterator Garden
 */

class ExpandingIterator extends TraversableDecorator
{
    const CATCH_GET_CHILD = 16;

    /**
     * @var Iterator
     */
    private $subject;
    private $flags;

    public function __construct(Iterator $iterator, $flags = 0)
    {
        $this->subject = $iterator;
        $this->flags = (int) $flags;

        parent::__construct(new EmptyIterator());
    }

    public function rewind()
    {
        $this->subject->rewind();
        $this->push();
    }

    public function next()
    {
        $this->traversable->next();

        if ($this->traversable->valid()) {
            return;
        }

        $this->subject->next();
        $this->push();
    }

    private function push()
    {
        ($this->flags & self::CATCH_GET_CHILD)
            ? $this->pushCatch()
            : $this->pushStd();
    }

    private function pushCatch() {
        while ($this->subject->valid()) {
            try {
                $this->traversable = new IteratorIterator($this->subject->current());
            } catch (Exception $e) {
                $this->subject->next();
                continue;
            }
            $this->traversable->rewind();
            break;
        }
    }

    private function pushStd() {
        if ($this->subject->valid()) {
            $this->traversable = new IteratorIterator($this->subject->current());
            $this->traversable->rewind();
        }
    }
}

<?php
/*
 * Iterator Garden
 */

class DebugCountingIteratorDecorator extends IteratorDecorator
{
    private $rewindCount;

    public function getRewindCount() {
        return $this->rewindCount;
    }

    public function rewind()
    {
        $this->rewindCount++;
        parent::rewind();
    }
}

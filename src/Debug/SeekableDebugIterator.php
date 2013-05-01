<?php
/**
 * Iterator Garden
 */

/**
 * Class SeekableDebugIterator
 *
 * A DebugIterator that shows seekable events.
 */
class SeekableDebugIterator extends DebugIterator implements SeekableIterator
{
    public function __construct(SeekableIterator $it)
    {
        parent::__construct($it);
    }

    public function seek($position) {
        $this->event(sprintf('%s %d', __FUNCTION__, $position));
        $this->getInnerIterator()->seek($position);
    }
}

<?php
/**
 * Iterator Garden
 */

/**
 * Class IteratorChunk
 */
final class IteratorChunk extends ChunkAbstract
{
    private $count;

    public function rewind() {
        $this->count = $this->size;
    }

    public function next() {
        $this->count
        && (--$this->count || $this->standAlone)
        && parent::next();
    }

    public function valid() {
        return $this->count && parent::valid();
    }
}

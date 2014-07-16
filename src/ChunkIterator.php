<?php
/**
 * Iterator Garden
 */


/**
 * Class ChunkIterator
 */
final class ChunkIterator extends ChunkAbstract
{
    private $index;

    public function rewind() {
        $this->index = 0;
        parent::rewind();
    }

    public function current() {
        $chunk = new IteratorChunk($this->traversable, $this->size);
        $chunk->standAlone = false;
        return $chunk;
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        $this->index++;
        parent::next();
    }
}

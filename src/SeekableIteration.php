<?php
/**
 * Iterator Garden
 */

/**
 * Class SeekableIteration
 *
 * Iteration that is Seekable
 */
class SeekableIteration extends IndexIteration implements SeekableIterator
{
    private $skipNextRewind;
    private $seekStartPosition;

    public function rewind()
    {
        $this->skipNextRewind || parent::rewind();
        $this->skipNextRewind = FALSE;
        if ($this->seekStartPosition) {
            $this->seek($this->seekStartPosition);
            $this->seekStartPosition = 0;
        }
    }

    public function next()
    {
        $this->skipNextRewind || parent::next();
        $this->skipNextRewind = FALSE;
    }

    /**
     * @param int $position
     * @param bool $skipNextRewind (optional) Ignore the next rewind() or next() - allows to offset
     * @throws InvalidArgumentException
     */
    public function seek($position, $skipNextRewind = FALSE)
    {

        $position = max(0, (int)$position);

        $index = $this->getIndex();

        if (NULL === $index) {
            parent::rewind();
            $index = 0;
        }

        if ($position < $index) {
            throw new InvalidArgumentException(
                sprintf("%s is forward only but seek-position %d is lower than offset %d.", __CLASS__, $position, $index)
            );
        }

        while ($this->valid() and $index++ < $position) {
            $this->next();
        }

        $this->skipNextRewind = (bool)$skipNextRewind;
    }

    /**
     * set starting position for next iteration
     *
     * @param $position
     * @return $this
     */
    public function seekStart($position)
    {

        $this->seekStartPosition = max(0, (int)$position);

        return $this;

    }
}


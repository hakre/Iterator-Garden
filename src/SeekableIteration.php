<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2013, 2014 hakre <http://hakre.wordpress.com/>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
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


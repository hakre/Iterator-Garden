<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2014 hakre <http://hakre.wordpress.com/>
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

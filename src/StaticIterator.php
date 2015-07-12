<?php
/*
 * Iterator Garden - Let Iterators grow like flowers in the garden.
 * Copyright 2015 hakre <http://hakre.wordpress.com/>
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
 * Class StaticIterator
 *
 * A StaticIterator is an iterator that can not move, both rewind() and next()
 */
class StaticIterator implements OuterIterator
{
    /**
     * @var Iterator
     */
    private $iterator;

    public function __construct(Iterator $iterator)
    {
        $this->iterator = $iterator;
    }

    public function rewind()
    {
    }

    public function valid()
    {
        return $this->iterator->valid();
    }

    public function current()
    {
        return $this->iterator->current();
    }

    public function key()
    {
        return $this->iterator->key();
    }

    public function next()
    {
    }

    /**
     * @return Iterator The inner iterator for the current entry.
     */
    public function getInnerIterator()
    {
        return $this->iterator;
    }
}

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

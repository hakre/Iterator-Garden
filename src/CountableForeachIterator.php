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
 * CountableForeachIterator Class A
 *
 * For Class A/B/C see ForeachIterator
 */
class CountableForeachIterator extends IteratorIterator implements Countable
{
    public function __construct($iterable)
    {
        if (is_array($iterable)) {
            $iterator = new ArrayIterator($iterable);
        } elseif ($iterable instanceof Traversable) {
            $iterator = $iterable;
        } elseif (is_object($iterable)) {
            $iterator = new ArrayObject($iterable);
        } else {
            throw new InvalidArgumentException('Not an Array, Traversable or Object.');
        }

        parent::__construct($iterator);
    }

    public function count()
    {
        $inner = $this->getInnerIterator();
        if ($inner instanceof Countable) {
            return $inner->count();
        }

        return iterator_count($this);
    }
}

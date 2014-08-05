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
 * Class ForeachIterator
 *
 * An Iterator that iterates in a similar manner like otherwise with foreach.
 */
class ForeachIterator extends IteratorIterator
{
    /**
     * For anything foreach-able (Traversable, object & array) in PHP, this returns an Iterator.
     *
     * @param array|object $foreachAble
     *
     * @throws InvalidArgumentException
     * @return Iterator
     */
    public static function getIterator($foreachAble)
    {
        if ($foreachAble instanceof Iterator) {
            return $foreachAble;
        }

        if ($foreachAble instanceof Traversable) {
            return new IteratorIterator($foreachAble);
        }

        if (is_array($foreachAble) || is_object($foreachAble)) {
            return new ArrayIterator($foreachAble);
        }

        throw new InvalidArgumentException(sprintf('%s is not foreachable', gettype($foreachAble)));
    }

    /**
     * For anything foreach-able (Traversable, object & array) in PHP, this returns a Traversable.
     *
     * @param array|object $foreachAble
     *
     * @throws InvalidArgumentException
     * @return Traversable
     */
    public static function getTraversable($foreachAble)
    {
        if ($foreachAble instanceof Traversable) {
            return $foreachAble;
        }

        if (is_array($foreachAble) || is_object($foreachAble)) {
            return new ArrayIterator($foreachAble);
        }

        throw new InvalidArgumentException(sprintf('%s is not foreachable', gettype($foreachAble)));
    }

    public function __construct($foreachAble)
    {
        parent::__construct(self::getTraversable($foreachAble));
    }
}

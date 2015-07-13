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
 * Class OuterInnerIterator
 *
 * iterate over the decorator of an iterator to decorate the inner-iterator of it
 */
class OuterInnerIterator extends IteratorIterator
{
    /**
     * @var OuterIterator
     */
    private $iterator;

    public function __construct(OuterIterator $iterator)
    {
        $inner = $iterator->getInnerIterator();

        if (!$inner instanceof OuterIterator) {
            throw new InvalidArgumentException(sprintf(
                    'OuterIterator of an OuterIterator required for outer-inner iteration, %s given', get_class($inner)
                )
            );
        }

        $this->iterator = $inner;

        parent::__construct($iterator);
    }

    public function current()
    {
        return $this->iterator->getInnerIterator()->current();
    }

    public function key()
    {
        return $this->iterator->getInnerIterator()->key();
    }
}

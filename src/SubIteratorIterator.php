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
 * Class SubIteratorIterator
 */
class SubIteratorIterator extends TraversableDecorator
{
    const UP = 0;
    const DOWN = 1;
    const USE_ITERATOR = 0;
    const USE_KEY = 1;

    /**
     * @var RecursiveIteratorIterator
     */
    private $iterator;

    private $flags;
    private $direction;

    public function __construct(RecursiveIteratorIterator $iterator, $flags = self::USE_ITERATOR, $direction = self::UP)
    {
        $this->iterator  = $iterator;
        $this->flags     = (int)$flags;
        $this->direction = (int)(bool)$direction;

        parent::__construct();
    }

    public function rewind()
    {
        $low  = 0;
        $high = $this->iterator->getDepth();

        if ($this->direction === self::DOWN) {
            list($high, $low) = array($low, $high);
        }

        $this->traversable = new RangeIterator($low, $high, 1);
    }

    public function current()
    {
        $level = parent::current();

        $subIterator = $this->iterator->getSubIterator($level);

        return ($this->flags & self::USE_KEY) ? $subIterator->key() : $subIterator;
    }
}
